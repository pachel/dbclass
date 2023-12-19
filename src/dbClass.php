<?php

/**
 * Created by László Tóth
 */

namespace Pachel;

use Pachel\dbClass\Callbacks\paramsCallback;
use Pachel\dbClass\Callbacks\queryCallback;
use Pachel\dbClass\Callbacks\settingsCallback;
use Pachel\dbClass\dataModel\Traits\setget;
use Pachel\dbClass\Models\fieldList;
use Pachel\dbClass\queryData;
use Pachel\dbClass\Traits\saveToClass;
use Pachel\dbClass\Traits\settingsMethods;

class dbClass
{

    protected $db_username = "", $db_password = "", $db_dsn = "";
    protected $pdo;
    public const
        DB_RESULT_TYPE_ARRAY    = 0,
        DB_RESULT_TYPE_OBJECT   = 1;
    protected $DB_RESULT_TYPE_DEFAULT = 0;

    private $_RESULT_TYPE;
    private static $self = null;
    private $_timelog = false;
    private $_timelogFile = "";
    private $_time = 0;
    protected $cache = ["time" => 0, "dir" => null];

    /**
     * @var queryData $_query_info;
     */
    private $_query_info;

    private $_saveClassDir;
    private $_modelDir;
    /**
     *
     */
    use settingsMethods;
    use setget;
    use saveToClass;
    public static function instance()
    {

        if (empty(self::$self)) {
            $ref = new \Reflectionclass(dbClass::class);
            $args = func_get_args();
            self::$self = ($args ? $ref->newinstanceargs($args) : new dbClass());
        }
        return self::$self;
    }
//*asdasdasd
//asdasd
    public function __construct()
    {
        $args = func_get_args();
        $this->_query_info = new \stdClass();

        if (!empty($args)) {
            $this->connect($args[0], (!empty($args[1]) ? $args[1] : []));
        }
        else{
            if(class_exists("Pachel\\EasyFrameWork\\Base")){
                $d = \Pachel\EasyFrameWork\Base::instance()->env("PDBCLASS");
                $this->connect($d["SERVER"], (!empty($d["OPTIONS"]) ? $d["OPTIONS"] : []));
            }
        }
    }

    protected function setCache($seconds, $dir)
    {
        $this->cache = [
            "time" => $seconds,
            "dir" => $dir
        ];
    }


    public function settings(){
        return new settingsCallback($this);
    }
    protected function getModell($name)
    {
        return new datamodell($name, $this);
    }

    protected function callModell($className, $param)
    {

        $r = new \ReflectionClass($className);
        $obj = $r->newInstanceArgs([$this, $param]);
        return $obj;
    }

    /**
     * @param $sql
     * @param null $field
     * @param array $params
     * @return array
     * @throws \Exception
     */
    protected function fromDatabase($sql, $field = NULL, $params = [], $id = null)
    {
        if (!$sql) {
            throw new \Exception('sql statement missing!');
        }

        if (is_array($field)) {
            $tmp = $params;
            $params = $field;
            $field = $tmp;
        }
        $params = $this->objectToArray($params);

        if ($this->cache["time"] > 0) {
            if(!is_dir($this->cache["dir"])){
                mkdir($this->cache["dir"]);
            }
            $hash = md5($sql . serialize($field) . serialize($params) . serialize($id));
            $file = $this->cache["dir"] . $hash . ".tmp";
            if (is_file($file)) {
                if ((time() - filemtime($file)) <= $this->cache["time"]) {
                    return unserialize(file_get_contents($file));
                }
                else{
                    unlink($file);
                }
            }

        }
        $this->starttime($sql,$params);
        $resultArray = array();

        $this->check_params($params, $sql);

        $result = $this->pdo->prepare($sql);
        $result->execute($params);
        $this->stoptime();
        if ($field == '@flat') {
            if ($result->rowCount()) {

                while ($temp = $result->fetch(\PDO::FETCH_NUM)) {
                    $resultArray[] = $temp;
                }

                goto end;

            } else {
                goto end;
            }
        }
        if ($field == '@simple') {
            if ($result->rowCount()) {
                $temp = $result->fetch(\PDO::FETCH_ASSOC);
                $resultArray = array_values($temp);
                $resultArray = $resultArray[0];
                goto end;
                //
            } else {
                goto end;
                //return [];
            }
        }
        if ($field == '@line') {
            if ($result->rowCount()) {
                $resultArray = $result->fetch(($this->_RESULT_TYPE == self::DB_RESULT_TYPE_OBJECT?\PDO::FETCH_OBJ:\PDO::FETCH_ASSOC));
                goto end;
                return ($resultArray);
            } else {
                goto end;
                return [];
            }
        }
        if ($field == '@group' && $id != null) {
            if ($result->rowCount()) {
                while ($temp = $result->fetch(\PDO::FETCH_ASSOC)) {
                    $resultArray[$temp[$id]] = $temp;
                }
                goto end;
                return ($resultArray);
            }
        }
        if ($field == '@array') {
            if ($result->rowCount()) {
                while ($temp = $result->fetch(\PDO::FETCH_NUM)) {
                    $resultArray[] = $temp[0];
                }
                goto end;
                return ($resultArray);
            }
        }
        $i = 0;
        if ($result->rowCount()) {
            while ($temp = $result->fetch(($this->_RESULT_TYPE == self::DB_RESULT_TYPE_OBJECT?\PDO::FETCH_OBJ:\PDO::FETCH_ASSOC))) {
                $resultArray[$i] = $temp;
                $i++;
            }
            goto end;
            return ($resultArray);
        }

        end:
        if ($this->cache["time"] > 0) {
            file_put_contents($file,serialize($resultArray));
        }
        return $resultArray;
    }

    /**
     * @param
     * $params [array] : array of parameters to substitute
     * @return: return value of mysql_query
     */
    protected function toDatabase($sql, $params = array())
    {
        $this->starttime($sql,$params);
        $mysql_queryPrepared = $this->pdo->prepare($sql);
        $mysql_queryReturn = $mysql_queryPrepared->execute($params);
        //do we have a db error?
        $err = $mysql_queryReturn;
        $this->stoptime();
        if (!$err) {
            //error occured, show the error:
            $error = $mysql_queryPrepared->errorInfo();
            throw new \Exception("MYSQL ERROR: " . $error[2] . "\n");
        }
        return (true);
    }
    private function objectToArray($object)
    {
        if(is_array($object)){
            return $object;
        }
        $array = [];
        foreach ($object AS $key=>$value){
            $array[$key] = $value;
        }
        return $array;
    }
    /**
     * @param $array
     * @param $table
     * @param $id Wenn das nicht null, dann wird das UPDATE, sonder INSERT
     */
    private function arrayToDatabase($array, $table, $id = array())
    {
        if(is_object($array)){
            $array = $this->objectToArray($array);
        }if(is_object($id)){
            $id = $this->objectToArray($id);
        }
        if (!is_array($array)) {
            throw new \Exception('$array is not Array()');
        }
        if (empty($table)) {
            throw new \Exception('$table parameter is empty!');
        }
        if (gettype($table) != "string") {
            throw new \Exception('$table parameter type is not string!');
        }
        $this->check_params($array);

        if (sizeof($id) == 0) {
            $query = "INSERT INTO `" . $table . "` (";
            $x = 0;
            foreach ($array as $key => $value) {
                if ($x > 0) {
                    $query .= ",";
                }
                $query .= "`" . $key . "`";
                $x++;
            }
            $query .= ") VALUES (";
            $x = 0;
            foreach ($array as $key => $value) {
                if ($x > 0) {
                    $query .= ",";
                }
                $query .= ":" . $key . "";
                $x++;
            }
            $query .= ")";
        } else {
            $query = "UPDATE `" . $table . "` SET ";
            $x = 0;
            foreach ($array as $key => $value) {
                if ($x > 0) {
                    $query .= ",";
                }
                $query .= "`" . $key . "`=:" . $key;
                $x++;
            }
            $k = array_keys($id);

            //$query .= " WHERE " . $k[0] . "=:" . $k[0];
            $query .= " WHERE " .$this->get_where($id,$array);
            //$array[$k[0]] = $id[$k[0]];
        }

        return $this->toDatabase($query, $array);
    }


    /**
     * Check if all parameters exists
     *
     * @param $config
     * @throws \Exception
     */
    private function check_db_config(&$config)
    {
        $default_config = [
            "HOST" => "localhost",
            "DBNAME" => "",
            "CHARSET" => "utf8",
            "USERNAME" => "",
            "PASSWORD" => ""
        ];
        $c  = [];
        foreach ($config as $index => $value){
            $c[strtoupper($index)] = $value;
        }
        $config = $c;
        foreach ($default_config as $index => $value) {
            if (!isset($config[$index]) && empty($value)) {
                throw new \Exception($index . " in parameterlist not found");
            }
            if (!isset($config[$index])) {
                $config[$index] = $value;
            }
        }
        if(isset($config["DEFAULT_RESULT_MODE"]) && is_numeric($config["DEFAULT_RESULT_MODE"])){
            $this->settings()->setDefaultResultMode($config["DEFAULT_RESULT_MODE"]);
        }

        $this->_RESULT_TYPE = $this->DB_RESULT_TYPE_DEFAULT;

        if(isset($config["SAVECLASSDIR"]) && is_dir($config["SAVECLASSDIR"])){
            $this->_saveClassDir = $this->checkSlash($config["SAVECLASSDIR"]);
        }
        if(isset($config["QUERYCLASSDIR"]) && is_dir($config["QUERYCLASSDIR"])){
            $this->_saveClassDir = $this->checkSlash($config["QUERYCLASSDIR"]);
        }
        if(isset($config["MODELDIR"]) && is_dir($config["MODELDIR"])){
            $this->_modelDir = $this->checkSlash($config["MODELDIR"]);
        }
        $this->db_username = $config["USERNAME"];
        $this->db_password = $config["PASSWORD"];
        $this->db_dsn = 'mysql:host=' . $config['HOST'] . ';dbname=' . $config['DBNAME'] . ";charset=" . $config['CHARSET'];
    }
    private function checkSlash($dir) {
        if (mb_substr($dir, strlen($dir) - 1, 1) == "/") {
            return $dir;
        }
        return $dir . "/";
    }

    /**
     * @param $data
     * @param null $query
     */
    private function check_params(&$data, &$query = null)
    {


        foreach ($data as $index => $item) {
            check:

            if (!empty($query) && preg_match_all("/:" . $index . "/", $query, $preg)) {
                if (count($preg[0]) > 1) {
                    $new_name = $this->get_random_string();
                    $query = preg_replace("/:" . $index . "/", ":" . $new_name, $query, 1);
                    $data[$new_name] = $item;
                    goto check;
                }
            }
        }
        //echo $query;
        //print_r($data);
    }

    /**
     * @param $table
     * @param $data
     * @param $where
     * @return bool
     * @throws \Exception
     */
    public function update($table, $data, $where)
    {
        return $this->arrayToDatabase($data, $table, $where);
    }

    /**
     * @param $table
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function insert($table, $data)
    {
        return $this->arrayToDatabase($data, $table);
    }

    /**
     * @param $table
     * @param $where
     */
    public function delete($table, $where)
    {
        $sql = "DELETE FROM `" . $table . "` WHERE " . $this->get_where($where,$params);
        return $this->toDatabase($sql,$params);
    }

    /**
     * @param $table
     * @param string $where
     * @param string $fields
     * @return array
     * @throws \Exception
     */
    public function select($table, $where = "", $fields = "*")
    {
        $query = "SELECT " . $fields . " FROM `" . $table . "`";
        $params = [];
        if (!empty($where)) {
            $query .= " WHERE " . $this->get_where($where, $params);
        }
        return $this->fromDatabase($query, $params);
    }

    /**
     * @param $where
     * @param array|object $params
     * @return string
     */
    protected function get_where($where, &$params = [])
    {
        $string = "";
        $params_copy = $params;
        $where = $this->objectToArray($where);
        if (is_array($where)) {
            $counter = 0;
            foreach ($where as $index => $value) {
                $sid = "RND".$this->get_random_string(20);
                if ($counter > 0) {
                    $string .= " AND ";
                }
                if(empty($params)){
                    $params_copy[$sid] =$value;
                    $string .= "`" . $index . "`" . (is_numeric($value) ? "=" . $value : " LIKE '" . $value."'");
                   // $string .= "`" . $index . "`=:" .$sid;
                }
                else {
                    $string .= "`" . $index . "`" . (is_numeric($value) ? "=:" . $sid : " LIKE :" . $sid);
                    $params[$sid] = $value;
                }
                $counter++;
            }
        } else {
            $string = $where;
        }
       // $params = $params_copy;
        return $string;
    }



    public function __destruct()
    {
        $this->disconnect();
    }

    private function starttime($sql,$params){
        if(!$this->_timelog){
            return;
        }
        $this->_timeinfo = [
            "sql"=>$sql,
            "params"=>$params
        ];
        // echo microtime(true);
        $this->_time = microtime(true);
    }
    private function stoptime(){
        if(!$this->_timelog){
            return;
        }
        $time = round((microtime(true)-$this->_time),4);
        $debug = debug_backtrace();
        foreach ($debug AS $sor){
            file_put_contents($this->_timelogFile,"FILE:".$sor["file"].":(".$sor["line"].")".$sor["function"]."()\n",FILE_APPEND);
        }
        file_put_contents($this->_timelogFile,"TIME:".$time."s\n",FILE_APPEND);
    }
    private function get_random_string($count = 10, $chars = "qwertzuioplkjhgfdsayxcvbnm0123456789QWERTZUIOPLKJHGFDSAYXCVBNM")
    {
        $string = "";
        for ($x = 0; $x < $count; $x++) {
            $string .= substr($chars, mt_rand(0, strlen($chars)), 1);
        }
        return $string;
    }

    public function last_insert_id()
    {
        return $this->pdo->lastInsertId();
    }
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->$name(...$arguments);
        }
    }
    public function query($sql)
    {
        $this->_query_info->query = $sql;
        $this->_query_info->params = [];

        return new queryCallback($this);
    }
    protected function _exec(){
        return $this->toDatabase($this->_query_info->query,$this->_query_info->params);
    }
    protected function _params(){
        $args = func_get_args();
        foreach ($args AS $arg){
            if(is_array($arg)){
                $params = $arg;
                break;
            }elseif(is_object($arg)){
                $params = $this->objectToArray($arg);
                break;
            }
            $params[] = $arg;
        }
        $this->_query_info->params = $params;
        return new paramsCallback($this);
    }
    protected function _get(string $type)
    {
        switch ($type) {
            case "line":
                $type = "@line";
                break;
            case "simple":
                $type = "@simple";
                break;
            case "array":
                $type = "@array";
                break;
            default:
                $type = "@row";
        }
        return $this->fromDatabase($this->_query_info->query, $type,$this->_query_info->params);
    }

}

<?php
/**
 * Created by László Tóth
 */

namespace Pachel;


class dbClass
{
    protected $db_username = "",$db_password = "",$db_dsn = "";

    protected $pdo;


    private static $self = null;

    /**
     *
     */
    public static function instance()
    {
        if(empty(self::$self)){

            $ref = new \Reflectionclass("Pachel\dbClass");
            $args = func_get_args();
            self::$self = ($args ?$ref -> newinstanceargs($args):new dbClass());

        }
        return self::$self;
    }
    public function __construct()
    {
        $args = func_get_args();
        if(!empty($args)){
            $this->connect($args[0],(!empty($args[1])?$args[1]:[]));
        }
    }

    /**
     *
     * @param $db_config
     * @param array $db_options
     * @throws \Exception
     */
    public function connect($db_config,$db_options = [])
    {
        $this->check_db_config($db_config);
        $this->pdo = new \PDO($this->db_dsn, $this->db_username, $this->db_password, $db_options);
    }
    public function getModell($name){
        return new datamodell($name,$this);
    }

    /**
     * @param $sql
     * @param null $field
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fromDatabase($sql, $field = NULL,$params = [])
    {
        if ( !$sql) {
            throw new \Exception('sql statement missing!');
        }

        if(is_array($field)){
            $tmp = $params;
            $params = $field;
            $field = $tmp;
        }

        $resultArray = array();
        $this->check_params($params,$sql);
     //   echo $sql;
        $result = $this->pdo->prepare($sql);
        $result->execute($params);

        if ($field == '@flat') {
            if ($result->rowCount()) {
                while ($temp = $result->fetch(\PDO::FETCH_ASSOC)) {
                    $resultArray[$temp[0]] = $temp[1];
                }
                return ($resultArray);
            } else {
                return [];
            }
        }
        if ($field == '@simple') {
            if ($result->rowCount()) {
                $temp = $result->fetch(\PDO::FETCH_ASSOC);
                $resultArray = array_values($temp);
                return ($resultArray[0]);
            } else
            {
                return [];
            }
        }
        if ($field == '@line') {
            if ($result->rowCount()) {
                $resultArray = $result->fetch(\PDO::FETCH_ASSOC);
                return ($resultArray);
            } else {
                return [];
            }
        }

        $i = 0;
        if ($result->rowCount()) {
            while ($temp = $result->fetch(\PDO::FETCH_ASSOC)) {
                $resultArray[$i] = $temp;
                $i++;
            }
        }
        return ($resultArray);

        return [];
    }

    /**
     * @param
     * $params [array] : array of parameters to substitute
     *
     * @return: return value of mysql_query
     */
    public function toDatabase($sql, $params = array())
    {
        $mysql_queryPrepared = $this->pdo->prepare($sql);
        $mysql_queryReturn = $mysql_queryPrepared->execute($params);
        //do we have a db error?
        $err = $mysql_queryReturn;
         if ( !$err) {
            //error occured, show the error:
            $error = $mysql_queryPrepared->errorInfo();            
            throw new \Exception("MYSQL ERROR: ".$error[2]."\n");
        }
        return (true);

    }
    /**
     * @param $array
     * @param $table
     * @param $id Wenn das nicht null, dann wird das UPDATE, sonder INSERT
     */
    private function arrayToDatabase($array,$table,$id = array()){
        if(!is_array($array)){
            throw new \Exception('$array is not Array()');
        }
        if(empty($table)){
            throw new \Exception('$table parameter is empty!');
        }
        if(gettype($table)!="string"){
            throw new \Exception('$table parameter type is not string!');
        }
        $this->check_params($array);

        if(sizeof($id) == 0){
            $query = "INSERT INTO `".$table."` (";
            $x = 0;
            foreach ($array AS $key => $value){
                if($x>0){
                    $query.=",";
                }
                $query.="`".$key."`";
                $x++;
            }
            $query.=") VALUES (";
            $x=0;
            foreach ($array AS $key => $value){
                if($x>0){
                    $query.=",";
                }
                $query.=":".$key."";
                $x++;
            }
            $query.=")";
        }
        else{
            $query = "UPDATE `".$table."` SET ";
            $x = 0;
            foreach ($array AS $key => $value){
                if($x>0){
                    $query.=",";
                }
                $query.="`".$key."`=:".$key;
                $x++;
            }
            $k = array_keys($id);
            $query.=" WHERE ".$k[0]."=:".$k[0];
            $array[$k[0]] = $id[$k[0]];
        }

        return $this->toDatabase($query,$array);
    }

    /**
     * Check if all parameters exists
     *
     * @param $config
     * @throws \Exception
     */
    private function check_db_config(&$config){
        $default_config = [
            "host" => "localhost",
            "dbname" => "",
            "charset" => "utf8",
            "username" => "",
            "password" => ""
        ];
        foreach ($default_config AS $index=>$value){
            if(!isset($config[$index]) && empty($value)){
                throw new \Exception($index." in parameterlist not found");
            }
            if(!isset($config[$index])){
                $config[$index] = $value;
            }
        }
        $this->db_username = $config["username"];
        $this->db_password = $config["password"];
        $this->db_dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'].";charset=" . $config['charset'];
    }

    /**
     * @param $data
     * @param null $query
     */
    private function check_params(&$data,&$query = null){

        foreach ($data AS $index => $item){
            check:
            if(preg_match_all("/:".$index."/",$query,$preg)) {
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
    public function update($table,$data,$where){
        return $this->arrayToDatabase($data,$table,$where);
    }

    /**
     * @param $table
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function insert($table,$data){
        return $this->arrayToDatabase($data,$table);
    }

    /**
     * @param $table
     * @param $where
     */
    public function delete($table,$where){
        $sql = "DELETE FROM `".$table."` WHERE ".$this->get_where($where);
        return $this->toDatabase($sql);
    }

    /**
     * @param $table
     * @param string $where
     * @param string $fields
     * @return array
     * @throws \Exception
     */
    public function select($table,$where = "",$fields = "*"){
        $query = "SELECT ".$fields." FROM `".$table."`";
        $params = [];
        if(!empty($where)){
            $query.=" WHERE ".$this->get_where($where,$params);
        }
        return $this->fromDatabase($query,$params);
    }

    /**
     * @param $where
     * @param array $params
     * @return string
     */
    private function get_where($where,&$params = []){
        $string = "";
        if(is_array($where)){
            $counter = 0;
            foreach ($where AS $index => $value){
                if($counter>0){
                    $string.=" AND ";
                }
                $string.="`".$index."`".(is_numeric($value)?"=".$value:" LIKE '".$value."'");
                $counter++;
            }
        }
        else{
            $string = $where;
        }
        return $string;
    }

    /**
     * Connection disconnect
     */
    public function disconnect(){
        $this->pdo = null;
    }
    public function __destruct()
    {
        $this->disconnect();
    }
    private function get_random_string($count = 10,$chars = "qwertzuioplkjhgfdsayxcvbnm0123456789QWERTZUIOPLKJHGFDSAYXCVBNM"){
        $string = "";
        for ($x=0;$x<$count;$x++){
            $string.=substr($chars,mt_rand(0,strlen($chars)),1);
        }
        return $string;
    }
    public function last_insert_id(){
        return $this->pdo->lastInsertId();
    }
}
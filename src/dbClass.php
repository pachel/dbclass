<?php

/**
 * Created by László Tóth
 */

namespace Pachel\db;

class dbClass
{
    /**
     * @var \PDO
     */
    protected \PDO  $pdo;

    protected $cache = ["time"=>0,"dir"=>null];

    private static Array $db_config;
    /**
     * @var dbClass|null
     */
    private static ?dbClass $self = null;

    /**
     * @var
     */
    private $parameters = null;
    /**
     * @var string
     */
    private $selectFields;
    /**
     * @var
     */
    private $fromTables;

    use Select;
    use From;
    use Where;
    use OrderBy;
    use Exec;
    use SetParams;

    /**
     * @return dbClass
     */
    public static function instance():dbClass
    {
        if (empty(self::$self)) {
            self::$self = new dbClass();
        }
        return self::$self;
    }
    public function setCache($seconds,$cache_dir){
        $this->cache = [
            "time"=>$seconds,
            "dir"=>$cache_dir
        ];
    }
    public static function setConfig(string $file){
        if(!file_exists($file) && !is_file($file)){
            new \Exception("Config file not exists: ".$file);
        }
        self::$db_config = require_once $file;
    }
    public function __construct()
    {

        $this->connect();
    }

    /**
     *
     * @param $db_config
     * @param array $db_options
     * @throws \Exception
     */
    private function connect():void
    {
        $this->pdo = new \PDO(self::$db_config["access"]["dbname"], self::$db_config["access"]["username"], self::$db_config["access"]["password"]);
    }

    /**
     * @param $sql
     * @param null $field
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function fromDatabase($sql, $field = NULL, $params = [], $id = null)
    {
        if (!$sql) {
            throw new \Exception('sql statement missing!');
        }

        if (is_array($field)) {
            $tmp = $params;
            $params = $field;
            $field = $tmp;
        }
        if($this->cache["time"]>0){
            $hash = md5($sql.serialize($field).serialize($params).serialize($id));

        }

        $resultArray = array();
        $this->check_params($params, $sql);
        //   echo $sql;
        $result = $this->pdo->prepare($sql);
        $result->execute($params);

        if ($field == '@flat') {
            if ($result->rowCount()) {
                while ($temp = $result->fetch(\PDO::FETCH_NUM)) {
                    $resultArray[] = $temp;
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
            } else {
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
        if ($field == '@group' && $id != null) {
            if ($result->rowCount()) {
                while ($temp = $result->fetch(\PDO::FETCH_ASSOC)) {
                    $resultArray[$temp[$id]] = $temp;
                }
                return ($resultArray);
            }
        }
        if ($field == '@array') {
            if ($result->rowCount()) {
                while ($temp = $result->fetch(\PDO::FETCH_NUM)) {
                    $resultArray[] = $temp[0];
                }
                return ($resultArray);
            }
        }
        $i = 0;
        if ($result->rowCount()) {
            while ($temp = $result->fetch(\PDO::FETCH_ASSOC)) {
                $resultArray[$i] = $temp;
                $i++;
            }
            return ($resultArray);
        }


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
        if (!$err) {
            //error occured, show the error:
            $error = $mysql_queryPrepared->errorInfo();
            throw new \Exception("MYSQL ERROR: " . $error[2] . "\n");
        }
        return (true);
    }

    /**
     * @param $array
     * @param $table
     * @param $id Wenn das nicht null, dann wird das UPDATE, sonder INSERT
     */
    private function arrayToDatabase($array, $table, $id = array())
    {
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
            $query .= " WHERE " . $k[0] . "=:" . $k[0];
            $array[$k[0]] = $id[$k[0]];
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
            "host" => "localhost",
            "dbname" => "",
            "charset" => "utf8",
            "username" => "",
            "password" => ""
        ];
        foreach ($default_config as $index => $value) {
            if (!isset($config[$index]) && empty($value)) {
                throw new \Exception($index . " in parameterlist not found");
            }
            if (!isset($config[$index])) {
                $config[$index] = $value;
            }
        }
        $this->db_username = $config["username"];
        $this->db_password = $config["password"];
        $this->db_dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ";charset=" . $config['charset'];
    }

    /**
     * @param $data
     * @param null $query
     */
    private function check_params(&$data, &$query = null)
    {

        foreach ($data as $index => $item) {
            check:
            if (preg_match_all("/:" . $index . "/", $query, $preg)) {
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
        $sql = "DELETE FROM `" . $table . "` WHERE " . $this->get_where($where);
        return $this->toDatabase($sql);
    }




    /**
     * @param $where
     * @param array $params
     * @return string
     */
    private function get_where($where, &$params = [])
    {
        $string = "";
        if (is_array($where)) {
            $counter = 0;
            foreach ($where as $index => $value) {
                if ($counter > 0) {
                    $string .= " AND ";
                }
                $string .= "`" . $index . "`" . (is_numeric($value) ? "=" . $value : " LIKE '" . $value . "'");
                $counter++;
            }
        } else {
            $string = $where;
        }
        return $string;
    }

    public function __destruct()
    {
        $this->pdo = null;
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

}

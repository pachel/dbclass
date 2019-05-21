<?php
/**
 * v 1.0
 * Created by László Tóth
 */

namespace Pachel\dbClass;

class dbClass extends \PDO
{
    protected $db_username = "",$db_password = "",$db_dsn = "";
    public function __construct($db_config,$db_options = [])
    {
        $this->check_db_config($db_config);
        parent::__construct($this->db_dsn, $this->db_username, $this->db_password, $db_options);
    }


    /**
     * Get Data from Database
     *
     * @param string      $sql                  : already properly escaped sql string
     * @param bool|string $field                : array key by field value
     * @param array       $params               : Set Array of Query Params
     * @param bool        $useLastSql           : Use last executed Statement
     * @param bool        $html                 : if values should have encoded html special chars
     * @param bool|string $groupby              : field name on which result is grouped by
     * @param bool        $withNumRows          : saves numRows inside parameters if set
     * @param bool        $doNotCheckDataStatus : if data_status must be contained within where clause
     * @param bool        $rewriteForViews      : if sql should be rewritten to fetch data from personal view
     *
     * @return array|bool (array,array key = id)/false if no value
     * !special value for field="@flat"; if set, an array result like [column1]=column2 is returned, only possible
     * for 2 column queries
     * !special value for field="@simple"; if result is just a single value this value is returned
     * !special value for field="@line"; only one line is returned
     * !special value for field="@raw"; all result lines are returned within a numbered index array
     */
    public function fromDatabase($sql, $params = array(),$field = false)
    {
        if ( !$sql) {
            throw new \Exception('sql statement missing!');
        }


        $resultArray = array();
        $this->check_params($sql,$params);
        $result = $this->prepare($sql);
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
        $mysql_queryPrepared = $this->prepare($sql);
        $mysql_queryReturn = $mysql_queryPrepared->execute($params);
        //do we have a db error?
        $err = $mysql_queryReturn;
        if ( !$err) {
            //error occured, show the error:
            throw new \Exception("Error");
        }
        return (true);

    }
    /**
     * @param $array
     * @param $table
     * @param $id Wenn das nicht null, dann wird das UPDATE, sonder INSERT
     */
    public function arrayToDatabase($array,$table,$id = array()){
        if(!is_array($array)){
            throw new \Exception('$array is not Array()');
        }
        if(empty($table)){
            throw new \Exception('$table parameter is empty!');
        }
        if(gettype($table)!="string"){
            throw new \Exception('$table parameter type is not string!');
        }

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
    private function check_params(&$query,&$params){

    }
}
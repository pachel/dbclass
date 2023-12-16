<?php

namespace Pachel\dbClass\Traits;

use mysql_xdevapi\Exception;
use Pachel\dbClass\Models\fieldList;

trait settingsMethods
{
    private function _modelgeneral($table, $filename = null, $classname = null)
    {
        /**
         * @var fieldList[] $result
         */
        $sql = "SHOW COLUMNS FROM `" . $table . "`";
        $this->settings()->setResultmodeToObject();
        $result = $this->query($sql)->rows();
        $this->settings()->setResultmodeToDefault();
        if (empty($result)) {
            return;
        }
        if ($classname == null) {
            $classname = $table;
        }
        if($filename == null){
            if(empty($this->_modelDir) || !is_dir($this->_modelDir)){
                new \Exception("A mentés mappája nincs paraméterezve");
            }
            $filename = $this->_modelDir."_".$classname."Model.php";
        }
        if(is_file($filename)){
            new \Exception("A ".$filename." már létezik!");
        }
        $text = "";
        $equal = "";
        $like = "";
        foreach ($result as $sor) {
            $text .= "/**\n";
            if ($sor->Key == "PRI") {
                $key = $sor->Field;
                $text .= " * Primary ID ----------------------------------------\n";
            }
            $type = $this->getType($sor->Type);
            $text .= " * @property " . $type . " \$" . $sor->Field . "\n";
           // $text .= "\tpublic \$" . $sor->Field . ";\n";
            if ($this->isNum($type)) {
                $equal .= " * @method " . $classname . "DataModel[] " . $sor->Field . "(" . $type . " \$" . $sor->Field . ")\n";
            } else {
                $equal .= " * @method " . $classname . "DataModel[] " . $sor->Field . "(" . $type . " \$" . $sor->Field . ")\n";
                $like .= " * @method " . $classname . "DataModel[] " . $sor->Field . "(" . $type . " \$" . $sor->Field . ")\n";
            }
        }

        $content = str_replace(["#datum", "#table", "#primary", "#variables", "#classname", "#equalmethods", "#likemethods"], [date("Y-m-d H:i"), $table, $key, $text, $classname, $equal, $like], file_get_contents(__DIR__ . "/../../tpl/modelclass.tpl"));
        file_put_contents($filename, $content);
    }

    private function isNum($type)
    {
        if (preg_match("/^int|double|float|bigint|smallint$/i", $type)) {
            return true;
        }
        return false;
    }

    private function getType($type): string
    {
        $return = "string";
        preg_match("/([a-z]+)/", $type, $preg);
        if (preg_match("/int/", $preg[1])) {
            $return = "int";
        }
        switch ($preg[1]) {
            case "int":
                $return = "int";
                break;
            case "double":
                $return = "float";
                break;
            case "float":
                $return = "float";
                break;
        }


        return $return;
    }

    protected function _setresultmode(int $mode)
    {
        $this->_RESULT_TYPE = $mode;
    }

    protected function _setresultdefault(int $mode)
    {
        $this->DB_RESULT_TYPE_DEFAULT = $mode;
    }

    protected function _setcache($seconds, $dir)
    {
        $this->setCache($seconds, $dir);
    }
    protected function timelog($filename){
        if(!is_writable($filename)){
                 return;
        }
        $this->_timelog = true;
        $this->_timelogFile = $filename;
    }
    /**
     *
     * @param $db_config
     * @param array $db_options
     * @throws \Exception
     */
    protected function connect($db_config, $db_options = [])
    {
        $this->check_db_config($db_config);
        $this->pdo = new \PDO($this->db_dsn, $this->db_username, $this->db_password, $db_options);
    }
    /**
     * Connection disconnect
     */
    protected function disconnect()
    {
        $this->pdo = null;
    }
}
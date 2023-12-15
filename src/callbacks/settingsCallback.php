<?php
namespace Pachel\dbClass\Callbacks;
class settingsCallback extends CallbackBase{
    public function setResultmodeToArray(){
        $this->class->_setresultmode($this->class::DB_RESULT_TYPE_ARRAY);
    }
    public function setResultmodeToObject(){
        $this->class->_setresultmode($this->class::DB_RESULT_TYPE_OBJECT);
    }

    /**
     * @param int $resultMode
     * @return void
     */
    public function setDefaultResultMode(int $resultMode){
        $this->class->_setresultdefault($resultMode);
    }
    public function setResultmodeToDefault(){
        $this->class->_setresultmode($this->class::$DB_RESULT_TYPE_DEFAULT);
    }
    public function setCache($seconds,$dir){
        $this->class->_setcache($seconds,$dir);
    }
    public function generateModelClass($table,$filename){
        $this->class->_modelgeneral($table,$filename);
    }
    public function timelog($filename){
        $this->class->timelog($filename);
    }
    public function connect($db_config, $db_options = []){
        $this->class->connect($db_config, $db_options = []);
    }
    public function disconnect(){
        $this->class->disconnect();
    }
}
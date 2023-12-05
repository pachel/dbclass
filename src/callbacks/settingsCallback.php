<?php
namespace Pachel\dbClass\Callbacks;
class settingsCallback extends CallbackBase{
    public function setResultmodeToArray(){
        $this->class->_setresultmode($this->class::DB_RESULT_TYPE_ARRAY);
    }
    public function setResultmodeToObject(){
        $this->class->_setresultmode($this->class::DB_RESULT_TYPE_OBJECT);
    }
    public function setResultmodeToDefault(){
        $this->class->_setresultmode($this->class::DB_RESULT_TYPE_DEFAULT);
    }
    public function setCache($seconds,$dir){
        $this->class->_setcache($seconds,$dir);
    }
}
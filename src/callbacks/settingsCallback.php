<?php
namespace Pachel\dbClass\Callbacks;
class settingsCallback extends CallbackBase{
    public function setResultmodeToArray(){
        $this->class->setresultmode($this->class::DB_RESULT_TYPE_ARRAY);
    }
    public function setResultmodeToObject(){
        $this->class->setresultmode($this->class::DB_RESULT_TYPE_OBJECT);
    }
    public function setResultmodeToDefault(){
        $this->class->setresultmode($this->class::DB_RESULT_TYPE_DEFAULT);
    }
}
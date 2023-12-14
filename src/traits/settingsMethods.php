<?php

namespace Pachel\dbClass\Traits;

use Pachel\dbClass\Models\fieldList;

trait settingsMethods
{
    private function _modelgeneral($table,$filename,$classname = null){
        /**
         * @var fieldList[] $result
         */
        $sql = "SHOW COLUMNS FROM `".$table."`";
        $this->settings()->setResultmodeToObject();
        $result = $this->query($sql)->rows();
        $this->settings()->setResultmodeToDefault();
        if(empty($result)){
            return;
        }
        if($classname == null){
            $classname = $table;
        }
        $text = "";
        $equal = "";
        $like = "";
        foreach ($result AS $sor){
            $text .= "\t/**\n";
            if($sor->Key == "PRI"){
                $key = $sor->Field;
                $text.="\t* Primary ID ----------------------------------------\n";
            }
            $type = $this->getType($sor->Type);
            $text.= "\t* @var ".$type." \$".$sor->Field.";\n\t**/\n";
            $text.="\tpublic \$".$sor->Field.";\n";
            if($this->isNum($type)){
                $equal.=" * @method ".$classname."DataModel[] ".$sor->Field."(".$type." \$".$sor->Field.")\n";
            }
            else{
                $equal.=" * @method ".$classname."DataModel[] ".$sor->Field."(".$type." \$".$sor->Field.")\n";
                $like.=" * @method ".$classname."DataModel[] ".$sor->Field."(".$type." \$".$sor->Field.")\n";
            }
        }

        $content = str_replace(["#datum","#table","#primary","#variables","#classname","#equalmethods","#likemethods"],[date("Y-m-d H:i"),$table,$key,$text,$classname,$equal,$like],file_get_contents(__DIR__."/../tpl/modelclass.tpl"));
        file_put_contents($filename,$content);
    }
    private function isNum($type){
        if(preg_match("/^int|double|float|bigint|smallint$/i",$type)){
            return true;
        }
        return false;
    }
    private function getType($type):string{
        $return = "string";
        preg_match("/([a-z]+)/",$type,$preg);
        if(preg_match("/int/",$preg[1])){
            $return = "int";
        }
        switch ($preg[1]){
            case "int": $return = "int";break;
            case "double": $return = "float";break;
            case "float": $return = "float";break;
        }


        return $return;
    }

    protected function _setresultmode($mode){
        $this->_RESULT_TYPE = $mode;
    }
    protected function _setresultdefault($mode){
        self::$DB_RESULT_TYPE_DEFAULT = $mode;
    }
}
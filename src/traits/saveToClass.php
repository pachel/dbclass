<?php

namespace Pachel\dbClass\Traits;

trait saveToClass
{
    protected function _saveToClass(){
        if(empty($this->_saveClassDir)){
            new \Exception("Az opció nincs konfigurálva");
        }
        $debug = debug_backtrace();
        $index = 2;
        $d = substr(md5(dirname($debug[$index]["file"])),0,5);
        $classname = "_line".$debug[$index]["line"]."_".str_replace(".","_",basename($debug[$index]["file"]))."_".$d;
        $data = $this->fromDatabase($this->_query_info->query, "@line",$this->_query_info->params);
        $properties = "";
        foreach ($data AS $key => $value){
            $properties.=" * @property \$".$key."\n";
        }

        $content = str_replace(["#date","#properties","#classname"],[date("Y-m-d H:i:s"),$properties,$classname],file_get_contents(__DIR__."/../../tpl/saveclass.tpl"));
        file_put_contents($this->_saveClassDir.$classname.".php",$content);

    }
}
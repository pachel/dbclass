<?php

namespace Pachel\dbClass\Traits;

trait getMethods
{
    public function line()
    {
        return $this->class->_get("line");
    }
    public function rows()
    {
        return $this->class->_get("rows");
    }
    public function assoc()
    {
        return $this->class->_get("assoc");
    }
    public function simple()
    {
        return $this->class->_get("simple");
    }
    public function array()
    {
        return $this->class->_get("array");
    }/*
    public function cache(){

    }*/
    public function saveToClass(){
        $this->class->_saveToClass();
    }
}
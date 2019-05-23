<?php

namespace Pachel;

trait fatfree{
    static function instance() {
        if (class_exists("Registry")&& class_exists("Prefab")) {
            if (!\Registry::exists($class = get_called_class())) {
                $ref = new \Reflectionclass($class);
                $args = func_get_args();
                \Registry::set($class,
                    $args ? $ref->newinstanceargs($args) : new $class);
                dbClass::instance()->set_config();
            }
            return \Registry::get($class);
        }
    }
    private function set_config()
    {
        $mysql = &\Base::instance()->get("mysql");
        dbClass::instance()->connect($mysql);
    }
}

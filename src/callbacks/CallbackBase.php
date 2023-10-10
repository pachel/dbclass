<?php

namespace Pachel\dbClass\Callbacks;
abstract class CallbackBase
{
    protected $class = "";
//    protected $arguments = [];

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function __call(string $name, array $arguments)
    {

        //   $this->class = get_called_class();
        //$arguments = array_merge($this->arguments, $arguments);
        return $this->class->$name(...$arguments);

    }
}
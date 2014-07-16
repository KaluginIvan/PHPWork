<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

class ExtraClass
{
    private static $MyStorage;

    public static function getInstance()
    {
        if(!isset(self::$MyStorage))                    //for first call, if there is no Object, make one
            self::$MyStorage = new MyStorage();

        return self::$MyStorage;
    }
}

$storage = ExtraClass::getInstance();

var_dump($storage);

$storage = ExtraClass::getInstance();

var_dump($storage);
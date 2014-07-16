<?php

class MagicClass
{
    private $magicField1 = 0;
    private $magicField2 = 0;

    public function __construct()
    {
        echo "I was created\n";
    }

    public function __clone()
    {
        echo "I was cloned\n";
    }

    public function __get($name)
    {
        echo "I was asked for $name \n";
    }

    public function __call($name, $arguments)
    {
        echo "I was asked to $name \n";
    }

    public function doMagic()
    {

    }

    public function __toString()
    {
        return "I'M " . __CLASS__ . "\n" ;
    }
}

$magic = new MagicClass();              // __construct

$magicBrother = clone $magic;           // __clone

$magicValue1 = $magic->magicField1;     // __get

$magicValue2 = $magic->magicField2;     // __get

$magic->doMagic();                      // __call

echo $magic;                            // __toString




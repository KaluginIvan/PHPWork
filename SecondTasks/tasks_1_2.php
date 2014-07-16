<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

$storage = new MyStorage();

$storage->storeObject('int',1);
$storage->storeObject('float',2.5);
$storage->storeObject('string','test');
$storage->storeObject('array',array(1,2,3,4));

$storage->removeObject('string');

try {
    echo $storage->getObject('float'), "\n";
    echo $storage->getObject('string'), "\n";
} catch (Exception $e) {
    echo 'Exception: ', $e->getMessage(), "\n";
}
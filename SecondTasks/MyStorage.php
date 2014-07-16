<?php

class MyStorage implements IStorage
{
    private $storage = array();

    public function storeObject($key, $object)
    {
        $this->storage[$key] = $object;
    }

    public function removeObject($key)
    {
        if(isset($this->storage[$key]))                 //if have Object in storage, then delete
            unset($this->storage[$key]);
    }

    public function getObject($key)
    {
        if(!isset($this->storage[$key]))
            throw new Exception("No Object with key '$key' ");
        else
            return $this->storage[$key];
    }
}
<?php

interface IStorage{
    public function storeObject($key, $object);
    public function removeObject($key);
    public function getObject($key);
}
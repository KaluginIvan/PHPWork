<?php

require_once("BaseTable.php");

class Album extends BaseTable
{
    public function __construct()
    {
        $this->tableName = 'album';
        parent::__construct();
    }
}
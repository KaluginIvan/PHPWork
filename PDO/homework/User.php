<?php

require_once("BaseTable.php");
require_once("Album.php");

class User extends BaseTable
{
    public function __construct()
    {
        $this->tableName = 'users';
        $this->relationTable = 'album';
        $this->relationKey = 'user_id';
        $this->relation = new Album();
        parent::__construct();
    }
}
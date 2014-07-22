<?php

class BaseTable
{
    protected $database;
    protected $tableName;
    protected $relations;

    public $attributes;


    public function __construct()
    {
        $this->tableName = 'users';
        $this->database = new PDO('mysql:host=localhost;dbname=myDB','root','123456');
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function findByPk($pk)
    {
        $query = $this->database->prepare("SELECT * FROM `".$this->tableName."` WHERE `id`='".$pk."'");

        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if($data !== false)
            $this->attributes = $data;
        else
            throw new Exception("There is no row with id = " . $pk);

        return $this;
    }

    public function save()
    {
        $keys = array_keys($this->attributes);

        if(!isset($this->attributes['id']))
        {
            $query = $this->database->prepare("INSERT INTO `".$this->tableName."` (`".implode($keys,"`,`")."`) VALUES('".implode($this->attributes,"','")."')");

            $query->execute();

            $this->attributes['id'] = $this->database->lastInsertId();
        }
        else
        {
            $sql = "UPDATE `".$this->tableName."` SET ";

            $attrCount = count($this->attributes);

            foreach($keys as $i=>$cell)
            {
                $sql .= "`".$cell."`='".$this->attributes[$cell]."'";
                if($i !== $attrCount - 1)
                    $sql .= ",";
            }

            $sql .= "WHERE `id`='".$this->attributes['id']."'";

            var_dump($sql);

            $query = $this->database->prepare($sql);

            $query->execute();

            echo "\n";
        }
    }


}
<?php

require_once("iDbConnectable.php");

class BaseTable implements iDbConnectable
{
    protected $database;
    protected $tableName;
    protected $relation;
    protected $relationTable;
    protected $relationKey;
    protected $primaryKey;

    public $attributes;


    public function __construct()
    {
        $this->database = new PDO('mysql:host=localhost;dbname=myDB','root','123456');

        $query = $this->database->prepare("SHOW KEYS FROM ".$this->tableName." WHERE Key_name = 'PRIMARY'");

        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        $this->primaryKey = $data['Column_name'];
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function findByPk($pk)
    {
        $query = $this->database->prepare("SELECT * FROM `".$this->tableName."` WHERE `".$this->primaryKey."`='".$pk."'");

        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if($data !== false)
            $this->attributes = $data;
        else
            throw new Exception("There is no row with pk = " . $pk);

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

            $sql .= "WHERE `".$this->primaryKey."`='".$this->attributes[$this->primaryKey]."'";

            var_dump($sql);

            $query = $this->database->prepare($sql);

            $query->execute();

            echo "\n";
        }
    }

    public function where($attribute, $value, $with=false)
    {
        if($with === false)
        {
            $query = $this->database->prepare("SELECT ".$this->primaryKey." FROM `".$this->tableName."` WHERE `".$attribute."`=:value");
            $query->bindValue(':value', $value);
            $query->execute();

            $data = $query->fetchAll();

            $objects = array();

            foreach($data as $i=>$row)
            {
                $newObj = new User();
                $newObj->findByPk($row[$this->primaryKey]);
                $objects[$i] = $newObj;
            }

            return $objects;
        }
        else
        {
            $query = $this->database->prepare("SELECT ".$this->relationTable.".".$this->relation->primaryKey." FROM ".$this->tableName." INNER JOIN ".$this->relationTable." ON ".."");
            var_dump($query);
        }
        /*$query = $this->database->prepare("SELECT users.id, album.id FROM users INNER JOIN album ON users.id = album.user_id");
        $query->execute();

        $data = $query->fetchAll();

        var_dump($data);*/
    }
}
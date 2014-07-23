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

    public $relationArray;
    public $attributes;


    public function __construct()
    {
        $this->database = new PDO('mysql:host=localhost;dbname=myDB','test','123456');

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
        $query = $this->database->prepare("SELECT * FROM `".$this->tableName."`
                                            WHERE `".$this->primaryKey."`='".$pk."'");
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if($data !== false)
            $this->attributes = $data;
        else
            throw new Exception("There is no row with pk = " . $pk);

        return clone $this;
    }

    public function save()
    {
        //get attributes keys
        $keys = array_keys($this->attributes);

        if(!isset($this->attributes['id']))
        {
            $query = $this->database->prepare("INSERT INTO `".$this->tableName."` (`".implode($keys,"`,`")."`)
                                                VALUES('".implode($this->attributes,"','")."')");
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

            $query = $this->database->prepare($sql);

            $query->execute();
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
        else if($with === $this->relationTable)
        {
            //Construct hard SQL query
            $query = $this->database->prepare("SELECT ".$this->tableName.".".$this->primaryKey.",".$with.".".$this->relation->primaryKey.
                                                " FROM ".$this->tableName." INNER JOIN ".$with.
                                                " ON ".$this->tableName.".".$this->primaryKey."=".$with.
                                                ".".$this->relationKey." WHERE ".$this->tableName.".".$attribute."='".$value."'
                                                ORDER BY ".$this->tableName.".".$this->primaryKey."");
            $query->execute();

            $data = $query->fetchAll();

            $objects = array();

            $currentID = "";
            $rowCount = -1;
            $relationCount = 0;

            //Construct array of relation objects
            foreach($data as $i =>$row)
            {
                if($currentID !== $data[$i][0])
                {
                    $currentID = $data[$i][0];
                    $rowCount++;
                    $objects[$rowCount] = $this->findByPk($currentID);
                    $relationCount = 0;
                }

                $objects[$rowCount]->relationArray[$relationCount] = $this->relation->findByPk($data[$i][1]);
                $relationCount++;
            }

            return $objects;
        }
        else
            throw new Exception('Not related to the table');
    }
}
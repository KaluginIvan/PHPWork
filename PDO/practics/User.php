<?php

require_once("iDbConnectable.php");

class User implements iDbConnectable
{
    private $database;

    public $id;
    public $name;
    public $login;
    public $password;

    public function __construct($attributes=array())
    {
        $this->database = new PDO('mysql:host=localhost;dbname=myDB','root','123456');

        if($attributes !== array())
        {
            $this->name = $attributes['name'];
            $this->login = $attributes['login'];
            $this->password = $attributes['password'];
        }
    }

    public function findByPk($pk)
    {
        $query = $this->database->prepare('SELECT name, login, password FROM users WHERE id=:id');
        $query->bindValue(':id', $pk);
        $query->execute();

        $data = $query->fetch();

        if($data !== false)
        {
            $this->id = $pk;
            $this->name = $data['name'];
            $this->login = $data['login'];
            $this->password = $data['password'];
        }
        else
            throw new Exception("There is no row with id = " . $pk);

        return $this;
    }

    public function save()
    {
        if(!isset($this->id))
        {
            $query = $this->database->prepare('INSERT INTO users(name, login, password) VALUES(:name, :login, :password)');

            $query->bindValue(':name', $this->name);
            $query->bindValue(':login', $this->login);
            $query->bindValue(':password', $this->password);

            $query->execute();

            $this->id = $this->database->lastInsertId();
        }
        else
        {
            $query = $this->database->prepare('UPDATE users SET name=:name, login=:login, password=:password WHERE id=:id');

            $query->bindValue(':id', $this->id);
            $query->bindValue(':name', $this->name);
            $query->bindValue(':login', $this->login);
            $query->bindValue(':password', $this->password);

            $query->execute();
        }

    }

    public function where($attribute, $value)
    {
        $query = $this->database->prepare('SELECT id FROM users WHERE `'.$attribute.'`=:value');
        $query->bindValue(':value', $value);
        $query->execute();

        $data = $query->fetchAll();

        $objects = array();

        foreach($data as $i=>$row)
        {
            $newObj = new User();
            $newObj->findByPk($row['id']);
            $objects[$i] = $newObj;
        }

        return $objects;
    }
}
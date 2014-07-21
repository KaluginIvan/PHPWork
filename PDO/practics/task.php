<?php

$database = new PDO('mysql:host=localhost;dbname=myDB','root','123456');

$query = $database->prepare("SELECT * FROM users");

$query->execute();

$data = $query->fetchAll();

foreach($data as $row)
{
    echo $row['name'] . "\n";
}
<?php

require_once("User.php");

$user = new User();

//$myObj = new User();

/*try
{
    $myObj = $user->findByPk(1);
}
catch(Exception $e)
{
    echo $e->getMessage();
}*/

$myObj = $user->where('name', 'user');

var_dump($myObj);
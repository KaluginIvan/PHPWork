<?php

require_once("User.php");

$user = new User('users');

$newUser = $user->where('name','user2','album');

echo $newUser[0]->relationArray[0]->attributes['title'];
echo $newUser[0]->relationArray[1]->attributes['title'];
echo $newUser[0]->relationArray[2]->attributes['title'];
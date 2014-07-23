<?php

require_once("User.php");

$user = new User('users');

$newUsers = $user->where('name','user',true);

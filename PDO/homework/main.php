<?php

require_once("User.php");

$user = new BaseTable();

$myUser = $user->findByPk(20);

$myUser->name = "changedName";
$myUser->login = "changedLogin";
$myUser->password = "changedPassword";

$myUser->save();
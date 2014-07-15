<?php

require_once('forTask1.php');

$count = 1;

foreach($users as $user)
{
    printf("%d. %s\n", $count, $user);
    $count++;
}
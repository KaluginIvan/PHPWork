<?php

function compare( $iA, $iB )            //sorting by 'rank'
{
    $result = false;

    if($iA['rank'] < $iB['rank'])
        $result = true;

    return $result;
}

$array = array(
    array(
        'name' => 'Vasya',
        'rank' => 5
    ),
    array(
        'name' => 'Sergey',
        'rank' => 3
    ),
    array(
        'name' => 'Ivan',
        'rank' => 4
    )
);

var_dump($array);

usort($array, "compare");

var_dump($array);
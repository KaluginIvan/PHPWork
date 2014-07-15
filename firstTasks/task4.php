<?php

function printInfo($param_1, $param_2)
{
    $stringInfo = "Line Number - %d\nCurrent File Name - %s\nFunction Name - %s\n";

    $parameters = func_get_args();          //Get function parameters

    printf($stringInfo, __LINE__, __FILE__, __FUNCTION__);      //Print info from MAGIC consts

    $count = 0;

    foreach($parameters as $row)
        printf("Function Parameter[%d] = $row\n", $count++);    //Print function parameters
}

printInfo(4, 5);
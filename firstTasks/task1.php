<?php

$ids = array(1, 2, 3, 4);

$string = "SELECT * FROM 'table' WHERE 'id' IN (%d, %d, %d, %d)";

$sql = sprintf($string, $ids[0], $ids[1], $ids[2], $ids[3]);        //Get string

print "$sql\n";
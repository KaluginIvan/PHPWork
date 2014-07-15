<?php

function getLevel($iData, $iID)             //get the nesting category level
{
    $result = 0;

    while($iData[$iID][1] !== "")
    {
        $iID = $iData[$iID][1] - 1;

        $result++;
    }

    return $result;
}

$count = 0;

$allData = NULL;

if (($file = fopen("categories.csv", "r")) !== FALSE)
{
    while (($row = fgetcsv($file, 1000, ";")) !== FALSE)
    {
        $allData[$count++] = $row;
    }

    fclose($file);
}

for($i = 0; $i < $count; ++$i)
{
    for($j = 0; $j < getLevel($allData, $i); ++$j)
        print "\t";                         //tabs
    print $allData[$i][2] . "\n";
}
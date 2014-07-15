<?php

$id = 122;

$article = $id;

$numberLength = strlen($article);

for($i = $numberLength; $i < 6; ++$i)
    $article = '0' . $article;          //Add 0

print "$article\n";
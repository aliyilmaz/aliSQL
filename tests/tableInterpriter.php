<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$Mind->selectDB('test1');

// Array
// (
//     [0] => id:increments:11
//     [1] => username:string:255
//     [2] => password:string:255
//     [3] => description:medium
//     [4] => address:large
//     [5] => amount:decimal:10,0
//     [6] => age:int:11
// )

echo '<pre>';
print_r($Mind->tableInterpriter('users'));
echo '</pre>';
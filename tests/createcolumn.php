<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Creating a column.
 *
 * @param string   $tblname
 * @param array   $arr
 * @return  bool
 * */
$arr = array(
    'username:small', //TEXT
    'password', //TEXT
    'new_amount:decimal:15,8', //DECIMAL
    'number:int', //INT
    'title:string:100' //VARCHAR
);
if(!$Mind->createcolumn('phonebook', $arr)){
    exit('Error: Creating a column.');
}
echo '<h5>Creating a column.</h5>';

echo '<h1>The Creating a column method is running.</h1>';
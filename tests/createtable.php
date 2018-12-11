<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Create table.
 *
 * @param string $tblname
 * @param array $scheme
 * @return bool
 */
$scheme = array(
    'id:increments', //AUTO_INCREMENT
    'name:string:120', //VARCHAR
    'phone', //TEXT
    'email', //TEXT
    'age:int:11', //INT
    'about:medium', //MEDIUMTEXT
    'address:large', //LONGTEXT
    'amount:decimal:6,2', //DECIMAL
    'created_at', //TEXT
    'updated_at' //TEXT
);
if(!$Mind->createtable('phonebook', $scheme)){
    exit('Error: Create table.');
}
echo '<h5>Create table.</h5>';

echo '<h1>The Create table method is running.</h1>';
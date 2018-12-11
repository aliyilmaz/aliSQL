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
    'id:increments',
    'name:string:120',
    'phone',
    'email',
    'age:int:11',
    'about:medium',
    'address:large',
    'amount:decimal:6,2',
    'created_at',
    'updated_at'
);
if(!$Mind->createtable('phonebook', $scheme)){
    exit('Error: Create table.');
}
echo '<h5>Create table.</h5>';

echo '<h1>The Create table method is running.</h1>';
<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Create table.
 *
 * @param string $tblname
 * @param array $arr
 * @return bool
 */
$arr = array(
    'id:increments',
    'test_id:increments',
    'name',
    'phone',
    'email',
    'created_at',
    'updated_at'
);
if(!$Mind->createtable('phonebook', $arr)){
    exit('Error: Create table.');
}
echo '<h5>Create table.</h5>';

echo '<h1>The Create table method is running.</h1>';
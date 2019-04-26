<?php
require_once '../src/Mind.php';

$Mind = new Mind();

/**
 * Delete database.
 *
 * @param string   $dbname
 * @return  bool
 * */
$dbname = 'mydb';
if(!$Mind->deletedb($dbname)){
    exit('Error: Delete database. (string)');
}
echo '<h5>Delete database. (string)</h5>';

/**
 * Delete database.
 *
 * @param mixed   $dbname
 * @return  bool
 * */
$dbname = array('mydb1', 'mydb2');
if(!$Mind->deletedb($dbname)){
    exit('Error: Delete database. (array)');
}
echo '<h5>Delete database. (array)</h5>';

echo '<h1>The database deletion method is running.</h1>';
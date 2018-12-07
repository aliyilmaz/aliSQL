<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Clear database.
 *
 * @param string   $dbname
 * @return  bool
 * */
$dbname = 'mydb';
if(!$Mind->cleardb($dbname)){
    exit('Error: Clear database. (string)');
}
echo '<h5>Clear database. (string)</h5>';

/**
 * Clear database.
 *
 * @param mixed   $dbname
 * @return  bool
 * */
$dbname = array('mydb', 'mydb1');
if(!$Mind->cleardb($dbname)){
    exit('Error: Clear database. (array)');
}
echo '<h5>Clear database. (array)</h5>';

echo '<h1>The database clearing method is running.</h1>';
<?php
require_once '../src/Mind.php';

$Mind = new Mind();

/**
 * Create database.
 *
 * @param string $dbname
 * @return bool
 */
$dbname = 'mindtest0';
if(!$Mind->createdb($dbname)){
    exit('Error: Create database. (string)');
}
echo '<h5>Create database. (string)</h5>';

/**
 * Create database.
 *
 * @param array $dbname
 * @return bool
 */
$dbname = array('mindtest1', 'mindtest2');
if(!$Mind->createdb($dbname)){
    exit('Error: Create database. (array)');
}
echo '<h5>Create database. (array)</h5>';

echo '<h1>The database creation method is running.</h1>';
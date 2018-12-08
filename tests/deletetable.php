<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Delete table.
 *
 * @param string   $tblname
 * @return  bool
 * */
$tblname = 'phonebook';
if(!$Mind->deletetable($tblname)){
    exit('Error: Delete table. (string)');
}
echo '<h5>Delete table. (string)</h5>';

/**
 * Delete table.
 *
 * @param mixed   $tblname
 * @return  bool
 * */
$tblname = array('phonebook1', 'phonebook2');
if(!$Mind->deletetable($tblname)){
    exit('Error: Delete table. (array)');
}
echo '<h5>Delete table. (array)</h5>';

echo '<h1>The table deletion method is running.</h1>';
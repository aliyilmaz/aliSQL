<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Delete column.
 *
 * @param string   $tblname
 * @param string   $column
 * @return  bool
 * */
$tblname = 'phonebook';
$column = 'name';
if(!$Mind->deletecolumn($tblname, $column)){
    exit('Error: Delete column. (string)');
}
echo '<h5>Delete column. (string)</h5>';

/**
 * Delete column.
 *
 * @param string   $tblname
 * @param mixed   $column
 * @return  bool
 * */
$tblname = 'phonebook';
$column = array('created_at', 'updated_at');
if(!$Mind->deletecolumn($tblname, $column)){
    exit('Error: Delete column. (array)');
}
echo '<h5>Delete column. (array)</h5>';

echo '<h1>The column deletion method is running..</h1>';
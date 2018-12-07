<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Clear column.
 *
 * @param string   $tblname
 * @param string   $column
 * @return  bool
 * */
$column = 'name';
if(!$Mind->clearcolumn('phonebook', $column)){
    exit('Error: Clear column. (string)');
}
echo '<h5>Clear column. (string)</h5>';

/**
 * Clear column.
 *
 * @param string   $tblname
 * @param mixed   $column
 * @return  bool
 * */
$column = array('email', 'created_at');
if(!$Mind->clearcolumn('phonebook', $column)){
    exit('Error: Clear column. (array)');
}
echo '<h5>Clear column. (array)</h5>';

echo '<h1>The table column cleaning method is running.</h1>';
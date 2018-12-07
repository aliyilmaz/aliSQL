<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Clear table.
 *
 * @param string   $tblname
 * @return  bool
 * */
$tblname = 'phonebook';
if(!$Mind->cleartable($tblname)){
    exit('Error: Clear table. (string)');
}
echo '<h5>Clear table. (string)</h5>';

/**
 * Clear table.
 *
 * @param mixed   $tblname
 * @return  bool
 * */
$tblname = array('phonebook1', 'phonebook2');
if(!$Mind->cleartable($tblname)){
    exit('<br>Error: Clear table. (array)');
}
echo '<h5>Clear table. (array)</h5>';

echo '<h1>The database clearing method is running.</h1>';
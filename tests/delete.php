<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Record delete.
 *
 * @param string   $tblname
 * @param string   $arr
 * @param mixed   $id
 * @return  bool
 * */
$tblname = 'phonebook';
$arr = '5';
if(!$Mind->delete($tblname, $arr)){
    exit('Error: Record delete. (string)');
}
echo '<h5>Record delete. (string)</h5>';

/**
 * Record delete.
 *
 * @param string   $tblname
 * @param string   $arr
 * @param mixed   $id
 * @param mixed   $special
 * @return  bool
 * */
$tblname = 'phonebook';
$arr = 'Ali Yılmaz';
if(!$Mind->delete($tblname, $arr, 'name')){
    exit('Error: Record delete. (string|special)');
}
echo '<h5>Record delete. (string|special)</h5>';

/**
 * Record delete.
 *
 * @param string   $tblname
 * @param mixed   $arr
 * @param mixed   $id
 * @return  bool
 * */
$tblname = 'phonebook';
$arr = array(6,7);
if(!$Mind->delete($tblname, $arr)){
    exit('Error: Record delete. (array)');
}
echo '<h5>Record delete. (array)</h5>';

/**
 * Record delete.
 *
 * @param string   $tblname
 * @param mixed   $arr
 * @param mixed   $id
 * @param mixed   $special
 * @return  bool
 * */
$tblname = 'phonebook';
$arr = array(8,9);
if(!$Mind->delete($tblname, $arr)){
    exit('Error: Record delete. (array)');
}
echo '<h5>Record delete. (array|special)</h5>';

echo '<h1>The record deletion method is running.</h1>';
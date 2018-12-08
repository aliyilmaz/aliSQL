<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param string   $arr[column]
 * @return  mixed
 * */
$arr = array(
    'column' => 'name'
);
$tblname = 'phonebook';
$get = $Mind->get($tblname, $arr);

if(!$get){
    exit('Error: Record reading. (column[string])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';

}
echo '<h5>Record reading. (column[string])</h5>';

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param mixed   $arr[column]
 * @return  mixed
 * */
$arr = array(
    'column' => array(
        'name'
    )
);
$tblname = 'phonebook';
$get = $Mind->get($tblname, $arr);

if(!$get){
    exit('Error: Record reading. (column[array])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';

}
echo '<h5>Record reading. (column[array])</h5>';


echo '<h1>The record reading method is running.</h1>';
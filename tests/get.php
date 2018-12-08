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
/*$arr = array(
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
echo '<h5>Record reading. (column[string])</h5>';*/

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param mixed   $arr[column]
 * @return  mixed
 * */
/*$arr = array(
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
echo '<h5>Record reading. (column[array])</h5>';*/

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param string   $arr[search][keyword]
 * @return  mixed
 * */
/*$arr = array(
    'search' => array(
        'keyword'=>'Ali Yılmaz'
    )
);
$tblname = 'phonebook';
$get = $Mind->get($tblname, $arr);

if(!$get){
    exit('Error: Record reading. (search[keyword][string])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';

}
echo '<h5>Record reading. (search[keyword][string])</h5>';*/

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param mixed   $arr[search][keyword]
 * @return  mixed
 * */
/*$arr = array(
    'search' => array(
        'keyword'=>array('Ali Yılmaz', 'Ali Yılmaz83')
    )
);
$tblname = 'phonebook';
$get = $Mind->get($tblname, $arr);

if(!$get){
    exit('Error: Record reading. (search[keyword][array])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';

}
echo '<h5>Record reading. (search[keyword][array])</h5>';*/

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param string   $arr[search][column]
 * @return  mixed
 * */
/*$arr = array(
    'search' => array(
        'keyword'=>'Ali Yılmaz',
        'column'=>'name'
    )
);
$tblname = 'phonebook';
$get = $Mind->get($tblname, $arr);

if(!$get){
    exit('Error: Record reading. (search[column][string])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';

}
echo '<h5>Record reading. (search[column][string])</h5>';*/

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param mixed   $arr[search][column]
 * @return  mixed
 * */
/*$arr = array(
    'search' => array(
        'keyword'=>'Ali Yılmaz',
        'column'=>array('name', 'phone')
    )
);
$tblname = 'phonebook';
$get = $Mind->get($tblname, $arr);

if(!$get){
    exit('Error: Record reading. (search[column][array])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';

}
echo '<h5>Record reading. (search[column][array])</h5>';*/

/**
 * Record reading.
 *
 * @param string   $tblname
 * @param string   $arr[search][where]
 * @return  mixed
 * */
$arr = array(
    'search' => array(
        'keyword'=>'Ali Yılmaz',
        'column'=>array('name', 'phone'),
        'where'=>'all'
    )
);
$tblname = 'phonebook';
$get = $Mind->get($tblname, $arr);

if(!$get){
    exit('Error: Record reading. (search[where])');
} else {
    echo '<pre>';
    print_r($get);
    echo '</pre>';

}
echo '<h5>Record reading. (search[column])</h5>';

echo '<h1>The record reading method is running.</h1>';
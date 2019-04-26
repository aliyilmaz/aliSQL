<?php

require_once '../src/Mind.php';

$Mind = new Mind();

/**
 * Record update.
 *
 * @param string $tblname
 * @param mixed  $arr
 * @param mixed  $id
 *
 * @return bool
 * */
$rows = array(
    'name' => 'Ali Yılmaz1',
);

$tblname = 'phonebook';
if (!$Mind->update($tblname, $rows, 1)) {
    exit('Error: Record updated');
}
echo '<h5>Record updated. </h5>';

/**
 * Record update.
 *
 * @param string $tblname
 * @param mixed  $arr
 * @param mixed  $id
 * @param mixed  $special
 *
 * @return bool
 * */
$rows = array(
    'name' => 'Ali Yılmaz'.rand(1, 100),
);

$tblname = 'phonebook';
if (!$Mind->update($tblname, $rows, 'Ali Yılmaz', 'name')) {
    exit('Error: Record updated. (special)');
}
echo '<h5>Record updated. (special)</h5>';

echo '<h1>The record update method is running.</h1>';

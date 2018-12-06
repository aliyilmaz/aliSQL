<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Add new record.
 *
 * @param string $dbname
 * @return bool
 */
$rows = array(
    'name'          => 'Ali Yılmaz',
    'phone'         => '01010101010',
    'email'         => 'aliyilmaz.work@gmail.com',
    'created_at'    =>  date('d-m-Y H:i:s')
);


if(!$Mind->insert('phonebook', $rows)){
    exit('Error: Add new record.');
}
echo '<h5>Add new record.</h5>';

echo '<h1>The add new record method is running.</h1>';
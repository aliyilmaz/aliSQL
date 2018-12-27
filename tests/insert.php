<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();

/**
 * Add new record.
 *
 * @param string $tblname
 * @param mixed $rows
 * @return bool
 */
$rows = array(
    'name'          => 'Ali Yılmaz',
    'phone'         => '01010101010',
    'email'         => 'aliyilmaz.work@gmail.com',
    'created_at'    =>  date('d-m-Y H:i:s')
);

$tblname = 'phonebook';
if(!$Mind->insert($tblname, $rows)){
    exit('Error: Add new record. (single)');
}
echo '<h5>Add new record. (single)</h5>';

echo '<br><hr><br>';


/**
 * Add new record.
 *
 * @param string $tblname
 * @param array $rows
 * @return bool
 */
$rows = array(
    array(
        'name'          => 'Ali Yılmaz',
        'phone'         => '10101010101',
        'email'         => 'aliyilmaz.work@gmail.com',
        'created_at'    =>  date('d-m-Y H:i:s')
    ),
    array(
        'name'          => 'Deniz Yılmaz',
        'phone'         => '20202020202',
        'email'         => 'deniz@gmail.com',
        'created_at'    =>  date('d-m-Y H:i:s')
    ),
    array(
        'name'          => 'Hasan Yılmaz',
        'phone'         => '30303030303',
        'email'         => 'hasan@gmail.com',
        'created_at'    =>  date('d-m-Y H:i:s')
    )
);

$tblname = 'phonebook';
if(!$Mind->insert($tblname, $rows)){
    exit('Error: Add new record. (multi)');
}
echo '<h5>Add new record. (multi)</h5>';

echo '<h1>The add new record method is running.</h1>';

<?php
require_once '../src/Mind.php';

$Mind = new Mind();

$tblname = 'phonebook';

/*
$scheme = array(
    'id:increments', //AUTO_INCREMENT
    'name:string:120', //VARCHAR
    'phone', //TEXT
    'email', //TEXT
    'age:int:11', //INT
    'about:medium', //MEDIUMTEXT
    'address:large', //LONGTEXT
    'amount:decimal:6,2', //DECIMAL
    'created_at', //TEXT
    'updated_at' //TEXT
);
if(!$Mind->createtable($tblname, $scheme)){
    exit('Error: Create table.');
}

$rows = array(
    'name'          => 'Ali Yılmaz',
    'phone'         => '01010101010',
    'email'         => 'aliyilmaz.work@gmail.com',
    'created_at'    =>  date('d-m-Y H:i:s')
);

if(!$Mind->insert($tblname, $rows)){
    exit('Error: Add new record. (single)');
}
*/
echo '<br>';

if($Mind->do_have($tblname, 'aliyilmaz.work@gmail.com', 'email')){
    echo 'Available';
} else {
    echo 'Not available';
}

echo '<hr>';

$arr = array('email'=>'aliyilmaz.work1@gmail.com', 'phone'=>'01010101010');
if($Mind->do_have($tblname, $arr)){
    echo 'Available';
} else {
    echo 'Not available';
}
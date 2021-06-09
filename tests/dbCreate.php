<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->dbCreate('mydb')){
    echo 'Veritabanı oluşturuldu.';
} else {
    echo 'Veritabanı oluşturulamadı.';
}

echo '<br>';

if($Mind->dbCreate(array('mydb1', 'mydb2'))){
    echo 'Veritabanları oluşturuldu.';
} else {
    echo 'Veritabanları oluşturulamadı.';
}
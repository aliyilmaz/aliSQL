<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->dbCreate('weddstore')){
    echo 'Veritabanı oluşturuldu.';
} else {
    echo 'Veritabanı oluşturulamadı.';
}

echo '<br>';

if($Mind->dbCreate(array('tutorial', 'yilmaz'))){
    echo 'Veritabanları oluşturuldu.';
} else {
    echo 'Veritabanları oluşturulamadı.';
}
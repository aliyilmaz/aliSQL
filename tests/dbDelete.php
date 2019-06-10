<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->dbDelete('weddstore')){
    echo 'Veritabanı kaldırıldı.';
} else {
    echo 'Veritabanı kaldırılamadı.';
}

echo '<br>';

if($Mind->dbDelete(array('tutorial', 'yilmaz'))){
    echo 'Veritabanları kaldırıldı.';
} else {
    echo 'Veritabanları kaldırılamadı.';
}
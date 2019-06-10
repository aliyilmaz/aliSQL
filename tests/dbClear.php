<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->dbClear('laravel')){
    echo 'Veritabanı temizlendi.';
} else {
    echo 'Veritabanı temizlenemedi.';
}

echo '<br>';

if($Mind->dbClear(array('ecommerce', 'tutorial', 'weddstore'))){
    echo 'Veritabanları temizlendi.';
} else {
    echo 'Veritabanları temizlenemedi.';
}

<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->tableClear('phonebook')){
    echo 'Tablo temizlendi.';
} else {
    echo 'Tablo temizlenemedi.';
}

echo '<br>';

if($Mind->tableClear(array('categories', 'users'))){
    echo 'Tablolar temizlendi.';
} else {
    echo 'Tablolar temizlenemedi.';
}
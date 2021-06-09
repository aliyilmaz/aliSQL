<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->columnClear('users', 'username')){
    echo 'Sütun temizlendi.';
} else {
    echo 'Sütun temizlenemedi.';
}

echo '<br>';

if($Mind->columnClear('users', array('_token', 'created_at'))){
    echo 'Sütunlar temizlendi.';
} else {
    echo 'Sütunlar temizlenemedi.';
}
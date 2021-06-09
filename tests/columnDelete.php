<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->columnDelete('users', 'password')){
    echo 'Sütun kaldırıldı.';
} else {
    echo 'Sütun kaldırılamadı.';
}

echo '<br>';

if($Mind->columnDelete('users', array('username', 'avatar', '_token'))){
    echo 'Sütunlar kaldırıldı.';
} else {
    echo 'Sütunlar kaldırılamadı.';
}
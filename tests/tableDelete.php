<?php
require_once ('../src/Mind.php');

$Mind = new Mind();

echo '<br>';

if($Mind->tableDelete('users')){
    echo 'Tablo kaldırıldı.';
} else {
    echo 'Tablo kaldırılamadı.';
}

echo '<br>';

if($Mind->tableDelete(array('posts', 'test1'))){
    echo 'Tablolar kaldırıldı.';
} else {
    echo 'Tablolar kaldırılamadı.';
}

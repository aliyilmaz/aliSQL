<?php
require_once('../src/Mind.php');

$Mind = new Mind();

echo '<br>';
if($Mind->delete('users', 2)){
    echo 'Kayıt silindi.';
} else {
    echo 'Kayıt silinemedi.';
}

echo '<br>';
if($Mind->delete('users', array(1,4))){
    echo 'Kayıtlar silindi';
} else {
    echo 'Kayıtlar silinemedi.';
}
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
    echo 'Kayıtlar silindi.';
} else {
    echo 'Kayıtlar silinemedi.';
}

echo '<br>';
if($this->delete('users', 1, array('posts'=>'author_id', 'gallery'=>'author_id'))){
    echo 'Kayıtlar silindi.';
} else {
    echo 'Kayıtlar silinemedi.';
}

echo '<br>';
if($this->delete('users', array(1,3), array('posts'=>'author_id', 'gallery'=>'author_id'))){
    echo 'Kayıtlar silindi.';
} else {
    echo 'Kayıtlar silinemedi.';
}
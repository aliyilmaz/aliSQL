<?php
require_once('../src/Mind.php');

$Mind = new Mind();

// echo '<br>';
// if($Mind->delete('users', 73)){
//     echo 'Kayıt silindi.';
// } else {
//     echo 'Kayıt silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', 66, true)){
//     echo 'Kayıt silindi.';
// } else {
//     echo 'Kayıt silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array(74,75))){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array(76,77), true)){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', 'fikret', 'username')){
//     echo 'Kayıt silindi.';
// } else {
//     echo 'Kayıt silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', 'fikret', 'username', true)){
//     echo 'Kayıt silindi.';
// } else {
//     echo 'Kayıt silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array('julide', 'Fatih'), 'username')){
//     echo 'Kayıt silindi.';
// } else {
//     echo 'Kayıt silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array('julide', 'Fatih'), 'username', true)){
//     echo 'Kayıt silindi.';
// } else {
//     echo 'Kayıt silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', 1, array('log'=>'user_id'))){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', 1, array('log'=>'user_id'), true)){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array(2,3), array('log'=>'user_id'))){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array(4,5), array('log'=>'user_id'), true)){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', 'Fatih', 'username', array('log'=>'username'))){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', 'Fatih', 'username', array('log'=>'username'), true)){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array('Fatih','aliyilmaz'), 'username', array('log'=>'username'))){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }

// echo '<br>';
// if($Mind->delete('users', array('Fatih','aliyilmaz'), 'username', array('log'=>'username'), true)){
//     echo 'Kayıtlar silindi.';
// } else {
//     echo 'Kayıtlar silinemedi.';
// }
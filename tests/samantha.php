<?php
require_once '../src/Mind.php';

$Mind = new Mind();

echo '<br>';

echo '<pre>';
print_r($Mind->samantha('users', array('id'=>'1')));
echo '</pre>';

echo '<br>';

echo '<pre>';
print_r($Mind->samantha('users', array('id'=>'1'), array('username', 'password')));
echo '</pre>';

echo '<br>';

echo $Mind->samantha('users', array('id'=>'1'), 'avatar' );
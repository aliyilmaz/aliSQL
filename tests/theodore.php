<?php

require_once '../src/Mind.php';

$Mind = new Mind();

// Array
// (
//     [group_id] => 10
// )
// echo '<pre>';
// print_r($Mind->theodore('permission', array('user_id'=>15), 'group_id'));
// echo '</pre>';

// Array
// (
//     [id] => 208
//     [group_id] => 10
// )
// echo '<pre>';
// print_r($Mind->theodore('permission', array('user_id'=>15), array('id', 'group_id')));
// echo '</pre>';

// Array
// (
//     [id] => 208
//     [user_id] => 15
//     [group_id] => 10
//     [_token] => 
//     [status] => 
//     [created_at] => 
//     [updated_at] => 
// )
// echo '<pre>';
// print_r($Mind->theodore('permission', array('user_id'=>15)));
// echo '</pre>';
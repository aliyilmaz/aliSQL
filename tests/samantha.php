<?php
require_once '../src/Mind.php';

$Mind = new Mind();


// Array
// (
//     [0] => Array
//         (
//             [group_id] => 10
//         )

// )
// echo '<pre>';
// print_r($Mind->samantha('permission', array('user_id'=>15), 'group_id'));
// echo '</pre>';


// Array
// (
//     [0] => Array
//         (
//             [id] => 208
//             [group_id] => 10
//         )

// )
// echo '<pre>';
// print_r($Mind->samantha('permission', array('user_id'=>15), array('id', 'group_id')));
// echo '</pre>';

// Array
// (
//     [0] => Array
//         (
//             [id] => 208
//             [user_id] => 15
//             [group_id] => 10
//             [_token] => 
//             [status] => 
//             [created_at] => 
//             [updated_at] => 
//         )

// )
// echo '<pre>';
// print_r($Mind->samantha('permission', array('user_id'=>15)));
// echo '</pre>';
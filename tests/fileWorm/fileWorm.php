<?php

require_once('../../src/Mind.php');

$Mind = new Mind();

$options = array(
    'separator' => '	',
    'names' => array(
        'username',
        'password',
        'email',
        'country',
        'city'
    ),
    'start' => 0,
    'end' => 600,
    'search'=>array(
        'username' => 'Michael',
    ),
//    'save' => array(
//        'tblName' => 'users'
//    )
);

echo '<pre>';

print_r($Mind->fileWorm('./data.sql', $options));
echo '</pre>';

<?php
require_once('../../src/Mind.php');

$Mind = new Mind();

$options = array(
    'sort'=>'id:asc',
    'limit'=>array(
        'start'=>2,
        'end'=>1
    ),
    'format'=>'json'
);
echo '<pre>';
print_r($Mind->getData('users', $options));
echo '</pre>';
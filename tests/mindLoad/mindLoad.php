<?php

require_once '../../src/Mind.php';

$Mind = new Mind();
echo $Mind->base_url;
echo '<hr>';

$Mind->mindLoad([
    'HomeController:index@create',
    'StoreController:index@create'
]);
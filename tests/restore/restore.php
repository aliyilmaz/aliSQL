<?php

require_once '../../src/Mind.php';

$Mind = new Mind();

// $Mind->restore('mydb');
echo '<pre>';
print_r($Mind->restore(array('../../tests/restore/backup.json')));
echo '</pre>';
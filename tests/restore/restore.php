<?php

require_once '../../src/Mind.php';

$Mind = new Mind();

$Mind->restore('backup_2020_11_06_17_40_21.json');
// $Mind->restore(array('backup_2020_11_06_17_40_21.json', 'backup_2020_11_06_17_41_22.json'));
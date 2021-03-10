<?php

require_once '../src/Mind.php';

$Mind = new Mind();

    // 1 KB
    echo $Mind->encodeSize(1024);

echo '<br>';

    // 1 MB
    echo $Mind->encodeSize(1048576);

echo '<br>';

    // 1 GB
    echo $Mind->encodeSize(1073741824);

echo '<br>';

    // 1 TB
    echo $Mind->encodeSize(1099511627776);

echo '<br>';

    // 1 PB
    echo $Mind->encodeSize(1125899906842624);

echo '<br>';

    // 1 EB
    echo $Mind->encodeSize(1152921504606850000);

echo '<br>';

    // 1 MB
    $file = array('size'=>1048576);
    echo $Mind->encodeSize($file);
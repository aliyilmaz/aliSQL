<?php

require_once '../src/Mind.php';

$Mind = new Mind();

    // 1024
    echo $Mind->decodeSize('1 KB');

echo '<br>';

    // 1048576
    echo $Mind->decodeSize('1 MB');

echo '<br>';

    // 1073741824
    echo $Mind->decodeSize('1 GB');

echo '<br>';

    // 1099511627776
    echo $Mind->decodeSize('1 TB');

echo '<br>';

    // 1125899906842624
    echo $Mind->decodeSize('1 PB');

echo '<br>';

    // 1152921504606846976
    echo $Mind->decodeSize('1 EB');

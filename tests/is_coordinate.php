<?php

require_once '../src/Mind.php';

$Mind = new Mind();

/* These are two points in Turkey */
$point1 = array('lat' => 41.008610, 'long' => 28.971111); // Istanbul
$point2 = array('lat' => 39.925018, 'long' => 32.836956); // Anitkabir

echo '<br>';

if($Mind->is_coordinate($point1['lat'], $point1['long'])){
    echo 'The current coordinate.';
} else {
    echo 'Invalid coordinate.';
}

echo '<br>';

if($Mind->is_coordinate($point2['lat'], $point2['long'])){
    echo 'The current coordinate.';
} else {
    echo 'Invalid coordinate.';
}
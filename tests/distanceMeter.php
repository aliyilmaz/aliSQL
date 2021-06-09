<?php

require_once '../src/Mind.php';

$Mind = new Mind();

/* These are two points in Turkey */
$point1 = array('lat' => 41.008610, 'long' => 28.971111); // Istanbul
$point2 = array('lat' => 39.925018, 'long' => 32.836956); // Anitkabir


//Array
//(
//    [m] => 4188.59
//    [km] => 4.19
//    [mi] => 2.6
//    [ft] => 13742.1
//    [yd] => 4580.64
//)
$distance = $Mind->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
echo '<pre>';
print_r($distance);
echo '</pre>';

//4188.59
$distance = $Mind->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], 'm');
echo $distance;

echo '<br>';
//4188.59
$distance = $Mind->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], array('m'));
echo $distance;

//Array
//(
//    [m] => 4188.59
//    [km] => 4.19
//)
$distance = $Mind->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], array('m', 'km'));
echo '<pre>';
print_r($distance);
echo '</pre>';

//Array
//(
//    [m] => 4188.59
//    [km] => 4.19
//    [mi] => 2.6
//    [ft] => 13742.1
//    [yd] => 4580.64
//)
$distance = $Mind->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], array());
echo '<pre>';
print_r($distance);
echo '</pre>';

//Array
//(
//    [m] => 4188.59
//    [km] => 4.19
//    [mi] => 2.6
//    [ft] => 13742.1
//    [yd] => 4580.64
//)
$distance = $Mind->distanceMeter($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], '');
echo '<pre>';
print_r($distance);
echo '</pre>';

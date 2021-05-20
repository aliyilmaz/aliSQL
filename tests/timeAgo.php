<?php

require_once '../src/Mind.php';

$Mind = new Mind();

// $datetime = $Mind->timestamp;
// echo $Mind->timeAgo($datetime); // just now

// $datetime = '2020-04-19 11:38:43';
// echo $Mind->timeAgo($datetime); // 1 year ago

// echo $Mind->timeAgo('2020-04-19 11:38:43', ['f'=>true]); //4 months, 1 week, 4 days, 23 hours, 5 minutes, 19 seconds

// echo $Mind->timeAgo('2010-10-20'); // 9 years

// echo $Mind->timeAgo('2010-10-20', ['f'=>true]); //10 years, 10 months, 1 week, 4 days, 10 hours, 45 minutes, 32 seconds

// //timestamp 
// echo $Mind->timeAgo('@1598867187'); // 8 months ago

// echo $Mind->timeAgo('@1598867187', ['f'=>true]); // 8 months, 2 weeks, 5 days, 22 hours, 20 minutes, 49 seconds ago

// $options = array(
//     'y' => 'Yıl',
//     'm' => 'Ay',
//     'w' => 'Hafta',
//     'd' => 'Gün',
//     'h' => 'Saat',
//     'i' => 'Dakika',
//     's' => 'Saniye',
//     'a' => 'Önce'
// );

// $datetime = '2020-04-19 11:38:43';
// echo $Mind->timeAgo($datetime, $options); // 1 Yıl Önce

$options = array(
    'y' => 'Yıl',
    'm' => 'Ay',
    'w' => 'Hafta',
    'd' => 'Gün',
    'h' => 'Saat',
    'i' => 'Dakika',
    's' => 'Saniye',
    'a' => 'Önce',
    'p' => '', // plural jewelry
    'f' => true // full string
);

$datetime = '2020-04-19 11:38:43';
echo $Mind->timeAgo($datetime, $options); // 1 Yıl, 1 Ay, 23 Saats, 32 Dakikas, 3 Saniyes Önce
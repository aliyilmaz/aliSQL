<?php
require_once ('../src/Mind.php');

$Mind = new Mind();


//$str = 'Merhaba dünya';
//echo $Mind->permalink($str);

//$str = 'Merhaba dünya';
//$option = array(
//    'delimiter' => '_'
//);
//echo $Mind->permalink($str, $option);

//$str = 'Merhaba dünya';
//$option = array(
//    'limit'=>'3'
//);
//echo $Mind->permalink($str, $option);

//$str = 'Merhaba dünya';
//$option = array(
//    'limit'=>3
//);
//echo $Mind->permalink($str, $option);

//$str = 'Merhaba dünya';
//$option = array(
//    'lowercase'=>false
//);
//echo $Mind->permalink($str, $option);

//$str = 'Merhaba dünya';
//$option = array(
//    'replacements'=>array(
//        'Merhaba' => 'hello',
//        'dünya' => 'world'
//    )
//);
//echo $Mind->permalink($str, $option);

//$str = 'Merhaba dünya';
//$option = array(
//    'transliterate'=>false
//);
//echo $Mind->permalink($str, $option);

$str = 'Merhaba dünya';
$option = array(
    'replacements'=>array(
        'Merhaba' => 'hello'
    ),
    'transliterate'=>false
);
echo $Mind->permalink($str, $option);

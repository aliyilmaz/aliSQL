<?php
require_once '../src/Mind.php';

$Mind = new Mind();
$str = "Merhaba dünya";


echo '<br>';



#Normal
echo $Mind->permalink($str);




echo '<br>';




#Delimiter
$option = array(
    'delimiter'=>'_'
);
echo $Mind->permalink($str, $option);





echo '<br>';




#Limit
$option = array(
    'limit'=>'3'
);
echo $Mind->permalink($str, $option);





echo '<br>';




#lowercase
$option = array(
    'lowercase'=>false
);
echo $Mind->permalink($str, $option);





echo '<br>';




#replacements
$option = array(
    'replacements'=>array('Merhaba'=>'hello', 'dünya'=>'world')
);
echo $Mind->permalink($str, $option);





echo '<br>';




#transliterate
$option = array(
    'transliterate'=>true
);
echo $Mind->permalink($str, $option);


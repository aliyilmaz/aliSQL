<?php
require_once ('../src/Mind.php');

$Mind = new Mind();


echo $Mind->permalink('Çok çalışırsan başarırsın.', array('lowercase'=>false));
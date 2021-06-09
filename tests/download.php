<?php

require_once '../src/Mind.php';

$Mind = new Mind();

print_r($Mind->download('../contributing.md',array('path'=>'../download')));

print_r($Mind->download('https://github.com/fluidicon.png',array('path'=>'../download')));

$links = array(
    'https://github.com/aliyilmaz/Mind/archive/master.zip',
    'https://github.com/aliyilmaz/PhoneBook/archive/master.zip',
    '../license.md',
    'https://github.com/aliyilmaz/pure-blog/archive/master.zip'
);
print_r($Mind->download($links, array('path'=>'../download')));

print_r($Mind->download($links));
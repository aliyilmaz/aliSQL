<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$code = 'merhaba &lt;?=$this-&gt;timestamp;?&gt;';
$Mind->evalContainer($code);


$code = 'merhaba &lt;?=$this-&gt;timestamp;?&gt;

&lt;?php

$array = array(
\'username\'=&gt;\'aliyilmaz\',
\'password\'=&gt;\'123456\'
);

$this-&gt;print_pre($array);';
$Mind->evalContainer($code);
<?php

require_once '../src/Mind.php';

$Mind = new Mind();

$code = 'merhaba &lt;?=$this-&gt;timestamp;?&gt;';

if($Mind->is_htmlspecialchars($code)){
    echo 'HTML has special characters.';
} else {
    echo 'HTML special characters not found.';
}
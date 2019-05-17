<?php

require_once '../src/Mind.php';

$Mind = new Mind();

echo $Mind->remote_filesize('https://github.com/fluidicon.png');
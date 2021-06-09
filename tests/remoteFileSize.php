<?php

require_once '../src/Mind.php';

$Mind = new Mind();

echo $Mind->remoteFileSize('https://github.com/fluidicon.png');
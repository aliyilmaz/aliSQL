<?php

require_once '../src/Mind.php';

$conf = array(
    'host'      =>  'localhost',
    'dbname'    =>  'mydb',
    'username'  =>  'root',
    'password'  =>  '',    
    'firewall'  =>  array(
        'noiframe'  =>  false,
        'nosniff'   =>  false,
        'noxss'     =>  false,
        'ssl'       =>  false
    )
);

$Mind = new Mind($conf);

echo 'It is open to remote access.';

?>




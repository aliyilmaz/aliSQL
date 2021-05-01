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
        'ssl'       =>  false,
        'csrf'      =>  false
        // 'csrf'      =>  true
        // 'csrf'      =>  array('limit'=>150)
        // 'csrf'      =>  array('name'=>'_token')
        // 'csrf'      =>  array('name'=>'_token', 'limit'=>150)
    )
);

$Mind = new Mind($conf);

echo 'It is open to remote access.';

?>




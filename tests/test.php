<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();








/**
 * Delete database.
 *
 * @param   string    $dbname
 * @return  bool
 * */
$dbname = 'mindtest0';
if(!$Mind->deletedb($dbname)){
    return false;
}

/**
 * Delete database.
 *
 * @param   mixed    $dbname
 * @return  bool
 * */
$dbname = array('mindtest1', 'mindtest2');
if(!$Mind->deletedb($dbname)){
    return false;
}
echo '<h5>Delete database.</h5>';

?>


<h2>The test is complete. All izz well.</h2>


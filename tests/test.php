<?php
require_once '../src/Mind.php';

use Mind\Mind;

$Mind = new Mind();
echo '<h5>Connection method.</h5>';

/**
 * Create database.
 *
 * @param string $dbname
 * @return bool
*/
$dbname = 'mindtest0';
if(!$Mind->createdb($dbname)){
    return false;
}

/**
 * Create database.
 *
 * @param mixed $dbname
 * @return bool
 */
$dbname = array('mindtest1', 'mindtest2');
if(!$Mind->createdb($dbname)){
    exit('Error: Create database.');
}
echo '<h5>Create database.</h5>';

/**
 * Create table.
 *
 * @param string $tblname
 * @param mixed $arr
 * @return bool
 */
$arr = array(
    'id:increments',
    'name',
    'phone',
    'email',
    'created_at',
    'updated_at'
);
if(!$Mind->createtable('phonebook', $arr)){
    exit('Error: Create table.');
}
echo '<h5>Create table.</h5>';

/**
 * Creating a column.
 *
 * @param mixed   $tblname
 * @param mixed   $arr
 * @return  bool
 * */
$arr = array(
    'username:small',
    'password',
    'address:medium',
    'about:large'
);
if(!$Mind->createcolumn('phonebook', $arr)){
    exit('Error: Creating a column.');
}
echo '<h5>Creating a column.</h5>';

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


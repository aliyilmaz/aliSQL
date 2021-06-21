<?php
require_once '../src/Mind.php';

$Mind = new Mind();
?>

<h4>type="text"</h4>
<form method="post">
    <input type="text" name="username">
    <input type="password" name="password">
    <?=$_SESSION['csrf']['input'];?>
    <button type="submit">Send!</button>
</form>

<hr>
<h4>type="text" ve type="file" (single file)</h4>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="file" name="singlefile">
    <?=$_SESSION['csrf']['input'];?>
    <button type="submit">Send!</button>
</form>
<hr>
<h4>type="text" ve type="file" (multiple file)</h4>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="file" name="multifile[]" multiple="multiple">
    <?=$_SESSION['csrf']['input'];?>
    <button type="submit">Send!</button>
</form>
<hr>

<h2>Result</h2>

<?php
echo '<pre>';
print_r($Mind->post);
echo '</pre>';
?>
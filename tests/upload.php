<?php

require_once '../src/Mind.php';

$Mind = new Mind();

 ?>
 <form action="upload.php" method="post" enctype="multipart/form-data">
   <input type="file" name="singlefile">
   <button type="submit">Single Upload</button>
 </form>

<?php
if (!empty($Mind->post['singlefile'])) {
     if (!$Mind->is_size($Mind->post['singlefile'], '124 KB')) {
         exit('Must be less than 124 KB. (single file)');
     }
     if (!$Mind->is_type($Mind->post['singlefile']['name'], array('pdf', 'jpg'))) {
         exit('Must have either the pdf or jpg extension. (single file)');
     }

     echo '<br><hr>';
     echo '<h2>Uploaded files. (single file)</h2>';
     echo '<pre>';
     print_r($Mind->upload($Mind->post['singlefile'], 'uploads'));
     echo '</pre>';
 }
?>
<hr>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="multifile[]" multiple="multiple">
    <button type="submit">Multi Upload</button>
</form>

<?php
if (!empty($Mind->post['multifile'])) {
    foreach ($Mind->post['multifile'] as $file) {
        if (!$Mind->is_size($file['size'], '124 KB')) {
            exit('Must be less than 124 KB. (multi file)');
        }
        if (!$Mind->is_type($file['name'], array('odg', 'odt', 'txt'))) {
            exit('Must have either the odg, odt or txt extension. (multi file)');
        }
    }

    echo '<br><hr>';

    echo '<h2>Uploaded files. (multi file)</h2>';

    echo '<pre>';
    print_r($Mind->upload($Mind->post['multifile'], 'uploads'));
    echo '</pre>';
}
?>

<?php
require_once('../src/Mind.php');

$Mind = new Mind();

/*
 * %&amp;%()' OR 1=1 karakterleri etkisizleştirilmiştir.
 */
$content = "%&%()' OR 1=1 karakterleri etkisizleştirilmiştir.";
echo $Mind->filter($content);

echo '<br>';

/*
 * &lt;script&gt;alert('XSS Açığı var'); &lt;/script&gt;gt;
 */
$content = "<script>alert('XSS Açığı var'); </script>";
echo $Mind->filter($content);
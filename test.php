<?php
echo __DIR__;
$filename = __DIR__.'/s.php';
$md5file = md5_file($filename);
echo $md5file;
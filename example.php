<?php
include 'base64.php';

$bs64 = new Base64;
var_dump($bs64->decode("dGVzdA==")); 
var_dump($bs64->encode("test"));

?>
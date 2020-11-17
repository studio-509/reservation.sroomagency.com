<?php 

include ("./Phpqrcode/qrlib.php");
$code = explode('|',$_GET['code']);
$file = "qrcode_".$code[0].".png";
$url = "./qrcarteskdo/".$file;
QRcode::png($_GET['code'], $url, "L", 4, 4); 

echo $file;

?>
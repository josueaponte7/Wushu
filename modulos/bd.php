<?php
error_reporting(0);
if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	$Usuario = $_SERVER['HTTP_CLIENT_IP'];
}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	$Usuario = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{   
    $Usuario = $_SERVER['REMOTE_ADDR'];
}

$Usuario = "root"; 
$Pass = "";

$link = new mysqli("localhost",$Usuario,$Pass,"wushu");
?>
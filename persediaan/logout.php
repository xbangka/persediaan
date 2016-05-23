<?php 
session_start();

$_SESSION=array();
session_destroy();
$host = 'http://'.$_SERVER['HTTP_HOST'].'/persediaan';
header('location: '.$host);
?>
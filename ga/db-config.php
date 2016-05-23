<?php
$hostdb = 'localhost';
$user = 'root';
$pass = '';
$dbase = 'db_persediaan';

$jazz = mysqli_connect($hostdb,$user,$pass,$dbase) or die('error-mysqli-connect');
$timezone = "Asia/Jakarta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$namabulan = array('','Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

?>
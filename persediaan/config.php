<?php
session_start();
//error_reporting(0);

function floattostr($val){ preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o ); return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:''); }
///============================================================
function md100($kata){$len = strlen($kata)-1; $temp2 = ''; for($i=0;$i<=$len;$i++){ $temp = substr($kata, $i, 1); $ansi = ord($temp); if($ansi % 2 == 0){$temp2 = $temp2.''.chr($ansi - 2);	}else{ $temp2 = $temp2.''.chr($ansi + 2);}} return $temp2;}
function md101($kata){$len = strlen($kata)-1; $temp2 = ''; for($i=0;$i<=$len;$i++){ $temp = substr($kata, $i, 1); $ansi = ord($temp); if($ansi % 2 == 0){ $temp2 = $temp2.''.chr($ansi + 2); }else{ $temp2 = $temp2.''.chr($ansi - 2);	} }	return $temp2;}
//-------------------------------------------------------------

$host = 'http://'.$_SERVER['HTTP_HOST'].'/persediaan';
$svrname = $_SERVER['SERVER_NAME'];
$hostdb = 'localhost';
$user = 'root';
$pass = '';
$dbase = 'db_persediaan';

$jazz = mysqli_connect($hostdb,$user,$pass,$dbase) or die('error-mysqli-connect');
$timezone = "Asia/Jakarta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$namabulan = array('','Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

?>
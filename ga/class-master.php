<?php
function getMaxKodeDealer() {
	$qMax	= mysql_query("SELECT	MAX(KodeDealer) AS Number FROM Tabel_Dealer");
	$rsMax	= mysql_fetch_array($qMax);
	# -----------------
	$Number	= $rsMax["Number"];
	$Plus	= $Number + 1;
	$Long	= strlen($Plus);
	# -----------------
	switch($Long) {
		case	1:
			$NewNumber	= "0000" . $Plus;
			break;
		case	2:
			$NewNumber	= "000" . $Plus;
			break;
		case	3:
			$NewNumber	= "00" . $Plus;
			break;
		case	4:
			$NewNumber	= "0" . $Plus;
			break;
		case	5:
			$NewNumber	= $Plus;
			break;
	}
	# -----------------
	return $NewNumber;
}

function getMaxKodeCabang() {
	$qMax	= mysql_query("SELECT	MAX(KodeCabang) AS Number FROM Profile");
	$rsMax	= mysql_fetch_array($qMax);
	# -----------------
	$Number	= $rsMax["Number"];
	$Plus	= $Number + 1;
	$Long	= strlen($Plus);
	# -----------------
	switch($Long) {
		case	1:
			$NewNumber	= "0" . $Plus;
			break;
		case	2:
			$NewNumber	= $Plus;
			break;
	}
	# -----------------
	return $NewNumber;
}

function getData($fields, $key, $var, $table)
{
	$qSelect	= mysql_query("SELECT $fields FROM $table WHERE $key = '$var'");
	
	$rs			= mysql_fetch_array($qSelect);
	
	return $rs;
}

function getInfo($label, $table, $key, $var)
{
	$qSelect	= mysql_query("SELECT $key AS Kode, $label AS Nama FROM $table WHERE $key = '$var'");
	
	$rs			= mysql_fetch_array($qSelect);
	$nr			= mysql_num_rows($qSelect);
	
	if($nr > 0) {
		return 		$rs["Nama"];
	} else {
		return 		$rs["Kode"];
	}
}

function getLongNumber($var)
{
	$qSelect	= mysql_query("SELECT 	KodeCabang
										, KodeDealer
										, ProdukKredit
										, NomorPin
										, AdjMilDenda
							   FROM 	Pinjam 
							   WHERE 	NomorPin = '$var'");
	
	$rs			= mysql_fetch_array($qSelect);
	
	$Flag		= ($rs["AdjMilDenda"] > 0) ? "*" : " ";
	
	return 		substr($rs["KodeCabang"], 0, 2)."-".$rs["KodeDealer"]."-".$rs["ProdukKredit"]."-".$rs["NomorPin"];
}

function getCrossInfo($label, $table, $key, $var)
{
	$qSelect	= mysql_query("SELECT $key AS Kode, $label AS Nama FROM $table WHERE $key = '$var'");
	$nr			= mysql_num_rows($qSelect);
	
	if($nr > 0) {
		$rs			= mysql_fetch_array($qSelect);
		$Kode		= $rs["Kode"];
		$Nama		= $rs["Nama"];
	} else {
		$qSelect	= mysql_query("SELECT $key AS Kode, $label AS Nama FROM $table WHERE $label = '$var'");
		$nr			= mysql_num_rows($qSelect);
		
		if($nr > 0) {
			$rs			= mysql_fetch_array($qSelect);
			$Kode		= $rs["Kode"];
			$Nama		= $rs["Nama"];
		}
	}
	
	return 	array("Kode"=>$Kode, "Nama"=>$Nama);
}

function getLongInfo($var)
{
	$qSelect	= mysql_query("SELECT 	LEFT(Pinjam.KodeCabang, 2) AS KodeCabang
										, Pinjam.KodeDealer
										, Pinjam.ProdukKredit
										, Pinjam.NomorPin
										, Pinjam.AdjMilDenda
										, Nasabah.Nama
							   FROM 	Pinjam INNER JOIN Nasabah ON Pinjam.NomorNas = Nasabah.NomorNas 
							   WHERE 	Pinjam.NomorPin = '$var'");
	
	$rs			= mysql_fetch_array($qSelect);

	return 		substr($rs["KodeCabang"], 0, 2)."-".$rs["KodeDealer"]."-".$rs["ProdukKredit"]."-".$rs["NomorPin"]." (".$rs["Nama"].")";
}

function pmt($apr, $loanlength, $loanamount){
    $apr = $apr/1200;
    return ($apr * -$loanamount * pow((1 + $apr), $loanlength) / (1 - pow((1 + $apr), $loanlength)));
}
?>
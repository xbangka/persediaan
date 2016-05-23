<?php
function getRoundingDown($var, $amount) {
	$Calc	= intval($var / $amount);
	$Result	= $Calc * $amount;
	# ------------------------
	return 	$Result;
}

function getRoundingUp($var, $amount) {
	$Calc	= $var - (intval($var / $amount) * $amount);
	$Result	= $var + ($amount - $Calc);
	# ------------------------
	return 	$Result;
}

/*function getNearestRounding($amount) {
	$Result	= $amount  - (fmod($amount, 1000));
	# ------------------------
	return 	$Result;
}*/

function getNearestRounding($amount) {
	$Result		= (intval(($amount + 500) / 1000)) * 1000;
	#$Result	= round($amount + ((1000 - fmod($amount, 1000))), 0);
	# ------------------------
	return 	$Result;
}

#add by yayan
function getRounding_Down1000($amount) {
	$Result		= (intval($amount / 1000)) * 1000;
	#$Result	= round($amount + ((1000 - fmod($amount, 1000))), 0);
	# ------------------------
	return 	$Result;
}

function getPasswordByDate($var) {
	list($tanggal, $bulan, $tahun) = split("[-]", $var);
	# ------------------------
	$a	= $tanggal * 5;
	$b	= $bulan * 8;
	$c	= $tahun * 2;
	# ------------------------
	$d	= $a + $b + $c;
	# ------------------------
	return $d;
}

function getLastDayOfMonth($var) {
	list($tanggal, $bulan, $tahun) = split("[-]", $var);
	# ------------------------
	$Hari		= mktime(0, 0, 0, $bulan, "01", $tahun);
	$result		= date("t", $Hari);
	# ------------------------
	return $result;
}

function KeKata($x) {
	$x = abs($x);
	$angka = array("", "satu", "dua", "tiga", "empat", "lima",
	"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($x <12) {
		$temp = " ". $angka[$x];
	} else if ($x <20) {
		$temp = kekata($x - 10). " belas";
	} else if ($x <100) {
		$temp = kekata($x/10)." puluh". kekata($x % 10);
	} else if ($x <200) {
		$temp = " seratus" . kekata($x - 100);
	} else if ($x <1000) {
		$temp = kekata($x/100) . " ratus" . kekata($x % 100);
	} else if ($x <2000) {
		$temp = " seribu" . kekata($x - 1000);
	} else if ($x <1000000) {
		$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
	} else if ($x <1000000000) {
		$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
	} else if ($x <1000000000000) {
		$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
	} else if ($x <1000000000000000) {
		$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
	}
		return $temp;
}

function Terbilang($x, $style=4) {
	if($x<0) {
		$hasil = "minus ". trim(KeKata($x));
	} else {
		$hasil = trim(KeKata($x));
	}
	switch ($style) {
		case 1:
			$hasil = strtoupper($hasil);
			break;
		case 2:
			$hasil = strtolower($hasil);
			break;
		case 3:
			$hasil = ucwords($hasil);
			break;
		default:
			$hasil = ucfirst($hasil);
			break;
	}
	return $hasil;
}

function getMonthName($var)
{
	switch($var) 
	{
		case	1:
			$Month	= "Januari";
			break;
		case	2:
			$Month	= "Februari";
			break;
		case	3:
			$Month	= "Maret";
			break;
		case	4:
			$Month	= "April";
			break;
		case	5:
			$Month	= "Mei";
			break;
		case	6:
			$Month	= "Juni";
			break;
		case	7:
			$Month	= "Juli";
			break;
		case	8:
			$Month	= "Agustus";
			break;
		case	9:
			$Month	= "September";
			break;
		case	10:
			$Month	= "Oktober";
			break;
		case	11:
			$Month	= "November";
			break;
		case	12:
			$Month	= "Desember";
			break;
	}
	
	return $Month;
}

function boldCharacter($var) {
	return "<strong>" . $var . "</strong>";
}

function getDefault($Parameter)
{
	if(empty($Parameter)){
		$Result = '-';
	} else {
		$Result = $Parameter;
	}
	
	return $Result;
}

function getMonth()
{
	return	  array(array("id"=>"01", "name"=>"Januari"),
					array("id"=>"02", "name"=>"Februari"),
					array("id"=>"03", "name"=>"Maret"),
					array("id"=>"04", "name"=>"April"),
					array("id"=>"05", "name"=>"Mei"),
					array("id"=>"06", "name"=>"Juni"),
					array("id"=>"07", "name"=>"Juli"),
					array("id"=>"08", "name"=>"Agustus"),
					array("id"=>"09", "name"=>"September"),
					array("id"=>"10", "name"=>"Oktober"),
					array("id"=>"11", "name"=>"November"),
					array("id"=>"12", "name"=>"Desember"));
}

function CreateLine($linetype, $amount)
{
	for ($i=1; $i<=$amount; $i++)
	{
		$line	.= "" . $linetype;
	}
	
	return $line;
}

function WriteText($Parameter, $Panjang, $Align)
{
	$Karakter	= strlen($Parameter);
	
	$Result		= ($Panjang - $Karakter);
	
	if($Align == 'L')
	{
		for($i=0; $i<$Result; $i++)
		{
			$Jarak	.= ' ';
		}
		
		return $Parameter.$Jarak;
	}
	
	if($Align == 'C')
	{
		$Hasil		= ceil($Panjang/2);
		$HasilAkhir	= ceil($Hasil-($Karakter/2));
		
		for($i=0; $i<$Panjang; $i++)
		{
			if($i==($HasilAkhir-1))
			{
				$Jarak	.= $Parameter;
				
				$i	= $i + ($Karakter);
			}
			
			$Jarak	.= ' ';
		}
		
		return $Jarak;
	}
	
	if($Align == 'R')
	{			
		for($i=0; $i<$Panjang; $i++)
		{
			if($i == $Result)
			{
				return substr($Jarak . $Parameter .' ', 1, strlen($Jarak . $Parameter .' ')) ;
				exit();
			}
			
			$Jarak	.= ' ';
		}
		
		return $Jarak.' ';
	}
}

function Enter() 
{
	return "\r\n";
}

function Preview($var)
{
	echo "<pre>" . $var . "</pre>";
}

function CreateTextFile($var, $Folder, $File)
{
	if(!file_exists($Folder)) {
		mkdir($Folder, 1);
	}
	
	if(file_exists($File)) {
		unlink($File);
	}
	# ------------------------
	$var		.= EjectPage();
	# ------------------------
	$fCreate	= fopen($File, "w");
	$fWrite		= fputs($fCreate, $var);
	$fClose		= fclose($fCreate);
}

function CreateXMLFile($var, $Folder, $File) {
	if(!file_exists($Folder)) {
		mkdir($Folder, 1);
	}
	if(file_exists($File)) {
		unlink($File);
	}
	# ------------------------
	$fCreate	= fopen($File, "w");
	$fWrite		= fputs($fCreate, $var);
	$fClose		= fclose($fCreate);
}

function YMD_Format($var)
{
	if(!empty($var)) {
		list($day, $month, $year) = split("[-]", $var);
		
		return $year . "-" . $month . "-" . $day;
	} else {
		return "";
	}
}

function DMY_Format($var, $string)
{
	if((!empty($var)) && ($var != "0000-00-00")) {
		list($year, $month, $day) = split("[-]", $var);
		
		return $day . $string . $month . $string . $year;
	} else {
		return "";
	}
}

function GetDayMonthYear($get,$var,$format)
{
	if(!empty($var)) {
		if($format=='YMD'){
			list($year, $month, $day) = split("[-]", $var);
		} else {
			list($day, $month, $year) = split("[-]", $var);
		}
		
		if($get=='D'){
			return $day;
		} else {
				if($get=='M'){
					return $month;
				} else {
						if($get=='Y'){
							return $year;
						} else {
							return "";
						}
				}
		}
	} else {
		return "";
	}
}

function getDayName($lang, $date)
{
	/*-------------------
	|	Convert String To Datetime
	|------------------------------- */
	$day_conv	= strtotime($date);
	$day_format	= date("D", $day_conv);

	switch($day_format)
	{
		case 'Mon':
			$day_id	= 'Senin';
			$day_en	= 'Monday';
			break;
		
		case 'Tue':
			$day_id	= 'Selasa';
			$day_en	= 'Tuesday';
			break;
		
		case 'Wed':
			$day_id	= 'Rabu';
			$day_en	= 'Wednesday';
			break;
		
		case 'Thu':
			$day_id	= 'Kamis';
			$day_en	= 'Thursday';
			break;
		
		case 'Fri':
			$day_id	= 'Jumat';
			$day_en	= 'Friday';
			break;
		
		case 'Sat':
			$day_id	= 'Sabtu';
			$day_en	= 'Saturday';
			break;
		
		case 'Sun':
			$day_id	= 'Minggu';
			$day_en	= 'Sunday';
			break;
		
		default:
			$day_id	= "None";
			$day_en	= "None";
	}
	
	$day_name	= ($lang == "en") ? $day_en : $day_id;
	
	return $day_name;
}

function CreateXML($folder, $var)
{
	if(file_exists($folder)) {
		unlink($folder);
	}
	
	$fOpen		= fopen($folder, "w");
	$fWrite		= fwrite($fOpen, $var);
	$fClose		= fclose($fOpen);
}

function EjectPage()
{
	$Eject = "";
	
	return $Eject;
}

function getDateBefore($var)
{
	list($y, $m, $d) = split("[-]", $var);
	
	if($m == 1) {
		$before		= ($y - 1) . "-" . "12" . "-" . $d;
		$for_check	= ($y - 1) . "-12-01";
	} else {
		$x_m		= $m - 1;
		$month		= (strlen($x_m) == 1) ? "0" . $x_m : $x_m;
		
		$before		= $y . "-" . $month . "-" . $d;
		$for_check	= $y . "-" . $month . "-01";
	}
	
    $time_stamp		= strtotime($for_check);
    $number_of_days = date("t", $time_stamp);
	
	if($d > $number_of_days) {
		list($y, $m, $d) = split("[-]", $before);
		
		$date		= $y . "-" . $m . "-" . $number_of_days;
	} else {
		$date		= $before;
	}
	
    return $date;
}

function cekShowDate($var) {
	if(($var == '0000-00-00') || ($var == '00-00-0000') || ($var == '00/00/0000') || ($var == '0000/00/00')) {
		$date	= "";
	} else {
		$date	= $var;
	}
	
	return $date;
}
?>
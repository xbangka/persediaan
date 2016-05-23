<?php
function getNoFormSetoran($var, $jenis) {
	$Long	= strlen($var);
	# --------------------------
	for($i=1; $i<=(8)-$Long; $i++) {
		$Number	.= "0";
	}
	# --------------------------
	return $jenis . $Number . $var;
}

function getDivisi($var) {
	switch($var) {
		case	"1":
			$Divisi	= "COMMERSIL";
			break;
		case	"2":
			$Divisi	= "PASSANGER";
			break;
		case	"3":
			$Divisi	= "PASSANGER";
			break;
		default:
			$Divisi	= "-";
	}
	
	return $Divisi;
}


function GetAgama($Parameter)
{
	switch ($Parameter)
	{
		case 1:
			$Result='Islam';
			break;
		
		case 2:
			$Result='Katolik';
			break;
		
		case 3:
			$Result='Protestan';
			break;
		
		case 4:
			$Result='Budha';
			break;
		
		case 5:
			$Result='Hindu';
			break;
		
		case 6:
			$Result='Lain - Lain';
			break;
		
		default :
			$Result='Lain - Lain';
			break;
	}
	
	return $Result;
}

function getSpaceNoPolisi($var) {
	$Len	= strlen($var);
	$Mulai	= 0;
	# --------------------------
	for($i=0; $i<$Len; $i++) {
		$Awal	= substr($var, $i, 1);
		$Hitung	= ($Awal + 1);
		# --------------------------
		if($Hitung == 1) {
			$First	.= $Awal;
		} else {
			$i		= 100;
		}
		$Mulai++;
	}
	# --------------------------
	$No		= $First . " ";	
	$var	= substr($var, ($Mulai)-1, strlen($var));
	$Mulai	= 0;
	# --------------------------
	for($i=0; $i<strlen($var); $i++) {
		$Tengah	= substr($var, $i, 1);
		$Hitung	= ($Tengah + 1);
		# --------------------------
		if($Hitung > 1) {
			$Mid	.= $Tengah;
		} else {
			if($Tengah != "0") {
				$i		= 100;
			} else {
				$Mid	.= $Tengah;
			}	
		}
		$Mulai++;
	}
	# --------------------------
	$No		.= $Mid . " ";
	$End	= substr($var, ($Mulai)-1, strlen($var));
	# --------------------------
	$No		.= $End;
	# --------------------------
	return $No;
}

function getNoForm($var) {
	$qForm	= mysql_query("SELECT	NoForm FROM RegisteredAccount");
	$rsForm	= mysql_fetch_array($qForm);
	# ---------------------
	$Len	= strlen($rsForm["NoForm"]);
	
	switch($Len) {
		case	1:
			$Number	= substr($var, 0, 2) . "-000000" . $rsForm["NoForm"];
			break;
		case	2:
			$Number	= substr($var, 0, 2) . "-00000" . $rsForm["NoForm"];
			break;
		case	3:
			$Number	= substr($var, 0, 2) . "-0000" . $rsForm["NoForm"];
			break;
		case	4:
			$Number	= substr($var, 0, 2) . "-000" . $rsForm["NoForm"];
			break;
		case	5:
			$Number	= substr($var, 0, 2) . "-00" . $rsForm["NoForm"];
			break;
		case	6:
			$Number	= substr($var, 0, 2) . "-0" . $rsForm["NoForm"];
			break;
		case	7:
			$Number	= substr($var, 0, 2) . "-" . $rsForm["NoForm"];
			break;
	}
	# ---------------------
	return $Number;
}

function getTahunTenor($var) {
	if($var > 36) {
		$Tahun	= 4;
	} else {
		if($var > 24) {
			$Tahun	= 3;
		} else {
			if($var > 12) {
				$Tahun	= 2;
			} else {
				$Tahun	= 1;
			}
		}		
	}
	
	return $Tahun;
}

function getModemInfo($var) {
	$Code	= strtoupper(substr($var, 0, 2));
	
	switch($Code) {
		case "PY":
			$Info	= "Payment";
			break;
		case "BO":
			$Info	= "Booking";
			break;
		case "TL":
			$Info	= "Tolakan";
			break;
		case "JB":
			$Info	= "Janji Bayar";
			break;
		case "DC":
			$Info	= "File";
			break;
		case "AP":
			$Info	= "Aplikasi";
			break;
		default :
			$Info	= "-";
			break;
	}
	
	return $Info;
}

function getDocument($var) {
	switch($var) {
		case 1:
			$doc	= "Faktur";
			break;
			
		case 2:
			$doc	= "Kwitansi";
			break;
			
		case 3:
			$doc	= "SPH";
			break;
			
		case 4:
			$doc	= "Keabsahan";
			break;
			
		case 5:
			$doc	= "NIK";
			break;
			
		case 6:
			$doc	= "Lain-lain";
			break;
	}
	
	return $doc;
}

function getJenisPembiayaan($var) {
	switch($var) {
		case "B":
			$Jenis	= "Baru";
			break;
		
		case "P":
			$Jenis	= "Bekas";
			break;
		
		case "R":
			$Jenis	= "Refinancing";
			break;
			
		case "G":
			$Jenis	= "Garis Bawah";
			break;
	}
	
	return $Jenis;
}

function getStatusBPKB($var) {
	switch($var) {
		case	0:
			$Status	= "Belum Input";
			break;
		
		case	1:
			$Status	= "Masuk Baru";
			break;
			
		case	2:
			$Status	= "Masuk Bank";
			break;
			
		case	3:
			$Status	= "Masuk Perpanjangan";
			break;
		
		case	4:
			$Status	= "Masuk BBN";
			break;
		
		case	5:
			$Status	= "Masuk Mutasi";
			break;
			
		case	11:
			$Status	= "Lunas";
			break;
		
		case	12:
			$Status	= "Bank";
			break;
		
		case	13:
			$Status	= "Perpanjangan";
			break;
		
		case	14:
			$Status	= "BBN";
			break;
		
		case	15:
			$Status	= "Mutasi";
			break;
		
		case	16:
			$Status	= "Blokir (Cabang)";
			break;
		
		case	17:
			$Status	= "Kasus Khusus";
			break;
	}
	
	return $Status;
}

function getStatusLawanBPKB($var) {
	switch($var) {
		case	0:
			$Status	= "1";
			break;
		
		case	1:
			$Status	= "11";
			break;
			
		case	2:
			$Status	= "12";
			break;
			
		case	3:
			$Status	= "13";
			break;
		
		case	4:
			$Status	= "14";
			break;
		
		case	5:
			$Status	= "15";
			break;
		
		case	6:
			$Status	= "16";
			break;
		
		case	7:
			$Status	= "17";
			break;
			
		case	11:
			$Status	= "1";
			break;
		
		case	12:
			$Status	= "2";
			break;
		
		case	13:
			$Status	= "3";
			break;
		
		case	14:
			$Status	= "4";
			break;
		
		case	15:
			$Status	= "5";
			break;
			
		case	16:
			$Status	= "6";
			break;
		
		case	17:
			$Status	= "7";
			break;
	}
	
	return $Status;
}

function YMD_GetNextPeriode($Tanggal) {
	list($y, $m, $d) = split("[-]", $Tanggal);
	# -------------------------------
	$Pre_Next	= ($y + 1) . "-" . $m . "-" . $d;
	# -------------------------------
	if(!checkdate($m, $d, $y)) {
		$next_periode	= date("Y-m-d",strtotime("-1 second",strtotime("+1 month",strtotime($m."/01/".$y." 00:00:00"))));
	} else {
		$next_periode	= $Pre_Next;
	}
	# -------------------------------
	return $next_periode;
}

function YMD_GetNextDate($Parameter, $TanggalAwal)
{
	$Parameter_Tanggal = strtotime($Parameter);
	
	$JumlahHari = date('t', $Parameter_Tanggal);

	list($Tahun, $Bulan, $Tanggal) = split('[-]', $Parameter);
	
	list($TahunAwalan, $BulanAwalan, $TanggalAwalan) = split('[-]', $TanggalAwal);

	switch($Bulan)
	{
		case ($Bulan==1):
			$Kategori = 1;
			
			if(($Tahun/4) == intval($Tahun/4))
			{
				switch($TanggalAwalan)
				{
					case 31:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 29 DAY) AS TanggalBerikutnya");
						break;
					
					case 30:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 30 DAY) AS TanggalBerikutnya");
						break;
					
					default :
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 31 DAY) AS TanggalBerikutnya");
						break;
				}
				
				$Row = mysql_fetch_array($Query);
			
				$TanggalBerikut = $Row[TanggalBerikutnya];
			} else {
				switch($TanggalAwalan)
				{
					case 31:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 28 DAY) AS TanggalBerikutnya");
						break;
					
					case 30:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 29 DAY) AS TanggalBerikutnya");
						break;
					
					case 29:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 30 DAY) AS TanggalBerikutnya");
						break;
					
					default :
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 31 DAY) AS TanggalBerikutnya");
						break;	
				}
				
				$Row = mysql_fetch_array($Query);
			
				$TanggalBerikut = $Row[TanggalBerikutnya];
			}
			
			break;
			
		case ($Bulan==2):
			$Kategori = 2;
			
			if(($Tahun/4) == intval($Tahun/4))
			{
				switch($TanggalAwalan)
				{
					case 31:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 31 DAY) AS TanggalBerikutnya");
						break;
					
					case 30:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 30 DAY) AS TanggalBerikutnya");
						break;
					
					default :
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 29 DAY) AS TanggalBerikutnya");
						break;
				}
				
				$Row = mysql_fetch_array($Query);
			
				$TanggalBerikut = $Row[TanggalBerikutnya];
			} else {
				switch($TanggalAwalan)
				{
					case 31:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 31 DAY) AS TanggalBerikutnya");
						break;
					
					case 30:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 30 DAY) AS TanggalBerikutnya");
						break;
					
					case 29:
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 29 DAY) AS TanggalBerikutnya");
						break;
					
					default :
						$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 28 DAY) AS TanggalBerikutnya");
						break;	
				}
				
				$Row = mysql_fetch_array($Query);
				
				$TanggalBerikut = $Row[TanggalBerikutnya];	
			}
			
			break;
		
		case ($Bulan==7) || ($Bulan==12):
			$Kategori = 3;
			
			$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 31 DAY) AS TanggalBerikutnya");
				
			$Row = mysql_fetch_array($Query);
			
			$TanggalBerikut = $Row[TanggalBerikutnya];
			
			break;
			
		case ($Bulan==4) || ($Bulan==6) || ($Bulan==9) || ($Bulan==11):
			$Kategori = 4;
			
			if($TanggalAwalan==31)
			{
				$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 31 DAY) AS TanggalBerikutnya");

				$Row = mysql_fetch_array($Query);
				
				$TanggalBerikut = $Row[TanggalBerikutnya];
			} else {
				$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 30 DAY) AS TanggalBerikutnya");

				$Row = mysql_fetch_array($Query);
				
				$TanggalBerikut = $Row[TanggalBerikutnya];
			}
			
			break;
			
		case ($Bulan==3) || ($Bulan==5) || ($Bulan==8) || ($Bulan==10):
			$Kategori = 5;
			
			if($TanggalAwalan==31)
			{
				$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 30 DAY) AS TanggalBerikutnya");
				
				$Row = mysql_fetch_array($Query);
				
				$TanggalBerikut = $Row[TanggalBerikutnya];
			} else {
				$Query = mysql_query("SELECT ADDDATE('$Parameter', INTERVAL 31 DAY) AS TanggalBerikutnya");
				
				$Row = mysql_fetch_array($Query);
				
				$TanggalBerikut = $Row[TanggalBerikutnya];
			}
			
			break;
			
		default :
			$Kategori = 'ErroR';
	}
	
	return $TanggalBerikut;
}

function goCekSession($SE_NamaPerusahaan, $SE_KodeCabang, $SE_MinHariDenda, $SE_DendaPermil, $SE_MinDenda)
{
	if((empty($SE_NamaPerusahaan)) || (empty($SE_KodeCabang)) || (empty($SE_MinHariDenda)) || (empty($SE_DendaPermil)) || (empty($SE_MinDenda))) {
		echo "<pre>Session expired, please login again.</pre>";
		exit();
	} else {
		return true;
	}
}

function goCekSessionform($SE_NamaPerusahaan, $SE_KodeCabang, $SE_MinHariDenda, $SE_DendaPermil, $SE_MinDenda)
{
	if((empty($SE_NamaPerusahaan)) || (empty($SE_KodeCabang)) || (empty($SE_MinHariDenda)) || (empty($SE_DendaPermil)) || (empty($SE_MinDenda))) {
		require_once("../attribute/frm_login.php");
		exit();
	} else {
		return true;
	}
}

function goCekSessionform_kuasatarik($SE_NamaPerusahaan, $SE_KodeCabang, $SE_MinHariDenda, $SE_DendaPermil, $SE_MinDenda, $SE_RealHariTarikDr, $SE_RealHariTarikSd, $SE_RealHariTarikExt)
{
	if((empty($SE_NamaPerusahaan)) || (empty($SE_KodeCabang)) || (empty($SE_MinHariDenda)) || (empty($SE_DendaPermil)) || (empty($SE_MinDenda))) {
		require_once("../attribute/frm_login.php");
		exit();
	}
	if((empty($SE_RealHariTarikDr))) {
		echo "SE_RealHariTarikDr=".$SE_RealHariTarikDr;
		exit();
	}
	if((empty($SE_RealHariTarikSd))) {
		echo "SE_RealHariTarikSd=".$SE_RealHariTarikSd;
		exit();
	}
	if((empty($SE_RealHariTarikExt))) {
		echo "SE_RealHariTarikDr=".$SE_RealHariTarikExt;
		exit();
	}
	if((empty($SE_RealHariTarikDr)) || (empty($SE_RealHariTarikSd)) || (empty($SE_RealHariTarikExt))) {
		require_once("../attribute/frm_login.php");
		exit();
	} else {
		return true;
	}
}

function Error()
{
	echo '<pre>Data Kosong</pre>';
}

function flat2eff($_flat,$t,$_type)
{
	if($_type==1)
	{
		$_e=0;
	} else {
		$_e=1;
	}

	$_p  = 100000000;
	$_a1 = ($_p+($_p*($_flat/1200*$t)))/$t;
	$_langkah = 1;
	$_ef = 0;
	$dapat = "F";
	
	while($dapat=="F")
	{
		$_ef = $_ef + $_langkah;
		$_efb = $_ef/1200;
		$_a2 = $_p*($_efb/((1-(pow(($_efb+1),(-$t))))*(pow(($_efb+1),$_e))));
		
		$awal=intval($_a1);
		$akhir=intval($_a2);
					
		if ($awal==$akhir)
		{
			$dapat = "T";
		} else {
			if ($_a2 > $_a1)
			{
				$_ef = $_ef-$_langkah;
				$_langkah = $_langkah/10;
			}
		}

		if ($_langkah == (1/1000000))
		{
			$dapat = "T";
		}
		
		if ($_ef > 99)
		{
			$dapat="T";
		}
	}
	$effektif=$_ef;
	return round($effektif,4);
}

function eff2flat($ef,$t,$ee)
{
	if($ee==2)
	{
		$e=0;
	} else {
		$e=1;
	}

	$f4=1000000;
	$efb = $ef/1200;
	$efb1=$efb+1;

	$f7 = $f4 * $t * ($efb/((1- pow($efb1,(-$t))) * pow($efb1,$e)));
	$f5 = $f7-$f4;
	$f6 = $f7/$t;
	return ((($f7-$f4)/$f4)/$t*1200);
}


function eff2flatPK($ef,$t,$ee)
{
	if($ee==2)
	{
		$e=0;
	} else {
		$e=1;
	}

	$f4=1000000;
	$efb = $ef/12;
	$efb1=-$f4+$efb+1;
	//=((PMT(F16/12;F$4;-1000000;0;1)*F$4)-1000000)/1000000
	//$f7 = $f4 * $t * ($efb/((1- pow($efb1,(-$t))) * pow($efb1,$e))-$f4)/$f4;
	$f7 = (($efb*$t)-$f4*($efb/((1- pow($efb1,(-$t))) * pow($efb1,$e))-$f4)/$f4);
	$f5 = $f7-$f4;
	$f6 = $f7/$t;
	return ((($f7-$f4)/$f4)/$t*1200);
}



function getMenu() 
{
	$arrayMenu	= array(array("Parent"=>"Yes", "Label"=>"Inquery", "URL"=>"NONE", "Target"=>"NONE", "Last"=>"No", "Display"=>"Yes"),
							array("Parent"=>"No", "Label"=>"Kewajiban Nasabah", "URL"=>"NONE", "Target"=>"NONE", "Order"=>"1", "Last"=>"No", "Display"=>"No"),
							array("Parent"=>"No", "Label"=>"Pelunasan Awal", "URL"=>"NONE", "Target"=>"NONE", "Order"=>"2", "Last"=>"No", "Display"=>"No"), 
							array("Parent"=>"No", "Label"=>"Data Inquery", "URL"=>"index.php?pages=data_inquery", "Target"=>"NONE", "Order"=>"1", "Last"=>"Yes", "Display"=>"Yes"),
						array("Parent"=>"Yes", "Label"=>"Report Collection", "URL"=>"NONE", "Target"=>"NONE", "Last"=>"No", "Display"=>"No"),
							array("Parent"=>"No", "Label"=>"Hitung Tunggakan", "URL"=>"index.php?pages=hitung_tunggakan", "Target"=>"NONE", "Order"=>"1", "Last"=>"No", "Display"=>"No"), 
							array("Parent"=>"No", "Label"=>"Hitung Rasio", "URL"=>"index.php?pages=penjualan_kendaraan", "Target"=>"NONE", "Order"=>"2", "Last"=>"No", "Display"=>"No"), 
							array("Parent"=>"No", "Label"=>"Hitung DPD", "URL"=>"index.php?pages=penjualan_kendaraan", "Target"=>"NONE", "Order"=>"3", "Last"=>"No", "Display"=>"No"), 
							array("Parent"=>"No", "Label"=>"Summary Tunggakan", "URL"=>"index.php?pages=analisa_portfolio", "Target"=>"NONE", "Order"=>"4", "Last"=>"No", "Display"=>"No"),
							array("Parent"=>"No", "Label"=>"Report DPD", "URL"=>"index.php?pages=analisa_portfolio", "Target"=>"NONE", "Order"=>"5", "Last"=>"No", "Display"=>"No"),
							array("Parent"=>"No", "Label"=>"Report Rasio", "URL"=>"index.php?pages=rasio", "Target"=>"NONE", "Order"=>"1", "Last"=>"Yes", "Display"=>"Yes"),
							array("Parent"=>"No", "Label"=>"Report Resume", "URL"=>"index.php?pages=analisa_portfolio", "Target"=>"NONE", "Order"=>"7", "Last"=>"Yes", "Display"=>"No"),
						array("Parent"=>"Yes", "Label"=>"Litbang", "URL"=>"NONE", "Target"=>"NONE", "Last"=>"No", "Display"=>"Yes"),
							array("Parent"=>"No", "Label"=>"Penjualan Kendaraan", "URL"=>"index.php?pages=penjualan_kendaraan", "Target"=>"NONE", "Order"=>"1", "Last"=>"No", "Display"=>"Yes"), 
							array("Parent"=>"No", "Label"=>"Portfolio & RO", "URL"=>"index.php?pages=analisa_portfolio", "Target"=>"NONE", "Order"=>"2", "Last"=>"Yes", "Display"=>"Yes"),
						array("Parent"=>"Yes", "Label"=>"Report", "URL"=>"NONE", "Target"=>"NONE", "Last"=>"No", "Display"=>"Yes"),
							array("Parent"=>"No", "Label"=>"Report Penjualan", "URL"=>"index.php?pages=penjualan", "Target"=>"NONE", "Order"=>"1", "Last"=>"No", "Display"=>"Yes"),
							array("Parent"=>"No", "Label"=>"Rekor Booking", "URL"=>"index.php?pages=rekor_booking", "Target"=>"NONE", "Order"=>"2", "Last"=>"Yes", "Display"=>"Yes"));
	
	return $arrayMenu;
}

function getPages($var)
{
	$qSelect	= mysql_query("SELECT	module_url FROM sys_module WHERE module_name = '$var'");
	
	$nr_Select	= mysql_num_rows($qSelect);
	
	if($nr_Select > 0) {
		$rs_Select	= mysql_fetch_array($qSelect);

		if(file_exists($rs_Select["module_url"])) {
			$pages		= $rs_Select["module_url"];
		} else {
			$pages	= "app/error.php";
		}
	} else {
		$pages	= "app/error.php";
	}

	return $pages;
}

function GetFileMasterName($var) {
	switch($var) {
		case 01:
			$Name	= "Master Bank";
			$Table	= "tabel_daftar_bank";
			$Fields	= "Kodebank";
			break;
		case 02:
			$Name	= "Master Fasilitas Kartu Kredit";
			$Table	= "tabel_fasilitaskartukredit";
			$Fields	= "Kode";
			break;
		case 03:
			$Name	= "Master Hubungan Referensi";
			$Table	= "tabel_hubunganreferensi";
			$Fields	= "Kode";
			break;
		case 04:
			$Name	= "Master Jabatan";
			$Table	= "tabel_jabatan";
			$Fields	= "KodeJbtn";
			break;	
		case 05:
			$Name	= "Master Jenis Asuransi";
			$Table	= "tabel_jenis_asuransi";
			$Fields	= "KodeJenisAsuransi";
			break;
		case 06:
			$Name	= "Master Jenis Kendaraan";
			$Table	= "tabel_jenis_kendaraan";
			$Fields	= "KodeJenis";
			break;	
		case 07:
			$Name	= "Master Jenis Nasabah";
			$Table	= "tabel_jenisnasabah";
			$Fields	= "Kode";
			break;	
		case 08:
			$Name	= "Master Jenis Pekerjaan";
			$Table	= "tabel_jenispekerjaan";
			$Fields	= "Kode";
			break;	
		case 09:
			$Name	= "Master Jenis Nasabah";
			$Table	= "tabel_jnsnasabah";
			$Fields	= "Kode";
			break;	
		case 10:
			$Name	= "Master Kota";
			$Table	= "tabel_kota";
			$Fields	= "KodeKota";
			break;	
		case 11:
			$Name	= "Master Lokasi";
			$Table	= "tabel_lokasi";
			$Fields	= "KodeLokasi";
			break;	
		case 12:
			$Name	= "Master Merek Kendaraan";
			$Table	= "tabel_merek";
			$Fields	= "KodeLokasi";
			break;	
		case 13:
			$Name	= "Master Model Kendaraan";
			$Table	= "tabel_model_kendaraan";
			$Fields	= "KodeModel";
			break;	
		case 14:
			$Name	= "Master Perusahaan Asuransi";
			$Table	= "tabel_perusahaan_asuransi";
			$Fields	= "KodeAsuransi";
			break;	
		case 15:
			$Name	= "Master Produk Kredit";
			$Table	= "tabel_produk_kredit";
			$Fields	= "ProdukKredit";
			break;	
		case 16:
			$Name	= "Master Rate Asuransi";
			$Table	= "tabel_rate_asuransi";
			$Fields	= "KodeJenisAsuransi";
			break;	
		case 17:
			$Name	= "Master Sektor Usaha";
			$Table	= "tabel_sektorusaha";
			$Fields	= "KodeSU";
			break;	
		case 18:
			$Name	= "Master Status Rumah";
			$Table	= "tabel_statusrumah";
			$Fields	= "Kode";
			break;
		case 19:
			$Name	= "Master Tipe Kendaraan";
			$Table	= "tabel_tipe_kendaraan";
			$Fields	= "KodeTipe";
			break;
		case 20:
			$Name	= "Master Trayek";
			$Table	= "tabel_trayek";
			$Fields	= "KodeTrayek";
			break;	
		case 21:
			$Name	= "Master Wilayah";
			$Table	= "tabel_wilayah";
			$Fields	= "KodeWilayah";
			break;
		case 22:
			$Name	= "Master Karyawan";
			$Table	= "karyawan";
			$Fields	= "NIK";
			break;
		case 23:
			$Name	= "Master Perusahaan";
			$Table	= "profile";
			$Fields	= "KodeCabang";
			break;
		
		case 24:
			$Name	= "Master Dealer";
			$Table	= "tabel_dealer";
			$Fields	= "KodeDealer";
			break;
			
		case 25:
			$Name	= "Master Refund";
			$Table	= "tabel_refund";
			$Fields	= "KodeDealer";
			break;	
	}
	
	return array($Name, $Table, $Fields);
}

function getDescriptionReport($var)
{
	switch($var)
	{
		case	"01": // Produk Kredit
			$array	= array(array("Id"=>"B", "Label"=>"Pembelian Baru"),
							array("Id"=>"P", "Label"=>"Pembelian Bekas"),
							array("Id"=>"R", "Label"=>"Refinancing"));
			break;
			
		case	"02": // Angsuran
			$array	= array(array("Start"=>0, "End"=>1000000, "Fields"=>"Angsuran", "Label"=>" <= 1Jt"),
							array("Start"=>1000001, "End"=>2000000, "Fields"=>"Angsuran", "Label"=>" >  1Jt S/D <= 2Jt"),
							array("Start"=>2000001, "End"=>3000000, "Fields"=>"Angsuran", "Label"=>" >  2Jt S/D <= 3Jt"),
							array("Start"=>3000001, "End"=>4000000, "Fields"=>"Angsuran", "Label"=>" >  3Jt S/D <= 4Jt"),
							array("Start"=>4000001, "End"=>5000000, "Fields"=>"Angsuran", "Label"=>" >  4Jt S/D <= 5Jt"),
							array("Start"=>5000001, "End"=>9999999999999, "Fields"=>"Angsuran", "Label"=>" >  5Jt"));
			break;
			
		case	"03": // Down Payment
			$array	= array(array("Start"=>0, "End"=>20, "Label"=>" <= 20 %"),
							array("Start"=>20, "End"=>30, "Label"=>" >  20 % S/D <= 30 %"),
							array("Start"=>30, "End"=>40, "Label"=>" >  30 % S/D <= 40 %"),
							array("Start"=>40, "End"=>50, "Label"=>" >  40 % S/D <= 50 %"),
							array("Start"=>50, "End"=>99999999, "Label"=>" >  50 %"));
			break;
		
		case	"04": // Pokok Pinjaman
			$array	= array(array("Start"=>0, "End"=>20000000, "Fields"=>"PokokHutang", "Label"=>" <= 20Jt"),
							array("Start"=>20000001, "End"=>30000000, "Fields"=>"PokokHutang", "Label"=>" > 20Jt S/D <= 30Jt"),
							array("Start"=>30000001, "End"=>40000000, "Fields"=>"PokokHutang", "Label"=>" > 30Jt S/D <= 40Jt"),
							array("Start"=>40000001, "End"=>50000000, "Fields"=>"PokokHutang", "Label"=>" > 40Jt S/D <= 50Jt"),
							array("Start"=>50000001, "End"=>100000000, "Fields"=>"PokokHutang", "Label"=>" > 50Jt S/D <= 100Jt"),
							array("Start"=>100000001, "End"=>9999999999999999999, "Fields"=>"PokokHutang", "Label"=>" > 100Jt"));
			break;
		
		case	"05": // Pokok Pinjaman
			$array	= array(array("Start"=>1, "End"=>12, "Fields"=>"Tenor", "Label"=>" 1  - 12 Bulan"),
							array("Start"=>13, "End"=>18, "Fields"=>"Tenor", "Label"=>" 13 - 18 Bulan"),
							array("Start"=>20, "End"=>24, "Fields"=>"Tenor", "Label"=>" 19 - 24 Bulan"),
							array("Start"=>26, "End"=>30, "Fields"=>"Tenor", "Label"=>" 25 - 30 Bulan"),
							array("Start"=>32, "End"=>36, "Fields"=>"Tenor", "Label"=>" 31 - 36 Bulan"),
							array("Start"=>38, "End"=>99999999, "Fields"=>"Tenor", "Label"=>" 37 - 48 Bulan"));
			break;
	}
	
	return $array;
}

function GetInserntif($Parameter, $Status)
{
	if(($Parameter >= 10) && ($Parameter <=15))
	{
		if($Status == 'C')
		{
			$Insertif = '17500';
		} else {
			$Insertif = '5000';
		}
	} else {
		if(($Parameter >= 16) && ($Parameter <=20))
		{
			if($Status == 'C')
			{
				$Insertif = '20000';
			} else {
				$Insertif = '5000';
			}
		} else {
			if(($Parameter >= 21) && ($Parameter <=25))
			{
				if($Status == 'C')
				{
					$Insertif = '22500';
				} else {
					$Insertif = '5000';
				}
			} else {
				if($Parameter >= 26)
				{
					if($Status == 'C')
					{
						$Insertif = '25000';
					} else {
						$Insertif = '5000';
					}
				}
			}
		}	
	}
	
	return $Insertif;
}

function Compress_File($JenisData, $Cabang, $Parameter, $Number, $Tanggal, $Path, $PathDir)
{
	#$PathDir 	= 'D:/AAS/ZIP/';
	#$Tanggal 	= date('dmY');
	$NoRegister = rand(10,99);	
	
	switch($JenisData)
	{
		case 'Pembayaran': 	// Data Pembayaran
			$FileName= $Path.'PY'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
		
		case 'Booking':		// Data Booking
			$FileName = $Path.'BO'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
		
		case 'Tolakan':		// Data Tolakan
			$FileName = $Path.'TL'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
				
		case 'Pencairan':	// Data Pencairan
			$FileName = $Path.'CR'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
			
		case 'Tiban':		// Data Tiban
			$FileName = $Path.'TB'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
			
		case 'DataCabang':		// Data Umum (General)
			#$Path = 'C:/Handler/Temp/';
			$FileName = $Path.'DC'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
		
		case 'DataPusat':		// Data Umum (General)
			#$Path = 'C:/Handler/Temp/';
			$FileName = $Path.'DP'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
		
		case 'Lapkas':		// Data Umum (General)
			$FileName = $Path.'LK'.'-'.$Cabang.'-'.$Tanggal.'-'.$NoRegister.'.zip';
			break;
		
		case 'Penarikan':
			$FileName = $Path.'TR'.'-'.$Cabang.'-'.$Tanggal.'-'.$NoRegister.'.zip';
			break;
		
		case 'Collection':
			$FileName = $Path.'IS'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
		
		case 'DataCollection':
			$FileName = $Path.'CL'.'-'.$Cabang.'-'.$Tanggal.'-'.$NoRegister.'.zip';
			break;
			
		case 'Aplikasi':
			$FileName = $Path.'AP'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
		
		case 'Tarikan':
			$FileName = $Path.'TR'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
			
		case 'Pesan':
			$FileName= $Path.'PS'.'-'.$Cabang.'-'.$Tanggal.'-'.$NoRegister.'.zip';
			break;
			
		case 'Master':		// Data Tiban
			$FileName = $Path.'MS'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
		
		case 'Posting':		// Data Tiban
			$FileName = $Path.'PO'.'-'.$Cabang.'-'.$Tanggal.'-'.$Number.'.zip';
			break;
			
		case 'Kunjungan':		// Data Umum (General)
			$FileName = $Path.'JB'.'-'.$Cabang.'-'.$Tanggal.'-'.$NoRegister.'.zip';
			break;
	}
	
	$Destination = str_replace('/', '\\', $Parameter);
	
	$Del_Destination = str_replace('/', '\\', $Path);
	
	shell_exec($PathDir . "/" . 'fbzip.exe -a '. $FileName .' '. $Destination);
	
	shell_exec('DEL '. $Del_Destination .'*.AJF');
}

function getListWilayah()
{
	$Wilayah			= array(array('ID'=>'01', 'NamaWilayah'=>'Wil I', 	'Cabang'=>"'18000', '05000', '24000', '10000', '19000'"),
								array('ID'=>'02', 'NamaWilayah'=>'Wil II', 	'Cabang'=>"'02000', '17000', '01000', '09000', '13000'"),
								array('ID'=>'03', 'NamaWilayah'=>'Wil III', 'Cabang'=>"'07000', '08000', '29000', '32000', '15000'"),
								array('ID'=>'04', 'NamaWilayah'=>'Wil IV', 	'Cabang'=>"'03000', '06000', '14000', '11000', '26000', '12000'"),
								array('ID'=>'05', 'NamaWilayah'=>'Wil V', 	'Cabang'=>"'04000', '20000', '16000', '23000', '28000', '31000'"),
								array('ID'=>'06', 'NamaWilayah'=>'Wil VI', 	'Cabang'=>"'22000', '21000', '25000', '27000', '30000'"));
								
	return $Wilayah;
}

function getIntervalHari($var)
{
	switch($var)
	{
		case	1:
			$array		= array(array("start"=>1, "end"=>3, "label"=>"  1 -   3"),
								array("start"=>4, "end"=>7, "label"=>"  4 -   7"),
								array("start"=>8, "end"=>14, "label"=>" 8 -  14"),
								array("start"=>15, "end"=>21, "label"=>" 15 -  21"),
								array("start"=>22, "end"=>29, "label"=>" 22 -  29"),
								array("start"=>30, "end"=>59, "label"=>" 30 -  59"),
								array("start"=>60, "end"=>89, "label"=>" 60 -  89"),
								array("start"=>90, "end"=>99999, "label"=>" 90 -  UP"));
			break;

		case	2:
			$array		= array(array("start"=>1, "end"=>7, "label"=>"  1 -   7"),
								array("start"=>8, "end"=>29, "label"=>"  8 -  29"),
								array("start"=>30, "end"=>59, "label"=>" 30 -  59"),
								array("start"=>60, "end"=>89, "label"=>" 60 -  89"),
								array("start"=>90, "end"=>119, "label"=>" 90 - 119"),
								array("start"=>120, "end"=>149, "label"=>"120 - 149"),
								array("start"=>150, "end"=>179, "label"=>"150 - 179"),
								array("start"=>180, "end"=>99999, "label"=>"180 - UP "));
			break;
		
		case	3:
			$array		= array(array("start"=>1, "end"=>3, "label"=>"  1 -   3"),
								array("start"=>4, "end"=>7, "label"=>"  4 -   7"),
								array("start"=>8, "end"=>14, "label"=>"  8 -  14"),
								array("start"=>15, "end"=>21, "label"=>" 15 -  21"),
								array("start"=>22, "end"=>29, "label"=>" 22 -  29"),
								array("start"=>30, "end"=>59, "label"=>" 30 -  59"),
								array("start"=>60, "end"=>89, "label"=>" 60 -  89"),
								array("start"=>90, "end"=>99999, "label"=>" 90 - UP "));
			break;
		
		case	4:
			$array		= array(array("start"=>1, "end"=>3, "label"=>"  1 -   3"),
								array("start"=>4, "end"=>7, "label"=>"  4 -   7"),
								array("start"=>8, "end"=>14, "label"=>"  8 -  14"),
								array("start"=>15, "end"=>21, "label"=>" 15 -  21"),
								array("start"=>22, "end"=>29, "label"=>" 22 -  29"),
								array("start"=>30, "end"=>59, "label"=>" 30 -  59"),
								array("start"=>60, "end"=>89, "label"=>" 60 -  89"),
								array("start"=>90, "end"=>119, "label"=>" 90 - 119"),
								array("start"=>120, "end"=>149, "label"=>" 120 - 149"),
								array("start"=>150, "end"=>179, "label"=>" 150 - 179"),
								array("start"=>180, "end"=>9999, "label"=>" 180 - UP "));
			break;

		case	5:
			//<option value="5">1-3, 4-7, 8-29, 30-59, 60-89, 90-119, 120-149, 150-179, 180-9999</option>
			$array		= array(array("start"=>1, "end"=>3, "label"=>"  1 -   3"),
								array("start"=>4, "end"=>7, "label"=>"  4 -   7"),
								array("start"=>8, "end"=>29, "label"=>"  8 -  29"),
								array("start"=>30, "end"=>59, "label"=>" 30 -  59"),
								array("start"=>60, "end"=>89, "label"=>" 60 -  89"),
								array("start"=>90, "end"=>119, "label"=>" 90 - 119"),
								array("start"=>120, "end"=>149, "label"=>"120 - 149"),
								array("start"=>150, "end"=>179, "label"=>"150 - 179"),
								array("start"=>180, "end"=>9999, "label"=>"180 - UP "));
			break;
		
		case	6:
			//<option value="6" checked>1-3, 4-7, 8-24, 25-59, 60-89, 90-119, 120-149, 150-179, 180-9999</option>
			$array		= array(array("start"=>1, "end"=>3, "label"=>"    1 -   3"),
								array("start"=>4, "end"=>7, "label"=>"  4 -   7"),
								array("start"=>8, "end"=>24, "label"=>"  8 -  24"),
								array("start"=>25, "end"=>59, "label"=>" 25 -  29"),
								array("start"=>60, "end"=>89, "label"=>" 60 -  89"),
								array("start"=>90, "end"=>119, "label"=>" 90 - 119"),
								array("start"=>120, "end"=>149, "label"=>"120 - 149"),
								array("start"=>150, "end"=>179, "label"=>"150 - 179"),
								array("start"=>180, "end"=>9999, "label"=>"180 - UP "));
			break;
			
		case	7:
			//<option value="7" checked>1-360, 361-9999</option>
			$array		= array(array("start"=>1, "end"=>360, "label"=>"    1 - 360"),
								array("start"=>361, "end"=>9999, "label"=>"361 - UP "));
	}
	
	return 	$array;
}

function getListJenisKredit()
{
	$array	= array(array("id"=>"P", "name"=>"Pembelian Bekas", "color"=>"AFD8F8"),
					array("id"=>"B", "name"=>"Pembelian Baru", "color"=>"F6BD0F"),
					array("id"=>"R", "name"=>"Refinancing", "color"=>"A66EDD"));
					
	return $array;
}

function getJenisTransaksi($var)
{
	switch($var){
		case 1:
			$Jenis_Transaksi	= 'Proceed';
			break;
		
		case 2:
			$Jenis_Transaksi	= 'Adm Booking';
			break;
		
		case 3:
			$Jenis_Transaksi	= 'Penagihan';
			break;
			
		case 4:
			$Jenis_Transaksi	= 'Penarikan';
			break;
			
		case 5:
			$Jenis_Transaksi	= 'Antar Cabang';
			break;
		
		case 6:
			$Jenis_Transaksi	= 'Pend Lain-Lain';
			break;
			
		case 7:
			$Jenis_Transaksi	= 'Lain-Lain';
			break;
			
		case 8:
			$Jenis_Transaksi	= 'Titipan Angsuran';
			break;
			
		case 9:
			$Jenis_Transaksi	= 'Bunga Bank';
			break;
			
		case 10:
			$Jenis_Transaksi	= 'Koreksi Penghapusan';
			break;
			
		case 11:
			$Jenis_Transaksi	= 'Reguler Payment';
			break;
			
		case 12:
			$Jenis_Transaksi	= 'Early Termination';
			break;
			
		case 21:
			$Jenis_Transaksi	= 'Koreksi Kas Ke Bank';
			break;
			
		case 22:
			$Jenis_Transaksi	= 'Koreksi Bank Ke Kas';
			break;
		
		default :
			$Jenis_Transaksi	= '';
	}
	
	return $Jenis_Transaksi;
}

function getCaraBayar($var)
{
	switch($var) {
		case	"C":
			$Name	= "Cash";
			break;
		
		case	"T":
			$Name	= "TRF";
			break;
		
		case	"G":
			$Name	= "Giro";
			break;
		
		case	"K":
			$Name	= "Collector";
			break;		
		
		default:
			$Name	= "Error";
	}
	
	return $Name;	
}

function getPemakaian($var) {
	switch($var) {
		case	"P":
			$Name	= "Pribadi";
			break;
		
		case	"N":
			$Name	= "Niaga";
			break;
		
		case	"K":
			$Name	= "Komersil";
			break;
	}
	
	return $Name;
}
function getStatusGiro($var)
{
	switch($var) {
		case	"C":
			$Name	= "Cair";
			break;
		
		case	"T":
			$Name	= "Tolak";
			break;
		
		case	"":
			$Name	= "Masuk";
			break;
		
		default:
			$Name	= "Error";
	}
	
	return $Name;
}

function getStatusBayar($var)
{
	switch($var) {
		case	1:
			$Name	= "Lunas Regular";
			break;
		
		case	2:
			$Name	= "Lunas ET";
			break;
		
		case	3:
			$Name	= "WO";
			break;
		
		case	4:
			$Name	= "Ayda";
			break;
		
		case	"N":
			$Name	= "Normal";//"Rundown";
			break;
		
		case	"5":
			$Name	= "Adm"; //ABDA
			break;
		
		case	"6":
			$Name	= "Denda"; //"Ayda Jual";//
			break;
			
		case	"7":
			$Name	= "ET Adm ";//"E.T Ayda";
			break;
		
		case	"8":
			$Name	= "ET Denda";//"Recovery";
			break;
		
		case	"A":
			$Name	= "Advance";
			break;
			
		case	"9":
			$Name	= "Koreksi Denda";
			break;
		case	"10":
			$Name	= "Koreksi Denda Ke Angsuran";
			break;
		case	"11":
			$Name	= "Koreksi Belum Masuk Angsuran";
			break;
		case	"12":
			$Name	= "Koreksi Bayar Angsuran Pending";
			break;
		case	41:
			$Lunas	= "Ayda";
			break;
		case	42:
			$Lunas	= "Jual Ayda";
			break;
		case	43:
			$Lunas	= "E.T Remedial Ayda";
			break;		
		case	40:
			$Lunas	= "ABDA";
			break;
		case	41:
			$Lunas	= "WO";
			break;
		case	42:
			$Lunas	= "Recovery ABDA/WO";
			break;	
		case	43:
			$Lunas	= "E.T Remedial ABDA/WO";
			break;		
		default:
			$Name	= "-";
	}
	
	return $Name;
}

function getJenisAngsur($var)
{
	switch($var) {
		case	1:
			$Name	= "Advance";
			break;
		
		case	2:
			$Name	= "Arrears";
			break;
	}
	
	return $Name;
}

function getJenisKredit($var)
{
	switch($var) {
		case	P:
			$Name	= "Bekas";
			break;
		
		case	B:
			$Name	= "Baru";
			break;
		
		case	R:
			$Name	= "Refinance";
			break;
		
		case	G:
			$Name	= "Garis Bawah";
			break;
	}
	
	return $Name;
}

function getColor($var)
{
	switch($var) {
		case "01000":
			$Color	= "FF0000";
			break;
		case "02000":
			$Color	= "F6BD0F";
			break;
		case "03000":
			$Color	= "8BBA00";
			break;
		case "04000":
			$Color	= "FF8E46";
			break;
		case "05000":
			$Color	= "D64646";
			break;
		case "06000":
			$Color	= "008E8E";
			break;
		case "07000":
			$Color	= "8E468E";
			break;
		case "08000":
			$Color	= "588526";
			break;
		case "09000":
			$Color	= "B3AA00";
			break;
		case "10000":
			$Color	= "AFD8F8";
			break;
		case "11000":
			$Color	= "99CC00";
			break;
		case "12000":
			$Color	= "CC00CC";
			break;	
		case "13000":
			$Color	= "FF9900";
			break;	
		case "14000":
			$Color	= "660000";
			break;	
		case "15000":
			$Color	= "6699FF";
			break;	
		case "16000":
			$Color	= "333300";
			break;
		case "17000":
			$Color	= "FF6699";
			break;
		case "18000":
			$Color	= "663399";
			break;
		case "19000":
			$Color	= "000066";
			break;
		case "20000":
			$Color	= "9900FF";
			break;
		case "21000":
			$Color	= "003300";
			break;
		case "22000":
			$Color	= "CCCC66";
			break;
		case "23000":
			$Color	= "33FF99";
			break;
		case "24000":
			$Color	= "CCCCCC";
			break;
		case "25000":
			$Color	= "999999";
			break;          
		case "26000":
			$Color	= "CC3300";
			break;
		case "27000":
			$Color	= "9933FF";
			break;
		case "28000":
			$Color	= "990000";
			break;
		case "29000":
			$Color	= "996666";
			break;
		case "30000":
			$Color	= "993399";
			break;
		case "31000":
			$Color	= "009900";
			break;
		case "32000":
			$Color	= "FFCC99";
			break;
		default:
			$Color	= "AFD8F8";
	}
	
	return $Color;
}

function GetHeaderReportRinci($Parameter)
{
	switch($Parameter)
	{
		case 'Alamat':
			$Title		= 'Alamat'; $Length	= 140; $LabelAlign	= 'C'; $Align = 'L'; 
			break;
		
		case 'NoTelp':
			$Title		= 'No Telp'; $Length	= 32; $LabelAlign	= 'C'; $Align = 'L'; 
			break;
			
		case 'Periode':
			$Title		= 'Prd'; $Length = 5; $LabelAlign = 'R'; $Align = 'R';
			break;
		
		case 'OSPinjaman':
			$Title		= 'OS Pinjaman'; $Length = 18; $LabelAlign = 'R'; $Align	= 'R';
			break;
		
		case 'OSPokok':
			$Title		= 'OS Pokok'; $Length = 18; $LabelAlign = 'R'; $Align	= 'R';
			break;
		
		case 'Cicilan':
			$Title		= 'Angsuran'; $Length = 18; $LabelAlign = 'R'; $Align	= 'R';
			break;
		
		case 'Lama':
			$Title		= 'Lama'; $Length = 5; $LabelAlign = 'R'; $Align	= 'R';
			break;
		//Tenor
		case 'Tenor':
			$Title		= 'Tenor'; $Length = 7; $LabelAlign = 'R'; $Align	= 'R';
			break;
			
		case 'RealHari':
			$Title		= 'Real'; $Length = 5; $LabelAlign = 'R'; $Align	= 'R';
			break;
			
		case 'RealHari_Bucket':
			$Title		= 'Real Hari'; $Length = 12; $LabelAlign = 'R'; $Align	= 'R';
			break;	
		
		case 'Denda':
			$Title		= 'Denda'; $Length = 15; $LabelAlign = 'R'; $Align	= 'R';
			break;
		
		case 'Adm':
			$Title		= 'Adm'; $Length = 15; $LabelAlign = 'R'; $Align	= 'R';
			break;
		
		case 'Tunggakan':
			$Title		= 'Tunggakan'; $Length = 18; $LabelAlign = 'R'; $Align	= 'R';
			break;
		
		case 'TglJthTempo':
			$Title		= 'TglJtTempo'; $Length = 11; $LabelAlign = 'C'; $Align	= 'C';
			break;
		
		case 'KodeDealer':
			$Title		= 'Dealer'; $Length = 30; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'Wilayah':
			$Title		= 'Wil'; $Length = 5; $LabelAlign = 'C'; $Align	= 'C';
			break;
		
		case 'Surveyor':
			$Title		= 'Surveyor'; $Length = 30; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'NoPolisi':
			$Title		= 'NoPolisi'; $Length = 12; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'KodeSU':
			$Title		= 'Sektor Usaha'; $Length = 40; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'JenisKredit':
			$Title		= 'Jenis Kredit'; $Length = 17; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'Tahun':
			$Title		= 'Tahun'; $Length = 6; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'ProdukKredit':
			$Title		= 'Produk'; $Length = 25; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'KodeModel':
			$Title		= 'Model Kendaraan'; $Length = 25; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'KodeJenis':
			$Title		= 'Jenis Kendaraan'; $Length = 25; $LabelAlign = 'C'; $Align	= 'L';
			break;
			
		case 'NoMesin':
			$Title		= 'No Mesin'; $Length = 25; $LabelAlign = 'C'; $Align	= 'L';
			break;
			
		case 'NoRangka':
			$Title		= 'No Rangka'; $Length = 25; $LabelAlign = 'C'; $Align	= 'L';
			break;
			
		case 'Warna':
			$Title		= 'Warna'; $Length = 25; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'HutangDenda':
			$Title		= 'Hutang Denda'; $Length = 15; $LabelAlign = 'R'; $Align	= 'R';
			break;
			
		case 'HutangAdm':
			$Title		= 'Hutang Adm'; $Length = 15; $LabelAlign = 'R'; $Align	= 'R';
			break;
			
		case 'Merek':
			$Title		= 'Merek'; $Length = 25; $LabelAlign = 'C'; $Align	= 'L';
			break;
			
		case 'Tipe':
			$Title		= 'Tipe'; $Length = 35; $LabelAlign = 'C'; $Align	= 'L';
			break;
		
		case 'Collector':	
			$Title		= 'Collector'; $Length = 30; $LabelAlign = 'C'; $Align	= 'L';
			break;
			
		case 'Bucket':	
			$Title		= 'Bucket'; $Length = 15; $LabelAlign = 'C'; $Align	= 'L';
			break;	
			
			
	}
	
	return	array("title"=>$Title, "length"=>$Length, "label_align"=>$LabelAlign, "align"=>$Align);
}

function GetListReportRinci()
{
	return	array(array("title"=>"NomorPin", "fields"=>"NomorPin"), 
				  array("title"=>"Alamat", "fields"=>"Alamat"),
				  array("title"=>"OS Pinjaman", "fields"=>"OSPinjaman"), 
				  array("title"=>"OS Pokok", "fields"=>"OSPokok"), 
				  array("title"=>"Periode", "fields"=>"Periode"), 
				  array("title"=>"Lama", "fields"=>"Lama"), 
				  array("title"=>"Tunggakan", "fields"=>"Tunggakan"), 
				  array("title"=>"Denda", "fields"=>"Denda"), 
				  array("title"=>"Real", "fields"=>"RealHari"), 
				  array("title"=>"TglJtTempo", "fields"=>"TglJthTempo"), 
				  array("title"=>"Wilayah", "fields"=>"WilayahColl"), 
				  array("title"=>"No Polisi", "fields"=>"NoPolisi"), 
				  array("title"=>"Tahun", "fields"=>"TahunBuat"), 
				  array("title"=>"Dealer", "fields"=>"KodeDealer"), 
				  array("title"=>"Model Kendaraan", "fields"=>"KodeModel"), 
				  array("title"=>"Jenis Kendaraan", "fields"=>"KodeJenis"), 
				  array("title"=>"Surveyor", "fields"=>"Surveyor"), 
				  array("title"=>"Produk", "fields"=>"ProdukKredit"), 
				  array("title"=>"Jenis Kredit", "fields"=>"JenisKredit"), 
				  array("title"=>"Sektor Usaha", "fields"=>"KodeSU"));
}

function getListTableMaster() {
	$array	= array(array("table"=>"karyawan", "kode"=>"NIK", "param"=>"22", "name"=>"Nama"),
					array("table"=>"profile", "kode"=>"kodecabang", "param"=>"23", "name"=>"NamaCabang"),
					array("table"=>"tabel_daftar_bank", "kode"=>"Kodebank", "param"=>"01", "name"=>"NamaBank"),
					array("table"=>"tabel_fasilitaskartukredit", "kode"=>"Kode", "param"=>"02", "name"=>"FasilitasKartuKredit"),
					array("table"=>"tabel_hubunganreferensi", "kode"=>"Kode", "param"=>"03", "name"=>"Hubungan"),
					array("table"=>"tabel_jabatan", "kode"=>"KodeJbtn", "param"=>"04", "name"=>"Jabatan"),
					array("table"=>"tabel_jenis_asuransi", "kode"=>"KodeJenisAsuransi", "param"=>"05", "name"=>"JenisAsuransi"),
					array("table"=>"tabel_jenis_kendaraan", "kode"=>"KodeJenis", "param"=>"06", "name"=>"NamaJenis"),
					array("table"=>"tabel_jenisnasabah", "kode"=>"Kode", "param"=>"07", "name"=>"JenisNasabah"),
					array("table"=>"tabel_jenispekerjaan", "kode"=>"Kode", "param"=>"08", "name"=>"JenisPekerjaan"),
					array("table"=>"tabel_jnsnasabah", "kode"=>"Kode", "param"=>"09", "name"=>"JenisNasabah"),
					array("table"=>"tabel_kota", "kode"=>"KodeKota", "param"=>"10", "name"=>"Kota"),
					array("table"=>"tabel_lokasi", "kode"=>"KodeLokasi", "param"=>"11"),
					array("table"=>"tabel_merek", "kode"=>"KodeMerek", "param"=>"12", "name"=>"NamaMerek"),
					array("table"=>"tabel_model_kendaraan", "kode"=>"KodeModel", "param"=>"13", "name"=>"NamaModel"),
					array("table"=>"tabel_perusahaan_asuransi", "kode"=>"KodeAsuransi", "param"=>"14", "name"=>"NamaPrshnAsuransi"),
					array("table"=>"tabel_produk_kredit", "kode"=>"ProdukKredit", "param"=>"15", "name"=>"NamaProduk"),
					array("table"=>"tabel_rate_asuransi", "kode"=>"KodeJenisAsuransi", "param"=>"16", "name"=>"KodeAsuransi"),
					array("table"=>"tabel_sektorusaha", "kode"=>"KodeSU", "param"=>"17", "name"=>"SektorUsaha"),
					array("table"=>"tabel_statusrumah", "kode"=>"Kode", "param"=>"18", "name"=>"StatusRumah"),
					array("table"=>"tabel_tipe_kendaraan", "kode"=>"KodeTipe", "param"=>"19", "name"=>"NamaTipe"),
					array("table"=>"tabel_trayek", "kode"=>"KodeTrayek", "param"=>"20"),
					array("table"=>"tabel_wilayah", "kode"=>"KodeWilayah", "param"=>"21", "name"=>"NamaWilayah"),
					array("table"=>"tabel_dealer", "kode"=>"KodeDealer", "param"=>"24", "name"=>"NamaDealer"),
					array("table"=>"tabel_refund", "kode"=>"KodeDealer", "param"=>"25", "name"=>"NamaDealer"));
	return $array;
}

function getPorfolio($var)
{
	switch($var) {
		case	"01": // Pinjaman
			$array	= array(array("Start"=>0, "End"=>20000000, "Fields"=>"PokokHutang", "Label"=>" <= 20Jt"),
							array("Start"=>20000000, "End"=>30000000, "Fields"=>"PokokHutang", "Label"=>" >  20Jt S/D <= 30Jt"),
							array("Start"=>30000000, "End"=>40000000, "Fields"=>"PokokHutang", "Label"=>" >  30Jt S/D <= 40Jt"),
							array("Start"=>40000000, "End"=>50000000, "Fields"=>"PokokHutang", "Label"=>" >  40Jt S/D <= 50Jt"),
							array("Start"=>50000000, "End"=>10000000, "Fields"=>"PokokHutang", "Label"=>" >  50Jt S/D <= 100Jt"),
							array("Start"=>100000000, "End"=>9999999999999999, "Fields"=>"PokokHutang", "Label"=>" >  100Jt"));
			break;
			
		case	"02": // Baru / Bekas
			$array	= array(array("ID"=>"P", "Label"=>"Baru", "Fields"=>"JenisKredit"),
							array("ID"=>"B", "Label"=>"Bekas", "Fields"=>"JenisKredit"));
			break;
			
		case	"03": // Tenor Pinjaman
			$array	= array(array("Start"=>1, "End"=>12, "Fields"=>"Tenor", "Label"=>" 1  - 12 Bulan"),
							array("Start"=>12, "End"=>18, "Fields"=>"Tenor", "Label"=>" 13 - 18 Bulan"),
							array("Start"=>19, "End"=>24, "Fields"=>"Tenor", "Label"=>" 19 - 24 Bulan"),
							array("Start"=>25, "End"=>30, "Fields"=>"Tenor", "Label"=>" 25 - 30 Bulan"),
							array("Start"=>31, "End"=>36, "Fields"=>"Tenor", "Label"=>" 31 - 36 Bulan"),
							array("Start"=>37, "End"=>48, "Fields"=>"Tenor", "Label"=>" 37 - 48 Bulan"));
			break;
			
		case	"04": // Besar Cicilan
			$array	= array(array("Start"=>0, "End"=>1000000, "Fields"=>"Angsuran", "Label"=>" <= 1 Juta"),
							array("Start"=>1000000, "End"=>2000000, "Fields"=>"Angsuran", "Label"=>" >  1 <= 2"),
							array("Start"=>2000000, "End"=>3000000, "Fields"=>"Angsuran", "Label"=>" >  2 <= 3"),
							array("Start"=>3000000, "End"=>4000000, "Fields"=>"Angsuran", "Label"=>" >  3 <= 4"),
							array("Start"=>4000000, "End"=>5000000, "Fields"=>"Angsuran", "Label"=>" >  4 <= 5"),
							array("Start"=>5000000, "End"=>9999999999999999, "Fields"=>"Angsuran", "Label"=>" >  5 Juta"));
			break;
		
		case	"05": // Besar DP
			$array	= array(array("Start"=>0, "End"=>10, "Fields"=>"PokokHutang", "Label"=>" <= 10%"),
							array("Start"=>10, "End"=>20, "Fields"=>"PokokHutang", "Label"=>" >  10% <= 20%"),
							array("Start"=>20, "End"=>30, "Fields"=>"PokokHutang", "Label"=>" >  20% <= 30%"),
							array("Start"=>30, "End"=>40, "Fields"=>"PokokHutang", "Label"=>" >  30% <= 40%"),
							array("Start"=>40, "End"=>50, "Fields"=>"PokokHutang", "Label"=>" >  40% <= 50%"),
							array("Start"=>50, "End"=>9999999999999999, "Fields"=>"PokokHutang", "Label"=>" >  50%"));
			break;
	}
}

function getSummaryInsentifKualitatif($Target)
{
	if($Target	> 2) {
		$Insentif	= 0;
	} else {
		if($Target	> 1.5) {
			$Insentif	= 500000;
		} else {
			if($Target	> 1) {
				$Insentif	= 600000;
			} else {
				$Insentif	= 750000;
			}
		}
	}
	
	return $Insentif;
}

function getRincianInsentif($Type, $BiayaAdm, $Parameter, $Jabatan)
{
	if($Type != 'Pool')
	{
		if($Jabatan == "13") {
			if($BiayaAdm >= 25000) {
				if($Parameter >= 24) {
					$Value	= 5000;
				} else {
					if($Parameter >= 16) {
						$Value	= 7500;
					} else {
						if($Parameter >= 8) {
							$Value	= 10000;
						} else {
							if($Parameter >= 4) {
								$Value	= 12500;
							} else {
								$Value	= 5000;
							}
						}	
					}
				}
			} else {
				if($Parameter <= 4) {
					$Value	= 5000;
				} else {
					$Value	= 0;
				}
			}
		} else {
			if($Jabatan == "11") {
				if($BiayaAdm >= 60000) {
					if($Parameter >= 54) {
						$Value	= 25000;
					} else {
						if($Parameter >= 46) {
							$Value	= 30000;
						} else {
							if($Parameter >= 38) {
								$Value	= 35000;
							} else {
								if($Parameter >= 30) {
									$Value	= 40000;
								} else {
									$Value	= 0;
								}
							}
						}
					}
				} else {
					if($Parameter >= 30) {
						$Value	= 15000;
					} else {
						$Value	= 0;
					}
				}
			}
		}
	} else {
		if($Jabatan == "13") {
			$Value	= 250000;
		} else {
			if($Jabatan == "11") {
				if($Parameter >= 54) {
					$Value	= 300000;
				} else {
					if($Parameter >= 46) {
						$Value	= 400000;
					} else {
						if($Parameter >= 38) {
							$Value	= 500000;
						} else {
							if($Parameter >= 30) {
								$Value	= 600000;
							} else {
								$Value	= 0;
							}
						}				
					}
				}
			} else {
				$Value	= 0;
			}
		}
	}	
	return $Value;
}

function getStatusTarget($Param, $Value)
{
	if($Value <= $Param) {
		$Status		= "Tercapai";
		$Value		= 1;
	} else {
		$Status		= "Tidak";
		$Value		= 0;
	}

	return array('Status'=>$Status,
				 'Value'=>$Value);
}

function getInsentifKualitatif($Rasio, $Account, $Collector, $Jabatan)
{
	# -----------------------------------------------
	$qSelect	= mysql_query("SELECT	Collector, Rasio, DPD, Account FROM Target_Collection WHERE Collector = '$Collector'");
	$rs			= mysql_fetch_array($qSelect);
	# -----------------------------------------------
	if($Jabatan == "13") {
		if(($Rasio <= $rs[Rasio]) && ($Account <= $rs[Account])) # OK Semua
		{
			$Insentif	= 300000;
			$Keterangan	= "";
		} else {
			if(($Rasio <= $rs[Rasio]) && ($Account > $rs[Account])) # Account Tidak
			{
				$Insentif	= 200000;
				$Keterangan	= "";
			} else {
				if(($Rasio > $rs[Rasio]) && ($Account <= $rs[Account])) # Rasio Tidak
				{
					$Insentif	= 100000;
					$Keterangan	= "";
				} else {
					if(($Rasio > $rs[Rasio]) && ($Account > $rs[Account])) # Semua Tidak
					{
						$Insentif	= 0;
						$Keterangan	= " - Insentif Kualitatif Rp 0 Karena Target Rasio & Sisa Account Tidak Tercapai \n";
						$Keterangan	.= " - Surat Teguran. \n";
					} else {
						$Insentif	= "Error";
						$Keterangan	= "Error";
					}
				}		
			}
		}
	} else {
		if(($Rasio <= $rs[DPD]) && ($Account <= $rs[Account])) # OK Semua
		{
			$Insentif	= 350000;
			$Keterangan	= "";
		} else {
			if(($Rasio <= $rs[DPD]) && ($Account > $rs[Account])) # Account Tidak
			{
				$Insentif	= 200000;
				$Keterangan	= "";
			} else {
				if(($Rasio > $rs[DPD]) && ($Account <= $rs[Account])) # Rasio Tidak
				{
					$Insentif	= 100000;
					$Keterangan	= "";
				} else {
					if(($Rasio > $rs[DPD]) && ($Account > $rs[Account])) # Semua Tidak
					{
						$Insentif	= 0;
						$Keterangan	= " - Insentif Kualitatif Rp 0 Karena Target DPD & Sisa Account Tidak Tercapai \n";
						$Keterangan	.= " - Surat Teguran. \n";
					} else {
						$Insentif	= "Error";
						$Keterangan	= "Error";
					}
				}		
			}
		}
	}
	
	return array('Insentif'=>$Insentif,
				 'Keterangan'=>$Keterangan);
}

function getPengurangInsentif($Insentif, $UnitPengurang, $Jabatan)
{
	if($Jabatan == "13") {	
		if($UnitPengurang > 10) {
			$TotalInsentif	= ($Insentif * 40) / 100;
			$Pengurang		= $Insentif - $TotalInsentif;
			$Keterangan		.= " - Insentif Yang Didapat Adalah 40 % Dari Rp " . number_format($Insentif) . " \n";
			$Keterangan		.= "   Karena Terdapat Account 30 UP Sebanyak $UnitPengurang Unit" . " \n";	
		} else {
			if($UnitPengurang >= 8) {
				$TotalInsentif	= ($Insentif * 60) / 100;
				$Pengurang		= $Insentif - $TotalInsentif;
				$Keterangan		.= " - Insentif Yang Didapat Adalah 60 % Dari Rp " . number_format($Insentif) . " \n";
				$Keterangan		.= "   Karena Terdapat Account 30 UP Sebanyak $UnitPengurang Unit" . " \n";
			} else {
				if($UnitPengurang >= 4) {
					$TotalInsentif	= ($Insentif * 80) / 100;
					$Pengurang		= $Insentif - $TotalInsentif;
					$Keterangan		.= " - Insentif Yang Didapat Adalah 80 % Dari Rp " . number_format($Insentif) . " \n";
					$Keterangan		.= "   Karena Terdapat Account 30 UP Sebanyak $UnitPengurang Unit" . " \n";
				} else {
					if($UnitPengurang >= 1) {
						$TotalInsentif	= ($Insentif * 90) / 100;
						$Pengurang		= $Insentif - $TotalInsentif;
						$Keterangan		.= " - Insentif Yang Didapat Adalah 90 % Dari Rp " . number_format($Insentif) . " \n";
						$Keterangan		.= "   Karena Terdapat Account 30 UP Sebanyak $UnitPengurang Unit" . " \n";
					} else {
						$TotalInsentif	= $Insentif;
						$Pengurang		= 0;
					}
				}
			}
		}
	} else {
		if($UnitPengurang > 5) {
			$TotalInsentif	= ($Insentif * 40) / 100;
			$Pengurang		= $Insentif - $TotalInsentif;
			$Keterangan		.= " - Insentif Yang Didapat Adalah 40 % Dari Rp " . number_format($Insentif) . " \n";
			$Keterangan		.= "   Karena Terdapat Account 60 UP Sebanyak $UnitPengurang Unit" . " \n";	
		} else {
			if($UnitPengurang >= 4) {
				$TotalInsentif	= ($Insentif * 70) / 100;
				$Pengurang		= $Insentif - $TotalInsentif;
				$Keterangan		.= " - Insentif Yang Didapat Adalah 70 % Dari Rp " . number_format($Insentif) . " \n";
				$Keterangan		.= "   Karena Terdapat Account 60 UP Sebanyak $UnitPengurang Unit" . " \n";
			} else {
				if($UnitPengurang >= 1) {
					$TotalInsentif	= ($Insentif * 80) / 100;
					$Pengurang		= $Insentif - $TotalInsentif;
					$Keterangan		.= " - Insentif Yang Didapat Adalah 80 % Dari Rp " . number_format($Insentif) . " \n";
					$Keterangan		.= "   Karena Terdapat Account 60 UP Sebanyak $UnitPengurang Unit" . " \n";
				} else {
					$TotalInsentif	= $Insentif;
					$Pengurang		= 0;
				}
			}
		}
	}
	
	return array('TotalInsentif'=>$TotalInsentif,
				 'Pengurang'=>$Pengurang,
				 'Keterangan'=>$Keterangan);
}

function getJenisKelamin($var)
{
	switch($var)
	{
		case "P":
			$JenisKelamin	= "Pria";
			break;
		
		case "W":
			$JenisKelamin	= "Wanita";
			break;
	}
	
	return $JenisKelamin;
}

function getStatusKawin($var)
{
	switch($var)
	{
		case "M":
			$Status	= "Sudah Menikah";
			break;
		
		case "S":
			$Status = "Belum Menikah";
			break;
		
		case "D":
			$Status	= "Duda / Janda";
			break;
	}
	
	return $Status;
}

function GetStatusAplikasi($var)
{
	switch($var)
	{
		case C:
			$Status	= "Cair";
			break;
		
		case T:
			$Status	= "Tolak";
			break;
		
		case L:
			$Status	= "Batal";
			break;
		
		case B:
			$Status	= "Belum Di Proses";
			break;
		
		case X:
			$Status	= "Black List";
			break;
		
		case S:
			$Status	= "Komite Kredit Setuju";
			break;
		
		default :
			$Status = "Error";
	}
	
	return $Status;
}

function GetNoRegister($KodeCabang) {
	# -----------------------------------------------------------
	# KodeCabang (2) Digit
	# -----------------------------------------------------------
	$Kode	= substr($KodeCabang, 0, 2);
	# -----------------------------------------------------------
	# Query Max NoRegister
	# -----------------------------------------------------------
	$qGet	= mysql_query("SELECT MAX(NoRegister) as NoRegister FROM Aplikasi WHERE LEFT(NoRegister, 2) = '$Kode' AND LENGTH(NoRegister) = '8'");
	$rsGet	= mysql_fetch_array($qGet);
	# -----------------------------------------------------------
	# Get Max NoRegister
	# -----------------------------------------------------------
	$LastNoRegister	= $rsGet[NoRegister];
	$Number			= substr($LastNoRegister, 2, 6);
	# -----------------------------------------------------------
	$CalcNumber		= $Number + 1;
	$LenCalcNumber	= strlen($CalcNumber);
	
	if($CalcNumber <= 999999)
	{
		switch($LenCalcNumber)
		{
			case 1:
				$GetNumber	= '00000' . $CalcNumber;
				break;
			
			case 2:
				$GetNumber	= '0000' . $CalcNumber;
				break;
			
			case 3:
				$GetNumber	= '000' . $CalcNumber;
				break;
			
			case 4:
				$GetNumber	= '00' . $CalcNumber;
				break;
			
			case 5:
				$GetNumber	= '0' . $CalcNumber;
				break;
			
			case 6:
				$GetNumber	= $CalcNumber;
				break;
		}
		# -----------------------------------------------------------
		$NewNumber		= $Kode . $GetNumber;
		# -----------------------------------------------------------
		$qSelectCek		= mysql_query("SELECT * FROM Pinjam WHERE NoRegister = '$NewNumber'");
		$cnSelectCek	= mysql_num_rows($qSelectCek);
		# -----------------------------------------------------------
		if($cnSelectCek > 0) {
			$qMaxPinjam		= mysql_query("SELECT	MAX(NoRegister) AS NoRegister FROM Pinjam WHERE KodeCabang = '$KodeCabang'");
			$rsMaxPinjam	= mysql_fetch_array($qMaxPinjam);
			# -------------------------------------------------------
			$qGet	= mysql_query("SELECT NoRegister FROM Aplikasi WHERE NoRegister = '$rsMaxPinjam[NoRegister]'");
			$rsGet	= mysql_fetch_array($qGet);
			$nrGet	= mysql_num_rows($qGet);
			# -------------------------------------------------------
			if($nrGet > 0) {
				return "Error Code $rsMaxPinjam[NoRegister]";
			} else {
				$LastNoRegister	= $rsMaxPinjam[NoRegister];
				$Number			= substr($LastNoRegister, 2, 6);
				# -----------------------------------------------------------
				$CalcNumber		= $Number + 1;
				$LenCalcNumber	= strlen($CalcNumber);
				# -----------------------------------------------------------
				switch($LenCalcNumber)
				{
					case 1:
						$GetNumber	= '00000' . $CalcNumber;
						break;
					
					case 2:
						$GetNumber	= '0000' . $CalcNumber;
						break;
					
					case 3:
						$GetNumber	= '000' . $CalcNumber;
						break;
					
					case 4:
						$GetNumber	= '00' . $CalcNumber;
						break;
					
					case 5:
						$GetNumber	= '0' . $CalcNumber;
						break;
					
					case 6:
						$GetNumber	= $CalcNumber;
						break;
				}
				# -----------------------------------------------------------
				$NewNumber		= $Kode . $GetNumber;
				# -----------------------------------------------------------
				return $NewNumber;
			}
		} else {
			return $NewNumber;
		}
	} else {
		# -----------------------------------------------------------
		return 'Error Code';
		# -----------------------------------------------------------
	}
}

function CekNomorPolisi($Parameter)
{
	if(ereg("[a-zA-Z]","$Parameter"))
	{
		return True;
	} else {
		return False;
	}
}

function GetNomorPolisi($NomorPol)
{
	$ValNoPol=strtoupper($NomorPol);
	
	for($i=0; $i<=strlen($ValNoPol)-1; $i++)
	{
		$Nilai=substr($ValNoPol,$i,1);
		
		$Proses = CekNomorPolisi($Nilai);
		
		if(($Proses==True) && ($i<=2))
		{
			$Awal=$Awal."$Nilai";
		} else {
			if($Proses==True)
			{
				$Akhir=$Akhir."$Nilai";
			} else {
				$AngkaAwal=$AngkaAwal."$Nilai";
			}
		}
	}
	
	$Angka=trim($AngkaAwal);
	$SendParam=$Awal."_".$Angka."_".$Akhir;
	
	return $SendParam;
}

function GabungNomorPolisi($Awalan, $Pertengahan, $Akhiran)
{
	if(strlen($Awalan)<2)
	{
		$ParamAwal=$Awalan."  "; // Dua Spasi
	} else {
		$ParamAwal=$Awalan." "; // Satu Spasi
	}
	
	if(strlen($Akhiran)<2)
	{
		$ParamAkhir="  ".$Akhiran; // Dua Spasi
	} else {
		$ParamAkhir=" ".$Akhiran; // Satu Spasi
	}
	
	$NilaiAkhir=$ParamAwal.$Pertengahan.$ParamAkhir;
	
	return $NilaiAkhir;
}

function getMerek($var) {
	$value	= substr($var, 0, 3);
	
	if($value == "BMW") {
		$Merek	= "BMW";
	} else {
		if($value == "BIM") {
			$Merek	= "BIMAN";
		} else {
			if($value == "CHE") {
				$Merek	= "CHEV";
			} else {
				if($value == "DAE") {
					$Merek	= "DAEWO";
				} else {
					if($value == "DAI") {
						$Merek	= "DAIHA";
					} else {
						if($value == "FOR") {
							$Merek	= "FORD";
						} else {
							if($value == "HIN") {
								$Merek	= "HN";
							} else {
								if($value == "HON") {
									$Merek	= "HONDA";
								} else {
									if($value == "HYU") {
										$Merek	= "HYUN";
									} else {
										if($value == "ISUZU") {
											$Merek	= "ISUZU";
										} else {
											if($value == "KAW") {
												$Merek	= "KWAK";
											} else {
												if($value == "KIA") {
													$Merek	= "KIA";
												} else {
													if($value == "MAZ") {
														$Merek	= "MAZDA";
													} else {
														if($value == "MER") {
															$Merek	= "MER";
														} else {
															if($value == "NIS") {
																$Merek	= "NISSA";
															} else {
																if($value == "OPE") {
																	$Merek	= "OPEL";
																} else {
																	if($value == "PEU") {
																		$Merek	= "PEUGE";
																	} else {
																		if($value == "SUZ") {
																			$Merek	= "SUZUK";
																		} else {
																			if($value == "TIM") {
																				$Merek	= "TIM";
																			} else {
																				if($value == "TOY") {
																					$Merek	= "TOYOT";
																				} else {
																					$Merek	= $var;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	return $Merek;
}

function getAdmPenagihan($var) {
	if($var >= 90) {
		$Adm	= 1500000;
	} else {
		if($var >= 60) {
			$Adm	= 1000000;
		} else {
			if($var >= 30) {
				$Adm	= 500000;
			} else {
				if($var >= 24) {
					$Adm	= 250000;
				} else {
					if($var >= 16) {
						$Adm	= 100000;
					} else {
						if($var >= 8) {
							$Adm	= 50000;
						} else {
							if($var >= 4) {
								$Adm	= 25000;
							} else {
								$Adm	= 0;
							}
						}
					}
				}
			}
		}
	}
	
	return $Adm;
}
?>
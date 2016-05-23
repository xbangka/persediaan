<?php 
include('config.php');

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "'. $host .'";</script>';
	exit;
}


$k = explode('/',$_SERVER['PHP_SELF']);

$k = explode('.php',end($k));

$roll1='';
$acv0='';$acv1='';$acv2='';$acv3='';$acv4='';
$acv5='';$acv6='';$acv7='';$acv8='';

if($k[0] == 'listmutasi'){
	
	$acv1='active-menu';
	
}elseif($k[0] == 'listbarang'){
	
	$acv2='active-menu';
	
}elseif($k[0] == 'listunit'){
	
	$acv3='active-menu';
	
}elseif($k[0] == 'frm_rekapitulasi'){
	
	$acv4='active-menu';
	$roll1='active';
	
}elseif($k[0] == 'frm_semua_brg'){
	
	$acv5='active-menu';
	$roll1='active';
	
}elseif($k[0] == 'frm_perbrg'){
	
	$acv6='active-menu';
	$roll1='active';
	
}elseif($k[0] == 'pengaturan'){
	
	$acv7='active-menu';
	
}elseif($k[0] == 'listpermintaan'){
	
	$acv0='active-menu';
}

?>
    
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Persediaan Stok Barang :: AMF</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
   <script src="assets/js/jquery.min.js"></script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="welcome.php"><?php echo $_SESSION['u']; ?></a> 
            </div>
            
            
            <?php
			$sql = mysqli_query($jazz,"SELECT x FROM permintaan WHERE dilihat = '0' AND approve = '1'");
			$xpermintaan = mysqli_num_rows($sql);
			if($xpermintaan>=1){
				
			?>
            <div style="color: white;padding: 15px 50px 5px 50px;float: left;font-size: 16px;">
			<a href="listpermintaan.php" class="btn btn-default"><img src="../public/images/led.gif"/> <?php echo $xpermintaan;?> Permintaan</a>
    		</div>
            <?php 
			}
			if($xpermintaan==0){$zpermintaan='';}else{$zpermintaan='<button class="btn btn-danger btn-xs">'.$xpermintaan.'</button>';}
			?>
            
            
            
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Last access : 

<?php 
$sql = mysqli_query($jazz,"SELECT tgl FROM log_masuk WHERE id = '$_SESSION[id]' ORDER BY tgl DESC LIMIT 0,13");
$n = 0 ;
while($data2 = mysqli_fetch_array($sql)){
	$n += 1 ;
	$k = explode('-',substr($data2[0],0,10));
	$l = substr($data2[0],11,5) ;
	$tgl99[$n] = $k[2] . ' ' . $namabulan[floattostr($k[1])] . ' ' . $k[0] . ' &nbsp; ' . $l ;
} ?>

<div class="btn-group">
  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><?php echo $tgl99[1] ; ?> &nbsp;</button>
  <ul class="dropdown-menu">
  	<?php 
	for($x=2;$x<=$n;$x++){
		echo '<li><a>' . $tgl99[$x] . '</a></li>';
	} ?>
  </ul>
</div>

 &nbsp; <a href="logout.php" class="btn btn-danger">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="assets/img/find_user.png" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a class="<?php echo $acv0 ;?>" href="listpermintaan.php"> Permintaan <?php echo $zpermintaan;?></a>
                    </li>
                    <li>
                        <a class="<?php echo $acv1 ;?>" href="listmutasi.php"> Mutasi</a>
                    </li>
                     <li>
                        <a class="<?php echo $acv2 ;?>" href="listbarang.php"> Barang</a>
                    </li>
                    <li>
                        <a class="<?php echo $acv3 ;?>" href="listunit.php"> Unit</a>
                    </li>
					                   
                    <li class="<?php echo $roll1 ;?>" >
                        <a href="javascript:;"> Laporan<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a class="<?php echo $acv4 ;?>" href="frm_rekapitulasi.php"> &nbsp; Rekapitulasi</a>
                            </li>
                            <li>
                                <a class="<?php echo $acv5 ;?>" href="frm_semua_brg.php"> &nbsp; Mutasi Semua Barang</a>
                            </li>
                            <li>
                                <a class="<?php echo $acv6 ;?>" href="frm_perbrg.php"> &nbsp; Mutasi Perbarang</a>
                            </li>
                        </ul>
                    </li>  
                    <li>
                        <a class="<?php echo $acv7 ;?>" href="pengaturan.php"> Pengaturan</a>
                    </li>	
                </ul>
               
            </div>
            
        </nav>  
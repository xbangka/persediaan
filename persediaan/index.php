<?php 
include('config.php');

if(isset($_SESSION['id'])){
	echo '<script>window.location= "mutasi.php";</script>';
	exit;
}

$pesan='';
if(isset($_POST['kirim'])){
	$u = md100($_POST['pengguna']);
	$p = md100($_POST['sandi']);
	$sql = mysqli_query($jazz,"SELECT * FROM user WHERE u = '$u'");
	$ada = mysqli_num_rows($sql);
	if($ada>=1){
		$data = mysqli_fetch_array($sql);
		if($p==$data['p']){
			
			$_SESSION['id'] = $data['x'] ;
			$_SESSION['u'] = $_POST['pengguna'] ;
			$tgl = date('Y-m-d H:i:s');
			mysqli_query($jazz,"INSERT INTO log_masuk VALUES('', '$tgl', '$data[x]', '$_POST[pengguna]')");
			echo '<script>window.location= "welcome.php";</script>';
			exit;
			
		}else{
			$pesan='<li class="danger alert">Maaf gagal masuk</li>';
		}
	}else{
		$pesan='<li class="danger alert">Maaf user tidak dikenal</li>';
	}
}

?>

<!doctype html>

<html class="no-js" lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Persediaan Stok Barang :: AMF</title>

	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

	<link rel="stylesheet" href="assets/css/gumby.css">

</head>


<body>


	<div class="navbar" id="nav1" gumby-fixed="top">
		<div class="row">
			<div align="center">
            
			<ul>
				<li><a href="javascript:;">..:: Kontrol Persediaan Barang ::.. &nbsp;  &nbsp; &nbsp; &nbsp; </a></li>
                <li><a href="javascript:;">..:: PT. Arthabuana Margausaha Finance ::..</a></li>
			</ul>
			</div>
		</div>
	</div>





	<div class="row">
        
        <div align="center">
			<?php 
            echo $pesan ;
            ?>
		</div>
        
        <div class="row">
			<div class="four columns">
			</div>
            
            <div align="center">
            <div style="background-image:url(libraries/amazons.jpg);width:800px;height:500px">
			<div style="width:400px">
				<form action="" method="post">
					<ul>
						<div align="center">
							<p>&nbsp;</p>
                            <h3 style="color:#F7F2F2; text-emphasis:center">Akses Masuk</h3>
                            &nbsp;<br/>
						</div>
                        <li class="prepend append double field">
							<input class="text input" name="pengguna" type="text" placeholder="Username" autocomplete="off" />
							<input class="password input" name="sandi" type="password" placeholder="Password" />
						</li>
                        <div align="center">
							<div class="pretty medium primary btn"><input type="submit" name="kirim" value="Login" /></div>
						</div>
					</ul>
				</form>
			</div>
            </div>
            </div>
            
			<div class="four columns">
			</div>
		</div>
	</div>
    
    




	<script>
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	</script>
    
  </body>
</html>

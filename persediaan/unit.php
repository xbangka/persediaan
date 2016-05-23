<?php 
include('head.php');


if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

$pesan = '';
if(isset($_POST['kirim']) && $_POST['kode']!=''){
	$idx = $_POST['idx'];
	$a = $_POST['kode'];
	$b = $_POST['ket'];
	$x = $_POST['even'];
	
	if($x=='new'){
		$q = mysqli_query($jazz,"SELECT unite FROM unite WHERE unite = '$a'");
		$ada = mysqli_num_rows($q);
		if($ada>=1){
			$pesan = '<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Maaf, data sudah ada.
                      </div>';
		}else{
			mysqli_query($jazz,"INSERT INTO unite VALUES('', '$a', '$b')");
			
			//////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'INSERT unit ' . $a . ' keterangan ' . $b ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			//////////////////
			
			echo '<script>window.location= "listunit.php";</script>';
			exit();
		}
	}else{

		mysqli_query($jazz,"UPDATE unite SET unite = '$a', keterangan = '$b' WHERE x = '$idx'");
		
		//////////////////
		$tgl = date('Y-m-d H:i:s') ;
		$aksi = 'UPDATE unit x:' . $idx . ' ' . $a . ' keterangan ' . $b ;
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
		mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
		//////////////////
		
		echo '<script>window.location= "listunit.php";</script>';
		exit();
		
	}
	
}




if(empty($_GET['unit'])){
	$event = 'new';
	$btn = 'Simpan';
	$data[0] = '';
	$data[1] = '';
	$data[2] = '';
}else{
	$kd = $_GET['unit'] ;
	$sql = mysqli_query($jazz,"SELECT *	FROM unite	WHERE unite = '$kd'");
	$data = mysqli_fetch_array($sql);
	$event = 'edit';
	$btn = 'Update';
}
?>







<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
        
            <div class="col-md-12 col-sm-12">
        
             <!--  table  --> 
             <div class="panel panel-default">
                <div class="panel-heading">
                   Form Unit/Satuan/Kemasan
                </div>
                <div class="panel-body">
                    <div class="table-responsive" align="center">
                    	<?php echo $pesan ; ?>
                        <form method="post" action="">
                		<input name="even" type="hidden" value="<?php echo $event; ?>">
                        <input name="idx" type="hidden" value="<?php echo $data[0]; ?>">
                        <table border="0">
                            <tbody>
                                <tr style="height:30px">
                                    <td width="120px" align="right">Kode Satuan</td>
                                    <td width="20px" align="center">:</td>
                                    <td width="4px">
                                    	<input name="kode" <?php if($event=='edit') { echo 'readonly style="background-color:#D0F5BE"';} ?> 
                                        type="text" value="<?php echo $data[1] ;?>" />
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Keterangan</td>
                                    <td align="center">:</td>
                                    <td colspan="2">
                                    	<input name="ket" type="text" style="width:350px" 
                                    	value="<?php echo $data[2] ;?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="height:30px">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center">
                                    	<input class="btn btn-primary btn-sm" type="submit" name="kirim" value="<?php echo $btn ;?>" />
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /. table  -->
            </div>
            
        </div>     
         <!-- /. ROW  -->           
    </div>
     <!-- /. PAGE INNER  -->
 </div>
 <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->



    
    
<?php 
include('foot.php'); 
?>
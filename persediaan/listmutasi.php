<?php 
include('head.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

if( empty($_POST['tgl1']) || empty($_POST['tgl2']) ){
	$tgl1 = date('Y-m-d 00:00:00');
	$tgl2 = date('Y-m-d H:i:s');
	$tgl_1 = date('d/m/Y 00:00:00');
	$tgl_2 = date('d/m/Y H:i:s');
}else{
	$k = explode('/',substr($_POST['tgl1'],0,10));
	$l = substr($_POST['tgl1'],10,9);
	$tgl1 = $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . $l ;
	$tgl_1 = $_POST['tgl1'];
	
	$k = explode('/',substr($_POST['tgl2'],0,10));
	$l = substr($_POST['tgl2'],10,9);
	$tgl2 = $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . $l ;
	$tgl_2 = $_POST['tgl2'];
}

?>



<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
            <div class="col-md-12">



                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li><a href="mutasi.php">&nbsp; + &nbsp;</a>
                        </li>
                        <li class="active"><a href="#datamutasi" data-toggle="tab">Data</a>
                        </li>
                    </ul>
    
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="datamutasi">
                            <h3 align="center">Catatan Mutasi Barang</h3>
                            <div class="panel-body">
                            <div class="table-responsive">
                                <table style="border:#FFFFFF">
                                    <tr>
                                        <th align="left">
                                        <form action="" method="post">
                                            Dari &nbsp;
                                            <input name="tgl1" class="narrow text input" type="text" value="<?php echo $tgl_1 ;?>" />
                                            &nbsp; s/d &nbsp;
                                            <input name="tgl2" class="narrow text input" type="text" value="<?php echo $tgl_2 ;?>" /> 
                                            &nbsp;
                                            <input type="submit" class="btn btn-primary btn-sm" value=" &nbsp; > &nbsp; " />
                                        </form>
                                        </th>
                                    </tr>  
                                </table>
                            	<br />
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;width:60px">No Mutasi</th>
                                            <th style="text-align:center;width:160px">Tanggal</th>
                                            <th style="text-align:center">Keterangan</th>
                                            <th style="text-align:center;width:50px">Jumlah</th>
                                            <th style="text-align:center;width:50px">Kode Barang</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $sql = mysqli_query($jazz,"SELECT *	FROM Mutasi WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' ORDER BY x DESC");
                                    while($data = mysqli_fetch_array($sql)){
                                        $k = explode('-',substr($data[2],0,10));
                                        $l = substr($data[2],10,9);
                                        $tgl = $k[2] . '/' . $k[1] . '/' . $k[0] . ' ' . $l ;
                                    ?>
                                        <tr>
                                            <td><?php echo $data[1] ;?></td>
                                            <td><?php echo $tgl ;?></td>
                                            <td><?php echo $data[5] ;?></td>
                                            <td align="center"><?php echo $data[6] ;?></td>
                                            <td><?php echo $data[3] ;?></td>
                                            <td width="5px">
                                                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal"
                                                href="javascript:;" title="Delete" onclick="getnomutasi('<?php echo $data[1] ; ?>')">
                                                  x
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                
                              </div>
                             </div>
                        </div>
                    </div>
                </div>

    

            </div>
            
        </div>     
         <!-- /. ROW  -->           
    </div>
     <!-- /. PAGE INNER  -->
 </div>
 <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->




<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:500px;top:10px">
        <div class="modal-content">
            
            <form method="post" action="deletemutasi.php">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Yakin Ingin Hapus ?</h4>
            </div>
            <div class="modal-body">
                
                <input name="nomutasi" id="nomutasi" type="hidden"/>
                Masukan password terlebih dahulu &nbsp;
                <input name="pass" class="text input" type="password" style="text-align:center"/>
                
            </div>
            <div class="modal-footer" style="text-align:center">
                <input type="submit" class="btn btn-primary" value="Hapus" />
                &nbsp; &nbsp; &nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
            
            </form>
            
        </div>
    </div>
</div>




    
<script>

	function getnomutasi(nomutasi) {
		$('#nomutasi').val(nomutasi);
		$('#myModalLabel').html('Yakin Ingin Hapus nomor mutasi <b style="color:#AB0002">'+nomutasi+'</b> ?');
	}
</script>

<?php 
include('foot.php'); 
?>
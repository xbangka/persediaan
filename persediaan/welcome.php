<?php 
include('head.php');

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

?>





<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
            <div class="col-md-12">
             <h2>Selamat datang di system informasi persediaan barang</h2>   
                <h5>Semoga bermanfaat dan bisa menghadirkan suasana baru di lingkungan kerja kita. Amin </h5>
                <br />
                <h5><em>Tim Kreatif</em></h5>
                <p>&nbsp;</p>
            </div>
            
            
            <div class="col-md-12 col-sm-12">
        
             <!--  table  --> 
             <div class="panel panel-default">
                <div class="panel-heading">
                   Daftar Stok Terbatas
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width:90px;text-align:center">Kode Barang</th>
                                    <th style="text-align:center">Nama Barang</th>
                                    <th style="width:70px;text-align:center">Unit</th>
                                    <th style="width:90px;text-align:center">Harga</th>
                                    <th style="width:120px;text-align:center">Status</th>
                                    <th style="width:50px;text-align:center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								$sql =mysqli_query($jazz,"SELECT * FROM barang WHERE sisa <= batasmin ORDER BY kodebrg ASC");
								while($data = mysqli_fetch_array($sql)){
								?>
									<tr>
										<td align="center"><?php echo $data[1] ;?></td>
										<td><?php echo $data[2] ;?></td>
										<td><?php echo $data[3] ;?></td>
										<td align="right"><?php echo number_format($data[4], 0, '', '.') ;?></td>
										<td><?php if($data[5]=='1') { echo 'Tersedia'; }else{ echo 'Tidak Tersedia'; } ;?></td>
										<td align="right"><?php echo number_format($data[8], 0, '', '.') ;?></td>
									</tr>
								<?php
								}
								?>
                            </tbody>
                        </table>
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
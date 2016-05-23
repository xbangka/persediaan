<?php 
include('head.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}


if(isset($_POST['txt_brg'])){
	$where_barang = "WHERE brg like '%".$_POST['txt_brg']."%'";
	$txt_brg = $_POST['txt_brg'] ;
	if( strtoupper(substr($txt_brg,0,3))=='ATK' || strtoupper(substr($txt_brg,0,3))=='CTK' || strtoupper(substr($txt_brg,0,3))=='PKR' ){
		$where_barang = "WHERE kodebrg like '".strtoupper($txt_brg)."%'";
	}
}else{
	$where_barang = '';
	$txt_brg = '' ;
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
                        <li><a href="barang.php">&nbsp; + &nbsp;</a>
                        </li>
                        <li class="active"><a href="#databrg" data-toggle="tab">Data</a>
                        </li>
                    </ul>
    
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="databrg">
                            <h3 align="center">Daftar Barang</h3>
                            <div class="panel-body">
                            <div class="table-responsive">
                                <form role="form" method="post" action="">
                                    <div class="form-group input-group">
                                        <input name="txt_brg" type="text" class="form-control" value="<?php echo $txt_brg; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
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
										if($txt_brg==''){
											include('pajinasi.php');
											$p = new Paging();
											$batas=20;
											$posisi = $p->cariPosisi($batas);
											$sql =mysqli_query($jazz,"SELECT * FROM barang ".$where_barang." ORDER BY brg ASC LIMIT $posisi,$batas");
											$jmlrecord = mysqli_num_rows(mysqli_query($jazz,"SELECT x FROM barang " . $where_barang));
											$jmlhalaman = $p->jumlahHalaman($jmlrecord,$batas);
										}else{
											$sql =mysqli_query($jazz,"SELECT * FROM barang ".$where_barang." ORDER BY brg ASC");

										}
                                        while($data = mysqli_fetch_array($sql)){
                                        ?>
                                            <tr>
                                                <td align="center"><a href="barang.php?kode=<?php echo $data[1] ;?>"><?php echo $data[1] ;?></a></td>
                                                <td><a href="barang.php?kode=<?php echo $data[1] ;?>"><?php echo $data[2] ;?></a></td>
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
                                
                                <?php
								if($txt_brg==''){
                                ?>
                                
                                <ul class="pagination pull-right">
									<?php
                                        $linkHalaman = $p->navHalaman($_REQUEST['page'],$jmlhalaman,'?6226392658758726496922393482423423472364275452sdfsf54234726478=6226392658758726496922sfsf3934824sfs2342347236427545254234726478','');
                                        echo $linkHalaman;
                                    ?>
                                </ul> 
                                
                                <?php
								}
                                ?>
                                
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


    
    
<?php 
include('foot.php'); 
?>
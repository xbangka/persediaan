<?php 
include('head.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}


if(isset($_POST['txt_unit'])){
	$where_unit = "WHERE unite like '%".$_POST['txt_unit']."%'";
	$txt_unit = $_POST['txt_unit'] ;
}else{
	$where_unit = '';
	$txt_unit = '' ;
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
                        <li><a href="unit.php">&nbsp; + &nbsp;</a>
                        </li>
                        <li class="active"><a href="#databrg" data-toggle="tab">Data</a>
                        </li>
                    </ul>
    
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="databrg">
                            <h3 align="center">Daftar Unit/Satuan/Kemasan</h3>
                            <div class="panel-body">
                            <div class="table-responsive">
                                <form role="form" method="post" action="">
                                    <div class="form-group input-group">
                                        <input name="txt_unit" type="text" class="form-control" value="<?php echo $txt_unit; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                            	<i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="width:10px;text-align:center">No.</th>
                                            <th style="width:150px;text-align:center">unit</th>
                                            <th style="text-align:left">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										$posisi = 0 ;
										if($txt_unit==''){
											include('pajinasi.php');
											$p = new Paging();
											$batas=20;
											$posisi = $p->cariPosisi($batas);
											$sql =mysqli_query($jazz,"SELECT * FROM unite ".$where_unit." ORDER BY unite ASC LIMIT $posisi,$batas");
											$jmlrecord = mysqli_num_rows(mysqli_query($jazz,"SELECT x FROM unite " . $where_unit));
											$jmlhalaman = $p->jumlahHalaman($jmlrecord,$batas);
										}else{
											$sql =mysqli_query($jazz,"SELECT * FROM unite ".$where_unit." ORDER BY unite ASC");

										}
										$n = $posisi ;
                                        while($data = mysqli_fetch_array($sql)){
											$n += 1 ;
                                        ?>
                                            <tr>
                                                <td align="right"><?php echo $n ;?></td>
                                                <td><a href="unit.php?unit=<?php echo $data[1] ;?>"><?php echo $data[1] ;?></a></td>
                                                <td><a href="unit.php?unit=<?php echo $data[1] ;?>"><?php echo $data[2] ;?></a></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                
                                <?php
								if($txt_unit==''){
                                ?>
                                
                                <ul class="pagination pull-right">
									<?php
                                        $linkHalaman = $p->navHalaman($_REQUEST['page'],$jmlhalaman,'?622639265875872649692239348242342325525253472364275452sdfsf54234726478=6226392658758726496922sfsf3934823424sfs234234232347236427545254234726478','');
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
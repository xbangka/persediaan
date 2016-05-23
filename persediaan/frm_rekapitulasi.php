<?php 
include('head.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

	$tgl_1 = date('d/m/Y');
	$tgl_2 = date('d/m/Y');


?>




<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
            <div class="col-md-12">
             <h3>Laporan Rekaitulasi</h3>  <br />  
                <table border="0">
                    <tr>
                        <th align="center">
                        <form action="pdf_rekapitulasi.php" method="post" target="_blank">
                        	Dari &nbsp;
                            <input name="tgl1" style="text-align:center" type="text" value="<?php echo $tgl_1 ;?>" />
                            &nbsp; s/d &nbsp;
                            <input name="tgl2" style="text-align:center" type="text" value="<?php echo $tgl_2 ;?>" />
                            &nbsp;
                            <input type="submit" class="btn btn-primary" value=" &nbsp; Preview &nbsp; " /></div>
                        </form>
                        </th>
                    </tr>  
                </table>
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
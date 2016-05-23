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
             <h3>Laporan Mutasi Perbarang</h3>  <br />  
                
                <form action="pdf_lap_perbrg.php" method="post" target="_blank">
                <table border="0">
                    <tr style="height:40px">
                        <td>
                        	<input name="kodebrg" class="narrow text input" type="text" id="kodebrg" />
                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                              Browse...
                            </a>
                        </td>
                    </tr>
                    <tr style="height:40px">
                        <td>
                        	<input class="text input" type="text" id="namabrg" style="background-color:#D9C0C1; width:404px" readonly />
                        </td>
                    </tr> 
                    <tr style="height:40px">
                        <td>
                        
                        	Dari &nbsp;
                            <input name="tgl1" style="text-align:center" type="text" value="<?php echo $tgl_1 ;?>" />
                            &nbsp; s/d &nbsp;
                            <input name="tgl2" style="text-align:center" type="text" value="<?php echo $tgl_2 ;?>" />
                            &nbsp;
                            <input type="submit" class="btn btn-primary btn-sm" value=" &nbsp; Preview &nbsp; " />
                        </td>
                    </tr>
                </table>
                </form>
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
    <div class="modal-dialog" style="width:900px;top:10px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pilih Salah Satu Barang</h4>
            </div>
            <div class="modal-body">
                
                <div class="form-group input-group">
                    <input name="txt_brg" type="text" class="form-control" id="txt_brg" autocomplete="off" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                
                <div id="loaded_contents">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align:center">Kode Barang</th>
                                <th style="text-align:center">Nama Barang</th>
                                <th style="text-align:center">Satuan</th>
                                <th style="text-align:center">Harga</th>
                                <th style="text-align:center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $sql2 = mysqli_query($jazz,"SELECT * FROM barang ORDER BY x ASC LIMIT 0,10");
                        while($data2 = mysqli_fetch_array($sql2)){
                        ?>
                            <tr>
                                <td align="center">
                                <a href="javascript:;" data-dismiss="modal"
                                    onclick="getdatabrg('<?php echo $data2[1] . '\',\'' . $data2[2] . '\',\'' . $data2[8] ;?>')" >
                                    <?php echo $data2[1] ;?>
                                </a>
                                </td>
                                <td>
                                <a href="javascript:;" data-dismiss="modal"
                                    onclick="getdatabrg('<?php echo $data2[1] . '\',\'' . $data2[2] . '\',\'' . $data2[8] ;?>')">
                                    <?php echo $data2[2] ;?>
                                </a>
                                </td>
                                <td><?php echo $data2[3] ;?></td>
                                <td align="right"><?php echo number_format($data2[4], 0, '', '.') ;?></td>
                                <td><?php if($data2[5]=='1') { echo 'Tersedia'; }else{ echo 'Tidak Tersedia'; } ;?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script>


function getdatabrg(kd,nama,stok) {
	$('#kodebrg').val(kd);
	$('#namabrg').val(nama);
};	


$("#txt_brg").keyup(function(){
	txt_brg = $("#txt_brg").val();
	n = txt_brg.length ;
	if(n>=3){
		$.ajax({
			type: "POST",
			url: "act/cari_data_barang.php",
			data: 'aksi=2&brg=' + txt_brg,
			cache: false,
			beforeSend: function()
			{
				$("#loaded_contents").html('Mengambil data...');
			},
			success: function(response)
			{
				$("#loaded_contents").html(response);
				
			}
		});
	}
});

</script>

<?php 
include('foot.php'); 
?>
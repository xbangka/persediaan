<?php 
include('head.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}


?>

<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
        	<div class="col-md-6">
                       
                     <!--  Modals-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ganti Password
                        </div>
                        <div class="panel-body">
                            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style=" width:100%">
                              Ganti Password
                            </button>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Ganti Password</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label>Password Sebelumnya</label>
                                            <input id="pass1" type="password" class="form-control" value=""><br />
                                            <hr>
                                            <label>Password Baru</label>
                                            <input id="pass2" type="password" class="form-control" value=""><br />
                                            <label>Verifikasi Password Baru</label>
                                            <input id="pass3" type="password" class="form-control" value=""><br />
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onClick="savepass();" data-dismiss="modal">Save changes</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End Modals-->
                
                </div>
                     <div class="col-md-6">
                          <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Stok Barang
                        </div>
                        <div class="panel-body">
                            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal2" 
                            onClick="bersihkan();" style=" width:100%">
                              Edit Stok Barang
                            </button>
                         </div>
                         
                         <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Edit Stok Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table width="100%" border="0">
                                              <tbody>
                                                <tr>
                                                  <td width="100px" height="40px">Kode Barang</td>
                                                  <td width="100px"><input id="kodebrg" type="text" class="form-control" style="width:100px"></td>
                                                  <td>&nbsp; <button type="button" class="btn btn-primary" onClick="btncari();">Cari</button></td>
                                                </tr>
                                                <tr>
                                                  <td height="40px">Nama Barang</td>
                                                  <td colspan="2"><input id="namabrg" type="text" readonly disabled class="form-control"></td>
                                                </tr>
                                                <tr>
                                                  <td height="40px">Stok</td>
                                                  <td>
                                                  <input id="stokbrg" type="text" class="form-control" autocomplete="off" 
                                                  style="text-align:right;width:70px" onKeypress="return isNumber(event)">
                                                  </td>
                                                  <td><span id="satuan">satuan</span></td>
                                                </tr>
                                                <tr>
                                                  <td height="40px">Validasi Pass</td>
                                                  <td colspan="2">
                                                  <input id="pass" type="password" class="form-control">
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onClick="savestok();" data-dismiss="modal">Save changes</button>
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

<script type="text/javascript">

function savepass() {
	pass1 = $("#pass1").val();
	pass2 = $("#pass2").val();
	pass3 = $("#pass3").val();
	x1 = pass1.length ;
	x2 = pass2.length ;
	if( x1>=1 && x2>=1 && pass2==pass3 ){
		
		$.ajax({
			type: "POST",
			url: "act/pengaturan.php",
			data: 'aksi=1&pass1=' + pass1 + '&pass2=' + pass2 + '&pass3=' + pass3,
			cache: false,
			beforeSend: function()
			{
			},
			success: function(response)
			{
				if(response=='GAGAL'){
					alert("Maaf, gagal melakukan perubahan");
				}else{
					alert("SUCCESS");
				}
			}
		});
		
	}else{
		alert("Maaf, gagal melakukan perubahan");
	}
	
	$("#pass1").val('');
	$("#pass2").val('');
	$("#pass3").val('');
}

function caribrg(kodebrg) {
	$.ajax({
		type: "POST",
		url: "act/pengaturan.php",
		data: 'aksi=2&kodebrg=' + kodebrg,
		cache: false,
		beforeSend: function()
		{
			
		},
		success: function(response)
		{
			if(response!='NONE'){
				str = response.split("|");
				$("#namabrg").val(str[0]);
				$("#stokbrg").val(str[2]);
				$("#satuan").html(str[1]);
			}else{
				$("#namabrg").val('');
				$("#stokbrg").val('');
				$("#satuan").html('');
				alert("Kode yang dimaksud tidak ada dalam database");
			}
		}
	});
}

function btncari() {
	kodebrg = $("#kodebrg").val();
	n = kodebrg.length ;
	if(n>=1){
		caribrg(kodebrg);
	}
}

$("#kodebrg").keyup(function(){
	kodebrg = $("#kodebrg").val();
	n = kodebrg.length ;
	if(n>=7){
		caribrg(kodebrg);
	}
});


function bersihkan() {
	$("#kodebrg").val('');
	$("#namabrg").val('');
	$("#stokbrg").val('');
	$("#satuan").html('Satuan');
	$("#pass").val('');
}



function savestok() {
	kodebrg = $("#kodebrg").val();
	stokbrg = $("#stokbrg").val();
	pass = $("#pass").val();
	x1 = pass.length ;
	x2 = stokbrg.length ;
	if( x1>=1 && x2>=1 ){
		
		$.ajax({
			type: "POST",
			url: "act/pengaturan.php",
			data: 'aksi=3&kodebrg=' + kodebrg + '&stokbrg=' + stokbrg + '&pass=' + pass,
			cache: false,
			beforeSend: function()
			{
			},
			success: function(response)
			{
				if(response=='GAGAL'){
					alert("Maaf, gagal melakukan perubahan");
				}else{
					alert("SUCCESS");
				}
			}
		});
		
	}else{
		alert("Maaf, gagal melakukan perubahan");
	}
}


</script>
    
    
<?php 
include('foot.php'); 
?>
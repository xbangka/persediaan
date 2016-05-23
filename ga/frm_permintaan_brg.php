<?php
session_start();
# -----------------------------
include("db-config.php");

$SE_UserId = '' ;
if(isset($_SESSION['u']))
{
	$SE_UserId = $_SESSION['u'] ;
}



$sql2 = mysqli_query($jazz,"SELECT tabel_departemen.x, tabel_departemen.departemen  FROM tabel_departemen INNER JOIN pemohon ON pemohon.departemen = tabel_departemen.x WHERE pemohon.user_id = '$SE_UserId'");
$rs2 = mysqli_fetch_array($sql2);
$kodedepartemen = $rs2[0];
$departemen = $rs2[1];


?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" type="image/ico" href="../public/images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>General Affair</title>
<link href="../public/style/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../public/plugins/jquery.js"></script>

<!--[if lt IE 7]>
<script type="text/javascript" src="../public/plugins/jquery.helper.js"></script>
<![endif]-->
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
		<td style="background: url(../public/images/header.png);" height="100"><img src="../public/images/ga.png" /></td>
	</tr>
	<tr>
		<td height="50" style="background:url(../public/images/lines-black.png);" class="container-menu" valign="top" width="95%">
							<div id="halaman-utama">
				<img src="../public/images/house.png" border="0" class="images_trans" align="absmiddle" />&nbsp;&nbsp;&nbsp;<a href="../index.php">Halaman Utama</a>
                
                <?php 
	
				if(!empty($departemen)){
				
				?>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="javascript:;">Form Permintaan Barang</a>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="frm_ctt_permintaan_brg.php">Catatan Permintaan Barang</a>
					<?php 
                    $sql = mysqli_query($jazz,"SELECT x FROM tabel_departemen WHERE user_approve = '$SE_UserId'");
                    $ada = mysqli_num_rows($sql);
                    if($ada>=1){
                    ?>
                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <a href="frm_konfirmasi_permintaan_brg.php">Persetujuan Permintaan Barang</a>
                    <?php } ?>
                
                <?php 
				}
				?>
                
				</div>
					</td>
	</tr>
	<tr>
		<td align="center">
			
            
            
            
            
            
            
            
            
            
            
            
            
            
            



<link href="../public/style/style.css" rel="stylesheet" type="text/css" />
<link href="../public/style/bootstrap.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../public/plugins/jquery.js"></script>
<script type="text/javascript" src="../public/script/app.js"></script>
<script type="text/javascript">
function mask(str,textbox,loc,delim) {
	var locs 	= loc.split(',');

	for (var i = 0; i <= locs.length; i++) {
		for (var k = 0; k <= str.length; k++) {
	 		if(k == locs[i]) {
	  			if(str.substring(k, k+1) != delim) {
	    			str = str.substring(0,k) + delim + str.substring(k,str.length)
	  			}
	 		}
		}
 	}
	
	textbox.value = str
}
</script>

<script type="text/javascript" src="../public/script/jquery.min.js"></script>


<body onLoad="startFocus(document.myform.text_tgl_butuh)">

<table border="0" cellpadding="0" cellspacing="0" width="798px" style="margin: 0 auto;" align="center" id="form_posting">
	<tr>
		<td colspan="3" height="10">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="object_header" height="30px" align="left">
        
        Form Permintaan Alat/Barang 
        <?php 
			echo '<span style="float:right">id = ' . $SE_UserId . '</span>';
		if(empty($departemen)){
		
		?>
        <span style="float:right">
        	<form method="post" id="myform" name="myform" action="../ga/proses_login.php">
            User Name 
            <input type="text" name="text_user" id="text_user" class="object_text_login" size="20" onKeypress="return handleEnter(this, event)"> 
            Password 
            <input type="password" name="text_password" id="text_password" class="object_text_login" size="20">
            <input type="submit" value="Login" class="object_button" name="kirim">
            </form>
        </span>
        <?php 
	
		}
		
		?>
        </td>
	</tr>
	<tr>
		<td colspan="3" height="10">&nbsp;</td>
	</tr>
    
    
    
    <?php 
	
	if(!empty($departemen)){
	
	?>
    
    
    <form method="post" id="myform" name="myform" action="../ga/proses_simpan_permintaan_brg.php">
	<input type="hidden" name="user_id" value="<?=$SE_UserId?>">
	<tr>
		<td width="207" align="right" class="object_label" height="25px">Tanggal Permintaan</td>
		<td width="13"></td>
		<td width="578" align="left">
			<input type="text" name="text_tgl_minta" id="text_tgl_minta" value="<?=date("d-m-Y")?>" class="object_text_disabled" size="10" onBlur="javascript:return mask(this.value,this,'2,5','-');" readonly>
		</td>
	</tr>
	<tr>
		<td width="207" align="right" class="object_label" height="25px">Departemen</td>
		<td width="13"></td>
		<td align="left" class="object_label">
			<input type="text" name="text_dept" id="text_dept" class="object_text_disabled" size="30" value="<?=$departemen?>" >
		</td>
	</tr>
	<tr>
		<td width="207" align="right" class="object_label" height="25px">Nama Pemohon</td>
		<td width="13"></td>
		<td align="left">
			
			<?php 
            $sql2 = mysqli_query($jazz,"SELECT 
                                keterangan
                                FROM pemohon 
                                WHERE user_id = '$SE_UserId'");
            $data2 = mysqli_fetch_array($sql2);
            ?>
            <input type="text" name="text_pemohon" id="text_pemohon" class="object_text_disabled" size="30" value="<?=$data2[0]?>" >
            
		</td>
	</tr>
	<tr>
	  <td align="right" class="object_label" height="25px">Tanggal Di Butuhkan</td>
	  <td></td>
	  <td align="left"><input type="text" name="text_tgl_butuh" id="text_tgl_butuh" value="<?=date("d-m-Y")?>" class="object_text" size="10" onBlur="javascript:return mask(this.value,this,'2,5','-');" onKeypress="return isNumber(event)"></td>
    </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">Klasifikasi</td>
	  <td></td>
	  <td align="left" class="object_label">
      		<input type="radio" name="rdo_urgen" id="rdo_urgen" value="0" checked="checked">&nbsp;&nbsp;Biasa&nbsp;&nbsp;
			<input type="radio" name="rdo_urgen" id="rdo_urgen" value="1">&nbsp;&nbsp;Segera&nbsp;&nbsp;
      </td>
    </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">&nbsp;</td>
	  <td></td>
	  <td align="left">&nbsp;</td>
    </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">Kode Barang</td>
	  <td></td>
	  <td align="left">
	    <input type="text" name="kodebrg" id="kodebrg" class="object_text" size="10">
        <input type="button" value="Browse..." class="object_button" id="btn_browse" data-toggle="modal" data-target="#myModal">
	  </td>
    </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">Nama Barang</td>
	  <td></td>
	  <td align="left">
	    <input type="text" class="object_text_disabled" size="50" id="namabrg" name="namabrg">
	  </td>
    </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">Sisa Stok</td>
	  <td></td>
	  <td align="left" class="object_label">
	    <input type="text" name="stokbrg" id="stokbrg" class="object_text_disabled" size="5" style="text-align:right">
        &nbsp;<span id="satuan">Satuan</span>
	  </td>
    </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">Jumlah Yang Diminta</td>
	  <td></td>
	  <td align="left" class="object_label">
	    <input type="text" name="text_jml" id="text_jml" class="object_text" autocomplete="off"
        size="5" style="text-align:right" onKeypress="return isNumber(event)">
        &nbsp;<span id="satuan1">Satuan</span>
	  </td>
    </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">&nbsp;</td>
	  <td></td>
	  <td align="left" class="object_label">
      		<input type="button" value="Ambil" class="object_button" onclick="ambil()"/>
      </td>
	  </tr>
	<tr>
	  <td align="right" class="object_label" height="25px">&nbsp;</td>
	  <td></td>
	  <td align="left" class="object_label">&nbsp;</td>
	  </tr>
	<tr>
		<td colspan="3" height="30">
        



				<div id="loaded_list" align="center">
                <table width="100%" border="1">
                  <tbody>
                    <tr align="center" style="background:#C7CBFC;">
                      <td style="font-size:14px">No.</td>
                      <td style="font-size:14px">Kodebrg</td>
                      <td style="font-size:14px">Nama Barang</td>
                      <td style="font-size:14px">Jml</td>
                      <td style="width:20px">&nbsp;</td>
                    </tr>
                    <?php
					$n = 0 ;
                    $q2=mysqli_query($jazz,"SELECT * FROM temp_rinci_permintaan WHERE kodepm='' AND user_id='$SE_UserId' ORDER BY x ASC LIMIT 0,5");
                    while($da2 = mysqli_fetch_array($q2)){
						$n += 1 ;
						if($n%2==0){ $clr3 = 'background:#E7E7E7'; }else{ $clr3 = '' ; }
					?>
                    <tr style="font-size:14px;text-align:center;<?php echo $clr3 ; ?>">
                      <td><?php echo $n ; ?></td>
                      <td><?php echo $da2['kodebrg'] ; ?></td>
                      <td style="text-align:left">&nbsp;<?php echo $da2['namabrg'] ; ?></td>
                      <td><?php echo $da2['jml'] ; ?></td>
                      <td><a href="javascript:;" onclick="hapus(<?php echo $da2['x'] .',\'' . $da2['namabrg'] .'\'' ; ?>)"><img src="../public/images/delete.png" /></a></td>
                    </tr>
                    <?php
					}
					
					echo '<input type="hidden" id="jml_rec" value="'.$n.'" />' ;
					
					$n = $n + 1 ;
					for( $i= $n ; $i <= 5 ; $i++ ){
						if($i%2==0){ $clr3 = 'background:#E7E7E7'; }else{ $clr3 = '' ; }
					?>
                    <tr style="font-size:14px;text-align:center;<?php echo $clr3 ; ?>">
                      <td><?php echo $i ; ?></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php
					}
					?>
                  </tbody>
                </table>
				</div>
        
        
        
        </td>
	</tr>
	<tr>
	  <td height="25px"></td>
	  <td></td>
	  <td align="left">&nbsp;</td>
	</tr>

	<tr>
		<td width="207" height="25px"></td>
		<td width="13"></td>
		<td align="right">
			<input type="submit" value="Kirim Permintaan" name="kirim" class="object_button">
            <br/><br/><br/>
		</td>
	</tr>
    </form>
    
    
    <?php
	}
	?>
    
    
</table>



















<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:900px;top:1px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pilih Salah Satu Barang</h4>
            </div>
            <div class="modal-body">
                
                <div class="form-group input-group">
                    Ketik Nama Barang : <input name="txt_brg" type="text" class="object_search" id="txt_brg" autocomplete="off" size="100px" />
                     &nbsp; <div style="float:right"><a href="javascript:;" onclick="view_all()">View_All</a></div>
                </div>
                
                <div id="loaded_contents">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align:center">Kode Barang</th>
                                <th style="text-align:center">Nama Barang</th>
                                <th style="text-align:center">Satuan</th>
                                <th style="text-align:center">Stok</th>
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
                                    onclick="getdatabrg('<?php echo $data2[1] . '\',\'' . $data2[2] . '\',\'' . $data2[8] . '\',\'' . $data2[3] ;?>')" >
                                    <?php echo $data2[1] ;?>
                                </a>
                                </td>
                                <td>
                                <a href="javascript:;" data-dismiss="modal"
                                    onclick="getdatabrg('<?php echo $data2[1] . '\',\'' . $data2[2] . '\',\'' . $data2[8] . '\',\'' . $data2[3] ;?>')">
                                    <?php echo $data2[2] ;?>
                                </a>
                                </td>
                                <td><?php echo $data2[3] ;?></td>
                                <td align="right"><?php echo number_format($data2[8], 0, '', '.') ;?></td>
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




<script type="text/javascript">

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function getdatabrg(kd,nama,stok,satuan) {
	$('#kodebrg').val(kd);
	$('#namabrg').val(nama);
	$('#stokbrg').val(stok);
	$('#satuan').html(satuan);
	$('#satuan1').html(satuan);
	
	txt_1 = eval( $("#text_jml").val() );
	txt_2 = eval( $("#stokbrg").val() );
	radio_op = $("input[name=rdo_urgen]:checked").val() ;
	
	if(txt_1 > txt_2 && radio_op=='1'){
		alert("Maaf, stok terbatas");
		$("#text_jml").val('')
	}
}




function ambil() {
	a = $('#kodebrg').val();
	b = $('#namabrg').val();
	c = eval( $('#stokbrg').val()  );
	e = eval( $("#text_jml").val()  );
	h = $('#jml_rec').val();
	
	if(c<e){
		alert("Maaf, stok tidak mencukupi");
	}else if( a=='' || b=='' || c==0 || e==null ){
		alert("Maaf, masukan nama barang yang anda minta");
	}else if( h>='5'){
		alert("Maaf, permintaan hanya sampai lima Item");
	}else{
		$.ajax({
			type: "POST",
			url: "../ga/update_data_permintaan.php",
			data: 'aksi=2&kodebrg=' + a + '&jml=' + e,
			cache: false,
			beforeSend: function()
			{
				$("#loaded_list").html('Fetch Data...');
			},
			success: function(response)
			{
				$("#loaded_list").html(response);
				$('#kodebrg').val('');
				$('#namabrg').val('');
				$('#stokbrg').val('');
				$("#text_jml").val('');
				$('#satuan').html('Satuan');
				$('#satuan1').html('Satuan');
			}
		});
	}
}



function hapus(idx,namabrg) {
	if (confirm('Yakin ingin menghapus ' + namabrg + '?')) {
		$.ajax({
			type: "POST",
			url: "../ga/update_data_permintaan.php",
			data: 'aksi=3&idx=' + idx ,
			cache: false,
			beforeSend: function()
			{
				$("#loaded_list").html('Fetch Data...');
			},
			success: function(response)
			{
				$("#loaded_list").html(response);
			}
		});
	}
}



function view_all() {
	$.ajax({
		type: "POST",
		url: "../ga/cari_data_barang.php",
		data: 'aksi=1&brg=semua_data',
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

$("input:radio[name=rdo_urgen]").click(function() {
    var value = $(this).val();
	txt_1 = eval( $("#text_jml").val() );
	txt_2 = eval( $("#stokbrg").val() );
	if(value=='1' && txt_1 > txt_2){
		alert("Maaf, stok terbatas");
		$("#text_jml").val('')
	}
});

$("#text_jml").keyup(function(){

	txt_1 = eval( $("#text_jml").val() );
	txt_2 = eval( $("#stokbrg").val() );
	radio_op = $("input[name=rdo_urgen]:checked").val() ;
	
	if(txt_1 > txt_2 && radio_op=='1'){
		alert("Maaf, stok terbatas");
		$("#text_jml").val('')
	}
});


$("#txt_brg").keypress(function(){

	txt_brg = $("#txt_brg").val();
	n = txt_brg.length ;
	if(n>=3){
		$.ajax({
			type: "POST",
			url: "../ga/cari_data_barang.php",
			data: 'aksi=1&brg=' + txt_brg,
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

$("#kodebrg").keyup(function(){
	kodebrg = $("#kodebrg").val();
	n = kodebrg.length ;
	if(n>=7){
		$.ajax({
			type: "POST",
			url: "../ga/cari_data_barang.php",
			data: 'aksi=3&kodebrg=' + kodebrg,
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
					$("#satuan1").html(str[1]);
				}else{
					$("#namabrg").val('');
					$("#stokbrg").val('');
					$("#satuan").html('');
					$("#satuan1").html('');
					alert("Kode yang dimaksud tidak ada dalam database");
				}
				
				txt_1 = eval( $("#text_jml").val() );
				txt_2 = eval( $("#stokbrg").val() );
				radio_op = $("input[name=rdo_urgen]:checked").val() ;
				
				if(txt_1 > txt_2 && radio_op=='1'){
					alert("Maaf, stok terbatas");
					$("#text_jml").val('')
				}
				
			}
		});
	}
});
</script>



<script src="../public/script/bootstrap.min.js"></script>










            
            
            
            
            
            
            
            
            
            
            
            
            
            
		</td>
	</tr>
</table>
</body>
</html>

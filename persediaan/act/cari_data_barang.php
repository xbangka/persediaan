<?php 
include('../config.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "../index.php";</script>';
	exit;
}


if(isset($_POST['aksi']) && $_POST['aksi'] == '2'){
	
	$brg = $_POST['brg'] ;
	
?>

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
    $sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE brg like '%" . $brg . "%' ORDER BY x ASC LIMIT 0,10");
	
	if( (strtoupper(substr($brg,0,3))=='ATK' || strtoupper(substr($brg,0,3))=='CTK' || strtoupper(substr($brg,0,3))=='PKR') && strlen($brg)==7 ){
		$sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE kodebrg = '" . $brg . "'");
	}elseif( strtoupper(substr($brg,0,3))=='ATK' || strtoupper(substr($brg,0,3))=='CTK' || strtoupper(substr($brg,0,3))=='PKR' ){
		$sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE kodebrg like '" . strtoupper($brg) . "%' LIMIT 0,10");
	}
	
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

<?php
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '1'){
	
	$brg = $_POST['brg'] ;
	
?>

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
	
    $sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE statusx = '1' AND brg like '%" . $brg . "%' ORDER BY brg ASC LIMIT 0,10");
	if( (strtoupper(substr($brg,0,3))=='ATK' || strtoupper(substr($brg,0,3))=='CTK' || strtoupper(substr($brg,0,3))=='PKR') && strlen($brg)==7 ){
		$sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE statusx = '1' AND kodebrg = '" . $brg . "'");
	}elseif( strtoupper(substr($brg,0,3))=='ATK' || strtoupper(substr($brg,0,3))=='CTK' || strtoupper(substr($brg,0,3))=='PKR' ){
		$sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE statusx = '1' AND kodebrg like '" . strtoupper($brg) . "%' LIMIT 0,10");
	}
	
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
                <?php echo $data2[2]  ;?>
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

<?php
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '3'){
	
	$kode = $_POST['kodebrg'] ;
	$sql2 = mysqli_query($jazz,"SELECT brg, satuan, sisa FROM barang WHERE statusx = '1' AND kodebrg = '$kode'");
	$ada  = mysqli_num_rows($sql2);
	if($ada>=1){
		$data2 = mysqli_fetch_array($sql2);
		echo $data2[0] . '|' . $data2[1] . '|' . $data2[2];
	}else{
		echo 'NONE';
	}
    
}

?>
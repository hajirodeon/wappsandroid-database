<?php
sleep(1);
error_reporting(0);



//folder webserverku
$sumberku = "http://127.0.0.1:8080";


//file ku
$filenya = "i_dataku.php";


//koneksi database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'adminadmin';
$koneksi = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $koneksi )
	{
  	die('Gagal Koneksi: ' . mysql_error());
	}

//sambungkan ke database...
mysql_select_db('test_db');






//ambil nilai
$aksi = $_REQUEST['aksi'];









//jika hapus 
if ($aksi == "hapus")
	{
	//ambil nilai
	$idku = $_REQUEST['idku'];

	//tampilkan keterangan
	echo "<h3>hapus : $idku</h3>";


	//hapus
	mysql_query("DELETE FROM karyawan WHERE id_karyawan = '$idku'");



	//reload
	?>
	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){

		
		//tutup form
		setTimeout('$("#ihasil").hide()',1000);

		$("#iaku").load("<?php echo $sumberku;?>/<?php echo $filenya;?>?aksi=daftar");

	
	});
	
	</script>

	<?php

	//selesai
	exit();
	}
	
	
	




//jika edit 
if ($aksi == "edit")
	{
	//ambil nilai
	$idku = $_REQUEST['idku'];
	
	
	//tampilkan data yang ada...
	$qku2 = mysql_query("SELECT * FROM karyawan ".
							"WHERE id_karyawan = '$idku'");
	$rku2 = mysql_fetch_assoc($qku2);
	$ku2_nama = $rku2['nama_karyawan'];
	$ku2_gaji = $rku2['gaji_karyawan'];
	?>
	
		
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
		$("#btnKRM").on('click', function(){
			$('#loading').show();
	
			$("#formx2").submit(function(){
	
				$.ajax({
					url: "<?php echo $sumberku;?>/<?php echo $filenya;?>?aksi=simpan2",
					type:"POST",
					data:$(this).serialize(),
					success:function(data){
						//munculkan keterangan...
						$("#ihasil").html(data);
						
						//tunjukkan progress... biar manis..
						setTimeout('$("#loading").hide()',1000);
						
						

						//re-direct
						window.location.href = "index.html"; 
						}
					});
				return false;
			});
		
		
		});	
	
	

	
	
	});
	
	</script>

	<?php
	echo '<h1>EDIT DATA</h1>
	
	<form role="form" id="formx2" name="formx2">
	<div class="input-group" align="center">
	<span class="input-group-btn">
		<input type="text" class="form-control" placeholder="Isikan Nama..." required value="'.$ku2_nama.'" name="namaku" id="namaku">
		<br>
		<input type="text" class="form-control" placeholder="Gaji..." required value="'.$ku2_gaji.'" name="gajiku" id="gajiku">
		<br>
		
		<input type="hidden" value="'.$idku.'" name="idku" id="idku">
		<button type="submit" class="btn btn-default" id="btnKRM" value="Submit" name="btnKRM">KIRIM >></button>
	</span> 
	</div>
	</form>
	<br>
	<br>
	<br>';
	
	
	
	//selesai
	exit();
	}











//jika simpan entri baru
if ($aksi == "simpan")
	{
	//ambil nilai
	$namaku = $_POST['namaku'];
	$gajiku = $_POST['gajiku'];	




	//simpan ke database..
	mysql_query("INSERT INTO karyawan(nama_karyawan, gaji_karyawan) VALUES ".
					"('$namaku', '$gajiku')");
	
	echo "DATA BARU BERHASIL DISIMPAN...";


	//selesai
	exit();
	}








//jika simpan edit
if ($aksi == "simpan2")
	{
	//ambil nilai
	$idku = $_POST['idku'];
	$namaku = $_POST['namaku'];
	$gajiku = $_POST['gajiku'];	




	//simpan ke database..
	mysql_query("UPDATE karyawan SET nama_karyawan = '$namaku', ".
					"gaji_karyawan = '$gajiku' ".
					"WHERE id_karyawan = '$idku'");
	
	echo "EDIT DATA BERHASIL DISIMPAN...";


	//selesai
	exit();
	}









//jika entri 
if ($aksi == "formku")
	{
	?>
	
		
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
		$("#btnKRM").on('click', function(){
			$('#loading').show();
	
			$("#formx2").submit(function(){
	
				$.ajax({
					url: "<?php echo $sumberku;?>/<?php echo $filenya;?>?aksi=simpan",
					type:"POST",
					data:$(this).serialize(),
					success:function(data){
						//munculkan keterangan...
						$("#ihasil").html(data);
						
						//tunjukkan progress... biar manis..
						setTimeout('$("#loading").hide()',1000);
						
						

						//re-direct
						window.location.href = "index.html"; 
						}
					});
				return false;
			});
		
		
		});	
	
	

	
	
	});
	
	</script>

	<?php
	echo '<h1>ENTRI DATA BARU</h1>
	
	<form role="form" id="formx2" name="formx2">
	<div class="input-group" align="center">
	<span class="input-group-btn">
		<input type="text" class="form-control" placeholder="Isikan Nama..." required value="" name="namaku" id="namaku">
		<br>
		<input type="text" class="form-control" placeholder="Gaji..." required value="" name="gajiku" id="gajiku">
		<br>
		<button type="submit" class="btn btn-default" id="btnKRM" value="Submit" name="btnKRM">KIRIM >></button>
	</span> 
	</div>
	</form>
	<br>
	<br>
	<br>';
	}








//jika ambil semua data.. 
if ($aksi == "daftar")
	{
	//link
	echo '[<a href="#" onclick="$(\'#iform\').load(\''.$sumberku.'/i_dataku.php?aksi=formku\');">ENTRI BARU</a>]';


	
	//daftar data...
	$qku = mysql_query("SELECT * FROM karyawan ".
							"ORDER BY nama_karyawan ASC");
	$rku = mysql_fetch_assoc($qku);
	$tku = mysql_num_rows($qku);
	
	
	//jika null data
	if (empty($tku))
		{
		echo "<h3>BELUM ADA DATA</h3>";
		}
	else
		{
		//tampilkan semua data
		do
			{
			$ku_id = $rku['id_karyawan'];
			$ku_nama = $rku['nama_karyawan'];
			$ku_gaji = $rku['gaji_karyawan'];
			
			
			echo "<p>
			$ku_nama 
			<br>
			[Gaji : $ku_gaji]
			<br>
			[<a href=\"#\" onclick=\"$('#iform').load('$sumberku/i_dataku.php?aksi=edit&idku=$ku_id');\">EDIT</a>]
			
			[<a href=\"#\" onclick=\"$('#ihasil').load('$sumberku/i_dataku.php?aksi=hapus&idku=$ku_id');\">HAPUS</a>]
			
			</p>
			<br>";	
			}
		while ($rku = mysql_fetch_assoc($qku));
		
		
		//selesai
		exit();
		}
		

	}





//selesai
exit();
?>
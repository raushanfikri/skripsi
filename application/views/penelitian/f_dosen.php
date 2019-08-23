
<?php

$fakultas_ = $this->db->get("fakultas");
$prodi_ = $this->db->get("jurusan");

$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {

	if($datpil->num_rows()>0){
		$act		= "act_edt";
		$nidn		= $datpil->row()->nidn;
		$nik		= $datpil->row()->nik;	
		$namadosen	= $datpil->row()->namadosen;	
		$level		= $datpil->row()->level;
		$password	= $datpil->row()->password;
		$kd_fak = $datpil->row()->kodefakultas;
		$kd_jur = $datpil->row()->kodejurusan;	
	}else{
		$act		= "act_edt";
		$nidn		= "";
		$nik		= "";
		$namadosen	= "";
		$jurusan	= "";
		$password 	= "";
		$kd_fak = "";
		$kd_jur = "";	
	}
		

} else {
	$act		= "act_add";
	$nidn		= "";
	$nik		= "";
	$namadosen	= "";
	$password 	= "";
	$kd_fak = "";
	$kd_jur = "";	
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Dosen</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Ubah Data Dosen</h3></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/penelitian/dosen/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px" class="form-control" autofocus maxlength="10" onkeypress="return wajibAngka(event)"></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px" class="form-control" ></b></td></tr>
	<?php
		} 
	?>
	<tr><td width="20%">NIK</td><td><b><input type="text" name="nik" required value="<?php echo $nik; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>		
	<tr><td width="20%">Nama Dosen</td><td><b><input type="text" name="namadosen" required value="<?php echo $namadosen; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Fakultas</td><td><b>
	<select id="fakultas" name="kodefakultas" class="form-control" >
		<option value="" selected>--Pilih Fakultas--</option>
		<?php foreach($fakultas_->result() as $f){ ?>
		<option value="<?=$f->kodefakultas?>" <?php if($f->kodefakultas==$kd_fak){ echo "selected"; } ?> ><?=$f->namafakultas?></option>
		<?php } ?>
	</select>

	<tr><td width="20%">Program Studi</td><td><b>
	<select id="jurusan" name="kodejurusan" class="form-control" >
		<option value="" selected>--Pilih Jurusan--</option>
		<?php foreach($prodi_->result() as $r){ ?>
		<option value="<?=$r->kodejurusan?>"  <?php if($r->kodejurusan==$kd_jur){ echo "selected"; } ?>  class="<?=$r->kodefakultas?>"><?=$r->namajurusan?></option>
		<?php } ?>
	</select>

	</b></td></tr>		
	
	<tr><td width="20%">Level</td><td><b>
			<select name="level" class="form-control" style="width: 200px" required tabindex="6" ><option value=""> - Level - </option>
			<?php
				$l_sifat	= array('admin','dosen');
				
				for ($i = 0; $i < sizeof($l_sifat); $i++) {
					if ($l_sifat[$i] == $level) {
						echo "<option selected value='".$l_sifat[$i]."'>".$l_sifat[$i]."</option>";
					} else { 
						echo "<option value='".$l_sifat[$i]."'>".$l_sifat[$i]."</option>";
					}				
				}			
			?>			
			</select>
	</b></td></tr>

	

	<tr><td width="20%">Password</td><td><b><input type="text" name="password" value="<?php echo $password; ?>" id="password" style="width: 300px" class="form-control" tabindex="2" ></b></td></tr>		
	<tr><td width="20%">Ulangi Password</td><td><b><input type="text" name="password2" value="<?php echo $password; ?>" id="confirm_password" style="width: 300px" class="form-control" tabindex="3	" ></b></td></tr>
	<tr><td><span id='message'></span></td></tr>		


	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/penelitian/dosen" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>

	</table>
</form>
</div>
<script src="<?=base_url()?>aset/jquery.chained.min.js"></script>
<script type="text/javascript">

	/*$(document).ready(function () {
    $("#fakultas").change(function () {
        var val = $(this).val();
        if (val == "FTIK") {
            $("#prodi").html("<option value='INFORMATIKA'>INFORMATIKA</option><option value='SISTEM INFORMASI'>SISTEM INFORMASI</option><option value='SISTEM INFORMASI AKUNTANSI'>SISTEM INFORMASI AKUNTANSI</option><option value='TEKNOLOGI INFORMASI'>TEKNOLOGI INFORMASI</option><option value='TEKNIK KOMPUTER'>TEKNIK KOMPUTER</option><option value='TEKNIK SIPIL'>TEKNIK SIPIL</option> <option value='TEKNIK ELEKTRO'>TEKNIK ELEKTRO</option>");
        } else if (val == "FSIP") {
            $("#prodi").html("<option value='SASTRA INGGRIS'>SASTRA INGGRIS</option><option value='PENDIDIKAN MATEMATIKA'>PENDIDIKAN MATEMATIKA</option><option value='PENDIDIKAN BAHASA INGGRIS'>PENDIDIKAN BAHASA INGGRIS</option><option value='PENDIDIKAN OLAHRAGA'>PENDIDIKAN OLAHRAGA</option>");
        } else if (val == "FEB") {
            $("#prodi").html("<option value='AKUNTANSI'>AKUNTANSI</option><option value='MANAJEMEN'>MANAJEMEN</option>");
        }
    });
});*/

$('#jurusan').chained('#fakultas');

$('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else 
    $('#message').html('Not Matching').css('color', 'red');
});


 function wajibAngka(evt) {
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
 return false;
 }

</script>



<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$nidn		= $datpil->nidn;
	$nik		= $datpil->nik;	
	$namadosen	= $datpil->namadosen;	
	$jurusan	= $datpil->jurusan;	
} else {
	$act		= "act_add";
	$nidn		= "";
	$nik		= "";
	$namadosen	= "";
	$jurusan	= "";
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

<form action="<?php echo base_URL(); ?>index.php/admin/dosen/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px" class="form-control" autofocus maxlength="10"></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px" class="form-control" readonly></b></td></tr>
	<?php
		}
	?>
	<tr><td width="20%">NIK</td><td><b><input type="text" name="nik" required value="<?php echo $nik; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>		
	<tr><td width="20%">Nama Dosen</td><td><b><input type="text" name="namadosen" required value="<?php echo $namadosen; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Fakultas</td><td><b>
	<select id="fakultas" name="Fakultas" class="form-control" >
		<option value="FTIK" selected>FTIK</option>
		<option value="FSIP">FSIP</option>
		<option value="FEB">FEB</option>
	</select>

	<tr><td width="20%">Program Studi</td><td><b>
	<select id="prodi" name="jurusan" class="form-control" required>
	</select>

	</b></td></tr>		
		
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/admin/dosen" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>

<script type="text/javascript">
	$(document).ready(function () {
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
});
</script>
<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_user');	
	$nidn		= $datpil[0]->nidn;
	$judul		= $datpil[0]->judul;	
	$institusi	= $datpil[0]->institusi;	
	$tempat		= $datpil[0]->tempat;	
	$tanggal	= $datpil[0]->tanggal;	
} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_user');
	$nidn		= "";
	$judul		= "";
	$institusi	= "";
	$tempat		= "";
	$tanggal	= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Pemakalah Forum Ilmiah PKM</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h4 style="margin-top: 5px"> Ubah Data Publikasi Forum Ilmiah PKM</h34></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/pkm/publikasipkm/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px" class="form-control" readonly></b></td></tr>
	
	<input type="hidden" name="id" value="<?php echo $datpil[0]->id; ?>">

	<?php
		}
	?>
	<tr><td width="20%">Judul</td><td><b><input type="text" name="judul" required value="<?php echo $judul; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>		
	<tr><td width="20%">Institusi</td><td><b><input type="text" name="institusi" required value="<?php echo $institusi; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">Tanggal</td><td><b><input type="text" name="tanggal" tabindex="7" required value="<?php echo $tanggal; ?>" id="tgl_surat" style="width: 300px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Tempat</td><td><b><input type="text" name="tempat" required value="<?php echo $tempat; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">File</td><td><b><input type="file" name="file_surat" tabindex="8" class="form-control" style="width: 400px"></b></td></tr>


	<?php if ($act == 'edt' || $act == 'act_edt') : ?>
		<tr><td></td><td><small><?= $datpil[0]->file ?></small></td></tr>
		<tr><td width="20%">Status</td><td><b>
			<select name="status" class="form-control" style="width: 200px" required tabindex="6" ><option value=""> - Status - </option>
			<option value="Disetujui">Disetujui</option>
			<option value="Belum Disetujui">Belum Disetujui</option>
			</select>
			</b></td></tr>
	<?php endif; ?>

	
	
		
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/pkm/publikasipkm" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>

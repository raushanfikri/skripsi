<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_nidn');	
	$judul					= $datpil[0]->judul;	
	$jenis					= $datpil[0]->jenis;	
	$nomorpendaftaran		= $datpil[0]->nomorpendaftaran;	
	$status					= $datpil[0]->status;	
	$nohki					= $datpil[0]->nohki;	
} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_nidn');
	$judul		= "";
	$jenis	= "";
	$nomorpendaftaran	= "";
	$status	= "";
	$nohki	= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Hak Kekayaan Intelektual (HKI) PKM</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h4 style="margin-top: 5px"> Ubah Data Publikasi Forum Ilmiah PKM</h4></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/dosen/dosenhki_pkm/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $admin_user; ?>" style="width: 700px" class="form-control"readonly autofocus></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $admin_user; ?>" style="width: 700px" class="form-control" readonly></b></td></tr>
	
	<input type="hidden" name="id" value="<?php echo $datpil[0]->id; ?>">


	<?php
		}
	?>
	<tr><td width="20%">Judul</td><td><b><input type="text" name="judul" required value="<?php echo $judul; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>		
	<tr><td width="20%">Jenis</td><td><b><input type="text" name="jenis" required value="<?php echo $jenis; ?>" style="width: 700px" class="form-control"></b></td></tr>			
	<tr><td width="20%">Nomor Pendaftaran</td><td><b><input type="text" name="nomorpendaftaran" required value="<?php echo $nomorpendaftaran; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Status</td><td><b><input type="text" name="status" required value="<?php echo $status; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Nomor HKI</td><td><b><input type="text" name="nohki" required value="<?php echo $nohki; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">File</td><td><b><input type="file" name="file_surat" tabindex="8" class="form-control" style="width: 400px"></b></td></tr>


	<?php if ($act == 'edt' || $act == 'act_edt') : ?>
		<tr><td></td><td><small><?= $datpil[0]->file ?></small></td></tr>
	<?php endif; ?>
		
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/dosen/dosenhki" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>

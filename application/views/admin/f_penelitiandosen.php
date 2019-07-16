<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_user');	
	$judul		= $datpil->judul;	
	$jenis	= $datpil->jenis;	
	$anggota_1		= $datpil->anggota_1;	
	$anggota_2		= $datpil->anggota_2;	
	$bidang		= $datpil->bidang;	
	$tm		= $datpil->tm;	
	$sumber		= $datpil->sumber;	
	$institusi		= $datpil->institusi;	
	$jumlah		= $datpil->jumlah;	
} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_user');
	$judul		= "";
	$jenis	= "";
	$anggota_1	= "";
	$anggota_2	= "";
	$bidang	= "";
	$tm	= "";
	$sumber	= "";
	$institusi	= "";
	$jumlah	= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Publikasi</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Jurnal</h3></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/admin/dosenpenelitian/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
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
	<?php
		}
	?>
	<tr><td width="20%">Judul</td><td><b><input type="text" name="judul" required value="<?php echo $judul; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>		
	<tr><td width="20%">Jenis</td><td><b><input type="text" name="jenis" required value="<?php echo $jenis; ?>" style="width: 700px" class="form-control"></b></td></tr>				
	<tr><td width="20%">Anggota 1</td><td><b><input type="text" name="anggota_1" required value="<?php echo $anggota_1; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Anggota 2</td><td><b><input type="text" name="anggota_2" required value="<?php echo $anggota_2; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Bidang</td><td><b><input type="text" name="bidang" required value="<?php echo $bidang; ?>" style="width: 700px" class="form-control"></b></td></tr>			
	<tr><td width="20%">TM</td><td><b><input type="text" name="tm" required value="<?php echo $tm; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Sumber</td><td><b><input type="text" name="sumber" required value="<?php echo $sumber; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">Institusi</td><td><b><input type="text" name="institusi" required value="<?php echo $institusi; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">Jumlah</td><td><b><input type="text" name="jumlah" required value="<?php echo $jumlah; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">File</td><td><b><input type="file" name="file_surat" tabindex="8" class="form-control" style="width: 400px"></b></td></tr>
		
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/admin/dosenpenelitian" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>

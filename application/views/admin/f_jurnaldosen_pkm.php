<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_user');	
	$judul		= $datpil->judul;	
	$jenis	= $datpil->jenis;	
	$penulis_2		= $datpil->penulis_2;	
	$penulis_3		= $datpil->penulis_3;	
	$jurnal		= $datpil->jurnal;	
	$issn		= $datpil->issn;	
	$volume		= $datpil->volume;	
	$nomor		= $datpil->nomor;	
	$halaman		= $datpil->halaman;	
	$url		= $datpil->url;	
} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_user');
	$judul		= "";
	$jenis	= "";
	$penulis_2	= "";
	$penulis_3	= "";
	$jurnal	= "";
	$issn	= "";
	$volume	= "";
	$nomor	= "";
	$halaman	= "";
	$url	= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Jurnal</h3></div>
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

<form action="<?php echo base_URL(); ?>index.php/admin/dosenjurnal_pkm/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
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
	<tr><td width="20%">Penulis 2</td><td><b><input type="text" name="penulis_2" required value="<?php echo $penulis_2; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Penulis 3</td><td><b><input type="text" name="penulis_3" required value="<?php echo $penulis_3; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Jurnal</td><td><b><input type="text" name="jurnal" required value="<?php echo $jurnal; ?>" style="width: 700px" class="form-control"></b></td></tr>			
	<tr><td width="20%">ISSN</td><td><b><input type="text" name="issn" required value="<?php echo $issn; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Volume</td><td><b><input type="text" name="volume" required value="<?php echo $volume; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">Nomor</td><td><b><input type="text" name="nomor" required value="<?php echo $nomor; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">Halaman</td><td><b><input type="text" name="halaman" required value="<?php echo $halaman; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">URL</td><td><b><input type="text" name="url" required value="<?php echo $url; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">File</td><td><b><input type="file" name="file_surat" tabindex="8" class="form-control" style="width: 400px"></b></td></tr>
		
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/admin/dosenjurnal_pkm" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>

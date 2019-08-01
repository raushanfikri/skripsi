<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_user');
	$nidn		= $datpil[0]->nidn;	
	$judul		= $datpil[0]->judul;	
	$jenis		= $datpil[0]->jenis;	
	$penulis_2	= $datpil[0]->penulis_2;	
	$penulis_3	= $datpil[0]->penulis_3;	
	$jurnal		= $datpil[0]->jurnal;	
	$issn		= $datpil[0]->issn;	
	$volume		= $datpil[0]->volume;	
	$nomor		= $datpil[0]->no;	
	$halaman	= $datpil[0]->halaman;	
	$url		= $datpil[0]->url;	
} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_user');
	$nidn		= "";
	$judul		= "";
	$jenis		= "";
	$penulis_2	= "";
	$penulis_3	= "";
	$jurnal		= "";
	$issn		= "";
	$volume		= "";
	$nomor		= "";
	$halaman	= "";
	$url		= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Seminar PKM</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Ubah Data Seminar PKM</h3></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/pkm/seminar_pkm/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn?>" style="width: 700px" class="form-control" autofocus onkeypress="return wajibAngka(event)"></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn?>" style="width: 700px"
	 class="form-control" readonly></b></td></tr>
	
	 <input type="hidden" name="id" value="<?php echo $datpil[0]->id; ?>">

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

	<?php if ($act == 'edt' || $act == 'act_edt') : ?>
		<tr><td></td><td><small><?= $datpil[0]->file ?></small></td></tr>
		<tr><td width="20%">Status</td><td><b>
			<select name="keterangan" class="form-control" style="width: 200px" required tabindex="6" ><option value=""> - Status - </option>
			<option value="Disetujui">Disetujui</option>
			<option value="Belum Disetujui">Belum Disetujui</option>
			</select>
			</b></td></tr>
	<?php endif; ?>

	
	
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/pkm/seminar_pkm" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>


<script type="text/javascript">
 function wajibAngka(evt) {
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
 return false;
 }
</script>

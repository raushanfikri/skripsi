
<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act				= "act_edt";
	$kodefakultas		= $datpil->kodefakultas;
	$namafakultas		= $datpil->namafakultas;	
	
		

} else {
	$act				= "act_add";
	$kodefakultas		= "";
	$namafakultas		= "";
	
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Fakultas</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Ubah Data Fakultas</h3></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/penelitian/fakultas/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
	<tr><td width="20%">Kode Fakultas</td><td><b><input type="text" name="kodefakultas" required value="<?php echo $kodefakultas; ?>" style="width: 700px" class="form-control" autofocus maxlength="5" ></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
	<tr><td width="20%">Kode Fakultas</td><td><b><input type="text" name="kodefakultas" required value="<?php echo $kodefakultas; ?>" style="width: 700px" class="form-control" ></b></td></tr>
	<?php
		}
	?>
	<tr><td width="20%">Nama Fakultas</td><td><b><input type="text" name="namafakultas" required value="<?php echo $namafakultas; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>		
	
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/penelitian/fakultas" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>


	</table>
</form>
</div>





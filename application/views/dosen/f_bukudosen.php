<?php
$mode		= $this->uri->segment(3);
// print_r($this->session->userdata('admin_nidn'));
if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_nidn');
	
	$judul		= $datpil[0]->judul;
	$idpenelitian		= $datpil[0]->idpenelitian;	
	$penerbit	= $datpil[0]->penerbit;	
	$isbn		= $datpil[0]->isbn;	
	$halaman		= $datpil[0]->halaman;	
} else { 
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_nidn');
	$judul		= "";
	$idpenelitian="";
	$penerbit	= "";
	$isbn	= "";
	$halaman	= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Tambah Data Buku Ajar / Teks</h3>
	</div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Tambah Data Buku Ajar / Teks</h3>
	</div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

	<form action="<?php echo base_URL(); ?>index.php/dosen/dosenbuku/<?php echo $act; ?>" method="post"
		accept-charset="utf-8" enctype="multipart/form-data">
		<table width="100%" class="table-form">
			<?php
		if ($act=="act_add")
		{
	?>
			<tr>
				<td width="20%">NIDN</td>
				<td><b><input type="text" name="nidn" required value="<?php echo $admin_user; ?>" style="width: 700px"
							class="form-control" readonly autofocus></b></td>
			</tr>
			<?php
	} 
	else
	{
	?>
			<tr>
				<td width="20%">NIDN</td>
				<td><b><input type="text" name="nidn" required value="<?php echo $admin_user; ?>" style="width: 700px"
							class="form-control" readonly></b></td>
			</tr>

			<input type="hidden" name="id" value="<?php echo $datpil[0]->id; ?>">

			<?php
		}
	?>
			<tr>
				<td width="20%">Judul Penelitian</td>
				<td><b><input type="text" name="judul" required
							value="<?php if($data->num_rows()>0){ echo $data->row()->judulpenelitian; } ?>"
							style="width: 700px" class="form-control" autofocus></b>
					<input type="hidden" name="idp"
						value="<?php if($data->num_rows()>0){ echo $data->row()->idpenelitian; } ?> ">
				</td>
			</tr>
			<tr>
				<td width="20%">Judul</td>
				<td><b><input type="text" name="judul" required value="<?php echo $judul; ?>" style="width: 700px"
							class="form-control" autofocus></b></td>
			</tr>
			<tr>
				<td width="20%">Penerbit</td>
				<td><b><input type="text" name="penerbit" required value="<?php echo $penerbit; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">No ISBN</td>
				<td><b><input type="text" name="isbn" required value="<?php echo $isbn; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">Halaman</td>
				<td><b><input type="text" name="halaman" required value="<?php echo $halaman; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">File</td>
				<td><b><input type="file" name="file_surat" tabindex="8" class="form-control" style="width: 400px"></b>
				</td>
			</tr>

			<?php if ($act == 'edt' || $act == 'act_edt') : ?>
			<tr>
				<td></td>
				<td><small><?= $datpil[0]->file ?></small></td>
			</tr>
			<?php endif; ?>

			<tr>
				<td width="20%">
					<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i>
						Simpan</button>
					<a href="<?php echo base_URL(); ?>index.php/dosen/detail_buku/<?php echo $this->session->userdata('idpenelitian'); ?>"
						class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act					= "act_edt";
	$admin_user				=$this->session->userdata('admin_nidn');	
	$judulpenelitian		= $datpil[0]->judulpenelitian;	
	$mitra					= $datpil[0]->mitra;
	$alamatmitra				= $datpil[0]->alamatmitra;	
	$kelompokmitra			= $datpil[0]->kelompokmitra;		
	$jenis					= $datpil[0]->jenis;	
	// $anggota_1	= $datpil[0]->anggota_1;	
	// $anggota_2	= $datpil[0]->anggota_2;	
	$bidang					= $datpil[0]->bidang;	
	$tse					= $datpil[0]->tse;	
	$sumber					= $datpil[0]->sumber;	
	$institusi				= $datpil[0]->institusi;	
	$jumlah					= $datpil[0]->jumlah;	
} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_nidn');
	$judulpenelitian		= "";
	$jenis	= "";
	$mitra					= "";
	$alamatmitra				= "";	
	$kelompokmitra			= "";
	//$anggota_1	= "";
	//$anggota_2	= "";
	$bidang	= "";
	$tse	= "";
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
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Tambah Data Pengabdian</h3>
	</div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Ubah Data Pengabdian</h3>
	</div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

	<form action="<?php echo base_URL(); ?>index.php/dosen/dosenpengabdian/<?php echo $act; ?>" method="post"
		accept-charset="utf-8" enctype="multipart/form-data">
		<table width="100%" class="table-form">
			<?php
		if ($act=="act_add")
		{
	?>
			<tr>
				<td width="20%">NIDN</td>
				<td><b><input type="text" name="nidn" required value="<?php echo $admin_user; ?>" style="width: 150px"
							class="form-control" readonly autofocus></b></td>
			</tr>
			<?php
	} 
	else
	{
	?>
			<tr>
				<td width="20%">NIDN</td>
				<td><b><input type="text" name="nidn" required value="<?php echo $admin_user; ?>" style="width: 150px"
							class="form-control" readonly></b></td>
			</tr>

			<input type="hidden" name="idpengabdian" value="<?php echo $datpil[0]->idpengabdian; ?>">


			<?php
		}
	?>
			<tr>
				<td width="20%">Judul Pengabdian</td>
				<td><b><input type="text" name="judulpenelitian" required value="<?php echo $judulpenelitian; ?>"
							style="width: 700px" class="form-control" autofocus></b></td>
			</tr>

			<tr>
				<td width="20%">Mitra</td>
				<td><b><input type="text" name="mitra" required value="<?php echo $mitra; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>

			<tr>
				<td width="20%">Alamat Mitra</td>
				<td><b><input type="text" name="alamatmitra" required value="<?php echo $alamatmitra; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>

			<tr>
				<td width="20%">Kelompok Mitra</td>
				<td><b><input type="text" name="kelompokmitra" required value="<?php echo $kelompokmitra; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			
			<tr>
				<td width="20%">Jenis</td>
				<td><b><input type="text" name="jenis" required value="<?php echo $jenis; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>

			<!-- <tr><td width="20%">Anggota 1</td><td><b><input type="text" name="anggota_1"  value="<?php echo $anggota_1; ?>" style="width: 700px" class="form-control"></b></td></tr>		
	<tr><td width="20%">Anggota 2</td><td><b><input type="text" name="anggota_2"  value="<?php echo $anggota_2; ?>" style="width: 700px" class="form-control"></b></td></tr>		 -->

			<tr>
				<td width="20%">Bidang Pengabdian</td>
				<td><b><input type="text" name="bidang" required value="<?php echo $bidang; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">Tujuan Sosial Ekonomi</td>
				<td><b><input type="text" name="tse" required value="<?php echo $tse; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">Sumber</td>
				<td><b><input type="text" name="sumber" required value="<?php echo $sumber; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">Institusi Sumber Dana</td>
				<td><b><input type="text" name="institusi" required value="<?php echo $institusi; ?>"
							style="width: 700px" class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">Jumlah</td>
				<td><b><input type="text" name="jumlah" required value="<?php echo $jumlah; ?>" style="width: 700px"
							onkeypress="return wajibAngka(event)" class="form-control"></b></td>
			</tr>
			<!-- 	<tr><td width="20%">File</td><td><b><input type="file" name="file_surat" tabindex="8" class="form-control" style="width: 400px"></b></td></tr> -->
			<tr>
				<td width="20%">File</td>
				<td><b>
						<input type="file" name="file_surat" tabindex="8">
						<p class="help-block">Max 2MB</p>
					</b></td>
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
					<a href="<?php echo base_URL(); ?>index.php/dosen/dosenpengabdian" class="btn btn-success"><i
							class="icon icon-arrow-left icon-white"></i> Kembali</a>
				</td>
			</tr>
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
<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_user');
	$nidn		= $datpil[0]->nidn;	
	$judul		= $datpil[0]->judul;	
	$jenis	= $datpil[0]->jenis;	
	$nomorpendaftaran		= $datpil[0]->nomorpendaftaran;	
	$status		= $datpil[0]->status;	
	$nohki		= $datpil[0]->nohki;	
} else {
	$act		= "act_add";
	$nidn = "";
	$admin_user	=$this->session->userdata('admin_user');
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
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Tambah Data Hak Kekayaan Intelektual (HKI)</h3>
	</div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Ubah Data Publikasi Forum Ilmiah</h3>
	</div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

	<form action="<?php echo base_URL(); ?>index.php/pkm/hki_pkm/<?php echo $act; ?>" method="post"
		accept-charset="utf-8" enctype="multipart/form-data">
		<table width="100%" class="table-form">
			<?php
		if ($act=="act_add")
		{
	?>
			<tr>
				<td width="20%">NIDN</td>
				<td><b><input type="text" id="nidn" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px"
							class="form-control" readonly></b></td>
			</tr>
			<tr>
				<td width="20%">Nama</td>
				<td><b><input id="namadosen" type="text" name="namadosen" required value="<?php echo $judul; ?>"
							style="width: 700px" class="form-control" autofocus></b></td>
			</tr>
			<?php
	} 
	else
	{
	?>
			<tr>
				<td width="20%">NIDN</td>
				<td><b><input type="text" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px"
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
						value="<?php if($data->num_rows()>0){ echo $data->row()->idpengabdian; } ?> ">
				</td>
			</tr>
			<tr>
				<td width="20%">Judul</td>
				<td><b><input type="text" name="judul" required value="<?php echo $judul; ?>" style="width: 700px"
							class="form-control" autofocus></b></td>
			</tr>
 
			<tr>
				<td width="20%">Jenis HKI</td>
				<td><b><select type="text" name="jenis" required value="<?php echo $jenis; ?>" style="width: 700px"
							class="form-control">
							<option value="" selected>-- Pilih --</option>
							<option value="Paten" <?php if($jenis=='Paten'){ echo "selected"; } ?> >Paten</option>
							<option value="Paten Sederhana" <?php if($jenis=='Paten Sederhana'){ echo "selected"; } ?>>Paten Sederhana</option>
							<option value="Hak Cipta" <?php if($jenis=='Hak Cipta'){ echo "selected"; } ?> >Hak Cipta</option>
							<option value="Merk Dagang"<?php if($jenis=='Merk Dagang'){ echo "selected"; } ?>  >Merk Dagang</option>
							<option value="Rahasia Dagang" <?php if($jenis=='Rahasia Dagang'){ echo "selected"; } ?>>Rahasia Dagang</option>
							<option value="Desain Produksi Industri" <?php if($jenis=='Desain Produksi Industri'){ echo "selected"; } ?>>Desain Produksi Industri</option>
							<option value="Indikasi Geografis" <?php if($jenis=='Indikasi Geografis'){ echo "selected"; } ?>>Indikasi Geografis</option>
							<option value="Perlindungan Varietas Tanaman" <?php if($jenis=='Perlindungan Varietas Tanaman'){ echo "selected"; } ?>>Perlindungan Varietas Tanaman</option>
							<option value="Perlindungan Topografi Sirkuit Terpadu" <?php if($jenis=='Perlindungan Topografi Sirkuit Terpadu'){ echo "selected"; } ?>>Perlindungan Topografi Sirkuit
								Terpadu</option>

						</select></b></td>
			</tr>
			<tr>
				<td width="20%">Nomor Pendaftaran</td>
				<td><b><input type="text" name="nomorpendaftaran" required value="<?php echo $nomorpendaftaran; ?>"
							style="width: 700px" class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">Status</td>
				<td><b><input type="text" name="status" required value="<?php echo $status; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			<tr>
				<td width="20%">Nomor HKI</td>
				<td><b><input type="text" name="nohki" required value="<?php echo $nohki; ?>" style="width: 700px"
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
			<tr>
				<td width="20%">Status</td>
				<td><b>
						<select name=" keterangan" class="form-control" style="width: 200px" required tabindex="6">
							<option value=""> - Status - </option>
							<option value="Disetujui">Disetujui</option>
							<option value="Belum Disetujui">Belum Disetujui</option>
						</select>
					</b></td>
			</tr>
			<?php endif; ?>



			<tr>
				<td width="20%">
					<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i>
						Simpan</button>
					<a href="<?php echo base_URL(); ?>index.php/pkm/detail_hkipkm/<?php echo $this->session->userdata('idpengabdian'); ?>"
							class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
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


 $(document).ready(function () {
  $(function () {
    $("#namadosen").autocomplete({    //id kode sebagai key autocomplete yang akan dibawa ke source url
        minLength:1,
        delay:0,
        source:'<?php echo site_url('index.php/pkm/get_datadosen'); ?>',   //nama source kita ambil langsung memangil fungsi get_allkota
        select:function(event, ui){
            $('#namadosen').val(ui.item.value);
            $('#nidn').val(ui.item.id);
        }
    });
  });
});
</script>

<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_user');	
	$nidn		= $datpil[0]->nidn;
	$idpengabdian		= $datpil[0]->idpengabdian;	
	$judul				= $datpil[0]->judul;	
	$namajurnal			= $datpil[0]->namajurnal;
	$jenis				= $datpil[0]->jenis;	
	$peranpenulis		= $datpil[0]->peranpenulis;	
	$tahun				= $datpil[0]->tahun;	
	$volume				= $datpil[0]->volume;	
	$nomor				= $datpil[0]->no;	 
	$url				= $datpil[0]->url;
	$issn				= $datpil[0]->issn;	
} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_user');
	$nidn		= "";
	$idpengabdian		= "";	
	$judul				= "";	
	$namajurnal			= "";
	$jenis				= "";	
	$peranpenulis		= "";	
	$tahun				= "";	
	$volume				= "";	
	$nomor				= "";	 
	$url				= "";
	$issn				= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Tambah Data Jurnal</h3>
	</div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 style="margin-top: 5px"> Ubah Data Jurnal</h3>
	</div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/pkm/jurnal_pkm/<?php echo $act; ?>" method="post"
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
						value="<?php if($data->num_rows()>0){ echo $data->row()->idpengabdian; } ?> ">
				</td>
			</tr>

			<tr>
				<td width="20%">Nama Jurnal</td>
				<td><b><input type="text" name="namajurnal" required value="<?php echo $judul; ?>" style="width: 700px"
							class="form-control" autofocus></b></td>
			</tr> 

			<tr>
				<td width="20%">Judul</td>
				<td><b><input type="text" name="judul" required value="<?php echo $judul; ?>" style="width: 700px"
							class="form-control" autofocus></b></td>
			</tr>
		
			<tr>
				<td width="20%">Jenis Publikasi</td>
				<td><b><input type="text" name="jenis" required value="<?php echo $volume; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>

			<tr>
				<td width="20%">Peran Penulis</td>
				<td><b><input type="text" name="peranpenulis" required value="<?php echo $volume; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>

			<tr>
				<td width="20%">Tahun Publikasi</td>
				<td><b><input type="text" name="tahun" required value="<?php echo $volume; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>

			<tr>
				<td width="20%">Volume</td>
				<td><b><input type="text" name="volume" required value="<?php echo $volume; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
			
			<tr>
				<td width="20%">Nomor</td>
				<td><b><input type="text" name="no" required value="<?php echo $nomor; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>
		
			<tr>
				<td width="20%">URL</td>
				<td><b><input type="text" name="url" required value="<?php echo $url; ?>" style="width: 700px"
							class="form-control"></b></td>
			</tr>

			<tr>
				<td width="20%">ISSN</td>
				<td><b><input type="text" name="issn" required value="<?php echo $issn; ?>" style="width: 700px"
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
						<select name="status" class="form-control" style="width: 200px" required tabindex="6">
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
					<a href="<?php echo base_URL(); ?>index.php/pkm/detail_jurnalpkm/<?php echo $this->session->userdata('idpengabdian'); ?>"
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
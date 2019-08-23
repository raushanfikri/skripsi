<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act		= "act_edt";
	$admin_user	=$this->session->userdata('admin_user');	
	$nidn		= $datpil[0]->nidn;
	$judul				= $datpil[0]->namaprosiding;	
	$tahunprosiding		= $datpil[0]->tahunprosiding;
	$peranpenulis		= $datpil[0]->peranpenulis;		
	$volume				= $datpil[0]->volume;	
	$nomor				= $datpil[0]->no;	
	$isbn				= $datpil[0]->isbn;	
	$url				= $datpil[0]->url;
	$jenisprosiding		= $datpil[0]->jenisprosiding;

} else {
	$act		= "act_add";
	
	$admin_user	=$this->session->userdata('admin_user');
	$nidn		= "";
	$idpenelitian	= "";
	$judul			= "";
	$tahunprosiding	= "";
	$peranpenulis	= "";
	$volume			= "";
	$nomor			= "";
	$isbn			= "";
	$url			= "";
	$jenisprosiding	= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Seminar</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Ubah Data Seminar</h3></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/penelitian/seminar/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
			<tr>
				<td width="20%">Judul Penelitian</td>
				<td>
					<select class="form-control select2" name="idpenelitian">
						<?php foreach ($data as $val) { ?>
						<option value="<?php echo $val->idpenelitian; ?>"><?php echo $val->judulpenelitian; ?></option>
						<?php } ?>
						?>
					</select>
				</td>
			</tr>
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
			<tr>
				<td width="20%">Judul Penelitian</td>
				<td>
					<select class="form-control select2" name="idpenelitian">
						<?php foreach ($data as $val) { ?>
						<option value="<?php echo $val->idpenelitian; ?>"><?php echo $val->judulpenelitian; ?></option>
						<?php } ?>
						?>
					</select>
				</td>
			</tr>
	<tr><td width="20%">NIDN</td><td><b><input type="text" name="nidn" required value="<?php echo $nidn ?>" style="width: 700px" class="form-control" readonly></b></td></tr>
	
	<input type="hidden" name="id" value="<?php echo $datpil[0]->id; ?>">

	<?php
		}
	?>
	<tr><td width="20%">Nama Prosiding</td><td><b><input type="text" name="namaprosiding" required value="<?php echo $judul; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>		
	<tr><td width="20%">Tahun Prosiding</td><td><b><input type="text" name="tahunprosiding" required value="<?php echo $tahunprosiding; ?>" style="width: 700px" class="form-control"></b></td></tr>				
	<tr><td width="20%">Peran Penulis</td><td><b><select type="text" name="peranpenulis" required value="<?php echo $peranpenulis; ?>" style="width: 700px" class="form-control">
		<option value="" selected>-- Pilih --</option>
		<option value="First Author" >First Author</option>
		<option value="CO Author" >CO Author</option>
		<option value="Corresponding Author" >Corresponding Author</option>

	</select></b></td></tr>			


	<tr><td width="20%">Volume</td><td><b><input type="text" name="volume" required value="<?php echo $volume; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">Nomor</td><td><b><input type="text" name="no" required value="<?php echo $nomor; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">ISBN/ISSN</td><td><b><input type="text" name="isbn" required value="<?php echo $isbn; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">URL</td><td><b><input type="text" name="url" required value="<?php echo $url; ?>" style="width: 700px" class="form-control"></b></td></tr>	
	<tr><td width="20%">Jenis Prosiding</td><td><b><select type="text" name="jenisprosiding" required value="<?php echo $jenisprosiding; ?>" style="width: 700px" class="form-control">
		<option value="" selected>-- Pilih --</option>
		<option value="Tidak Diketahui" >Tidak Diketahui</option>
		<option value="Terindeks" >Terindeks</option>
		<option value="Tidak Terindeks" >Tidak Terindeks</option>

	</select></b></td></tr>		
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
	<a href="<?php echo base_URL(); ?>index.php/penelitian/detail_seminar/<?php echo $this->session->userdata('idpenelitian'); ?>"
							class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>
	</table>
</form>
</div>

<script type="text/javascript">
$(document).ready(function () {
  $(function () {
    $("#namadosen").autocomplete({    //id kode sebagai key autocomplete yang akan dibawa ke source url
        minLength:1,
        delay:0,
        source:'<?php echo site_url('index.php/penelitian/get_datadosen'); ?>',   //nama source kita ambil langsung memangil fungsi get_allkota
        select:function(event, ui){
            $('#namadosen').val(ui.item.value);
            $('#nidn').val(ui.item.id);
        }
    });
	$('.select2').select2({
				width: "100%",
				allowClear: true,
				placeholder: "Filter"
			});
  });
});

</script>

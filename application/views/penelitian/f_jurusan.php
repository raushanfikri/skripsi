
<?php
$mode		= $this->uri->segment(3);

if ($mode == "edt" || $mode == "act_edt") {
	$act				= "act_edt";
	$kodejurusan		= $datpil->kodejurusan;
	$namajurusan		= $datpil->namajurusan;	
	$kodefakultas		= $datpil->kodefakultas;
	
	
		

} else {
	$act				= "act_add";
	$kodejurusan		= "";
	$namajurusan		= "";
	$kodefakultas 		= "";
}
?>
<?php
	if ($act=="act_add")
	{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Tambah Data Jurusan</h3></div>
</div>
<?php
} 
else
{
?>

<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px"> Ubah Data Jurusan</h3></div>
</div>
<?php
}
?>
<?php echo $this->session->flashdata("k_passwod");?>

<div class="well">

<form action="<?php echo base_URL(); ?>index.php/penelitian/jurusan/<?php echo $act; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<table width="100%" class="table-form">
	<?php
		if ($act=="act_add")
		{
	?>
	<tr><td width="20%">Kode Jurusan</td><td><b><input type="text" name="kodejurusan" required value="<?php echo $kodejurusan; ?>" style="width: 700px" class="form-control" autofocus maxlength="5" ></b></td></tr>	
	<?php
	} 
	else
	{
	?>	
	<tr><td width="20%">Kode Jurusan</td><td><b><input type="text" name="kodejurusan" required value="<?php echo $kodejurusan; ?>" style="width: 700px" class="form-control" ></b></td></tr>
	<?php
		}
	?>
	<tr><td width="20%">Nama Jurusan</td><td><b><input type="text" name="namajurusan" required value="<?php echo $namajurusan; ?>" style="width: 700px" class="form-control" autofocus></b></td></tr>

	<!--tr><td><b><input type="hidden" id="kodefakultas" name="kodefakultas" required value="<?php echo $kodefakultas; ?>" style="width: 700px" class="form-control" readonly autofocus></b></td></tr-->

	<tr><td width="20%">Nama Fakultas</td><td><b><select id="fakultas" name="kodefakultas" class="form-control" >
		<option value="" selected>--Pilih Jurusan--</option>
		<?php foreach($fakultas->result() as $f){ ?>
		<option value="<?=$f->kodefakultas?>" <?php if($f->kodefakultas==$kodefakultas){ echo "selected"; } ?> ><?=$f->namafakultas?></option> 
		<?php } ?>
	</select>
	</b></td></tr>


	
	<tr><td width="20%">
	<br><button type="submit" class="btn btn-primary"><i class="icon icon-ok icon-white"></i> Simpan</button>
	<a href="<?php echo base_URL(); ?>index.php/penelitian/jurusan" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
	</td></tr>


	</table>
</form>
</div>

<script type="text/javascript">
$(document).ready(function () {
  $(function () {
    $("#namafakultas").autocomplete({    //id kode sebagai key autocomplete yang akan dibawa ke source url
        minLength:1,
        delay:0,
        source:'<?php echo site_url('index.php/penelitian/get_datafakultas'); ?>',   //nama source kita ambil langsung memangil fungsi get_allkota
        select:function(event, ui){
            $('#namafakultas').val(ui.item.value);
            $('#kodefakultas').val(ui.item.id);
        }
    });
  });
});
 
</script>


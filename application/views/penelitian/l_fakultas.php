<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px">Data Fakultas</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/penelitian/fakultas/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover" id="table">
	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="10%">Kode Fakultas</th>
			<th width="10%">Nama Fakultas</th>
			<th width="10%">Aksi</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		$no= 1;
		if (empty($data)) {
			echo "<tr><td colspan='4'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $b->kodefakultas; ?></td>
			<td><?php echo $b->namafakultas; ?></td>
			<?php 
		//	if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
			<td class="ctr">
				<div class="btn-group">
					<a href="<?php echo base_URL(); ?>index.php/penelitian/fakultas/edt/<?php echo $b->kodefakultas; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Edit</a>
					<a href="<?php echo base_URL()?>index.php/penelitian/fakultas/del/<?php echo $b->kodefakultas?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
					<i class="icon-trash icon-white"> </i> Hapus</a>
				</div>					
			</td>
	
		</tr>
		<?php 
			$no++;
			}
		}
		?>
	</tbody>
</table>
<center><ul class="pagination"><?php echo $pagi; ?></ul></center>
</div>

<script type="text/javascript">
	
$(function () {
	    $("#table").dataTable({
	      "iDisplayLength": 10,
	    });
	});
	
</script>
<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px">Data Dosen</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/penelitian/dosen/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
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
			<th width="10%">NID</th>
			<th width="10%">NIK</th>
			<th width="15%">Nama Dosen</th>
			<th width="10%">Fakultas</th>
			<th width="20%">Program Studi</th>
			<th width="10%">Level</th>
			<th width="20%">Aksi</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		$no= 1;
		if (empty($data)) {
			echo "<tr><td colspan='8'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $b->nidn; ?></td>
			<td><?php echo $b->nik; ?></td>
			<td><?php echo $b->namadosen; ?></td>
			<td><?php echo $b->namafakultas; ?></td>
			<td><?php echo $b->namajurusan; ?></td>
			<td><?php echo $b->level; ?></td>
			
			<?php 
		//	if ($this->session->userdata('admin_level') == "Super Admin") {
			?>
			<td class="ctr">
				<div class="btn-group">
					<a href="<?php echo base_URL(); ?>index.php/penelitian/dosen/edt/<?php echo $b->nidn; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Edit</a>
					<a href="<?php echo base_URL()?>index.php/penelitian/dosen/del/<?php echo $b->nidn?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
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
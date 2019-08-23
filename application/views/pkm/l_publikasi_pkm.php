<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px">Data Pemakalah Forum Ilmiah PKM</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/pkm/publikasipkm/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		
	</div>
</div>




<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover" id="table">
	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="15%">Nama</th>
			<th width="15%">Judul</th>
			<th width="20%">Penyelenggara</th>
			<th width="10%">File</th>
			<th width="20%">Status</th>
			<th width="10%">Aksi</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		$no=1;
		// if (empty($data)) {
		// 	echo "<tr><td colspan='7'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		// } else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
		?>
		<tr>
			<td style="font-size: 11px"><?php echo $no; ?></td>
			<td style="font-size: 11px"><?php echo $b->namadosen; ?></td>
			<td style="font-size: 11px"><?php echo $b->judul; ?></td>
			<td style="font-size: 11px">Institusi : <?php echo $b->institusi; ?><br>
				Tanggal : <?php echo $b->tanggal; ?><br>
				Tempat : <?php echo $b->tempat; ?>
			</td>
			<td style="font-size: 11px" class="ctr"><a href="<?= base_url('upload/publikasipkm\/') . $b->file; ?>">
			<i class="icon-file" title="<?php echo $b->file; ?>"></i></a></td>
		
			<td style="font-size: 11px" class="ctr">
				<?php
					$hasil = $b->status;
					
					if ($hasil == "Disetujui")
					{
				?>
				<div class="btn-group">
					Disetujui
				</div>
				<?php
					}
					else
					{
				?>
			
				<!-- <div class="btn-group">
					<a href="<?php echo base_URL(); ?>index.php/pkm/publikasipkm/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Setujui</a>
					<a href="<?php echo base_URL()?>index.php/pkm/publikasipkm/del/<?php echo $b->id; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
					<i class="icon-trash icon-white"> </i>  -->
				Belum  Disetujui</a>
				</div>	
				<?php
					}
				?>
			</td> 
			<?php 
		//	} else {
		//		echo "<td class='ctr'> -- </td>";
		//	}
			?>

			<td class="ctr">
				<a href="<?= base_url('index.php/pkm/publikasipkm/del/') . '/' . $b->id;?>" class="btn btn-danger btn-sm" role="button"><i class="icon-remove icon-white"> </i></a>
				<a href="<?= base_url('index.php/pkm/publikasipkm/edt/') . '/' . $b->id;?>" class="btn btn-success btn-sm" role="button"><i class="icon-edit icon-white"> </i></a>
			</td>
		</tr>
		<?php 
			$no++;
			// }
		}
		?>
	</tbody>
</table>
<!-- <center><ul class="pagination"><?php echo $pagi; ?></ul></center> -->
</div>

<script type="text/javascript">
	
$(function () {
	    $("#table").dataTable({
	      "iDisplayLength": 10,
	    });
	});
	
</script>
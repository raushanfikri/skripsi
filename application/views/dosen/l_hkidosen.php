<div class="clearfix">

	<div class="panel panel-info">
		<div class="panel-heading" style="overflow: auto">
			<div class="col-md-6">
				<h3 style="margin-top: 5px">Data Hak Kekayaan Intelektual (HKI)</h3>
			</div>
			<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
			<div class="col-md-2">
				<a href="<?php echo base_URL(); ?>index.php/dosen/dosenhki/add" class="btn btn-info"><i
						class="icon-plus-sign icon-white"> </i> Tambah Data</a>
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
				<th width="15%">HKI</th>
				<th width="10%">File</th>
				<th width="20%">Keterangan</th>
				<th width="20%">Aksi</th>
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
				<td><?php echo $no; ?></td>
				<td><?php echo $b->namadosen; ?></td>
				<td><?php echo $b->judul; ?></td>
				<td>Jenis : <?php echo $b->jenis; ?><br>
					No. Pendaftaran : <?php echo $b->nomorpendaftaran; ?><br>
					Status : <?php echo $b->status; ?><br>
					No. HKI : <?php echo $b->nohki; ?>
				</td>
				<td><a href="<?= base_url('upload/hki\/') . $b->file; ?>">
						<?php echo $b->file; ?></a></td>

				<td class="ctr">
					<?php
					$hasil = $b->keterangan;
					
					if ($hasil == "Disetujui")
					{
						?>
					<div class="btn-group">
						Disetujui
					</div>
				<td class="ctr">
					<a href="#" class="btn btn-danger btn-sm" role="button" disabled><i class="icon-remove icon-white">
						</i></a>
					<a href="#" class="btn btn-success btn-sm" role="button" disabled><i class="icon-edit icon-white">
						</i></a>
				</td>
				<?php
					}
					else
					{
						?>

				<div class="btn-group">
					Menunggu Verifikasi
				</div>
				<td class="ctr">
					<a href="<?= base_url('index.php/dosen/dosenhki/del/') . '/' . $b->id;?>"
						class="btn btn-danger btn-sm"><i class="icon-remove icon-white" target="_blank" title="Hapus">
						</i></a>
					<a href="<?= base_url('index.php/dosen/dosenhki/edt/') . '/' . $b->id;?>"
						class="btn btn-success btn-sm"><i class="icon-edit icon-white" target="_blank" title="Ubah">
						</i></a>
				</td>
				<?php
					}
				?>
				</td>
				<?php 
		//	} else {
		//		echo "<td class='ctr'> -- </td>";
		//	}
			?>
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
<div class="clearfix">

	<div class="panel panel-info">
		<div class="panel-heading" style="overflow: auto">
			<div class="col-md-9">
				<h3 style="margin-top: 5px">Data Buku Ajar / Teks</h3>
			</div>
			<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
			<div class="col-md-2">
				<a href="<?php echo base_URL(); ?>index.php/penelitian/buku/add" class="btn btn-info"><i
						class="icon-plus-sign icon-white"> </i> Tambah Data</a>
				
			</div>
			<div class="col-md-0">
				<a href="<?php echo base_URL(); ?>index.php/penelitian/penelitianbuku/" class="btn btn-success"><i
						class="icon-arrow-left icon-white"> </i>Kembali</a>
				
			</div>


			<?php 
		//}

		?>
			<div class="col-md-3"></div>
			<!-- <div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/penelitian/buku/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 200px" placeholder="Kata kunci pencarian ..." required>
				<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
			</form>
		</div> -->
		</div>
	</div>



	

	<?php echo $this->session->flashdata("k");?>

	<table class="table table-bordered table-hover" id="table">
		<thead>

			<tr>
				<th width="5%">No</th>
				<th width="15%">Nama Dosen</th>
				<th width="20%">Judul</th>
				<th width="15%">Buku</th>
				<th width="15%">File</th>
				<th width="20%">Status</th>
				<th width="20%">Aksi</th>
			</tr>
		</thead>

		<tbody>
			<?php 
		$no =1;
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
				<td style="font-size: 11px">Penerbit : <?php echo $b->penerbit; ?><br>
					No. ISBN : <?php echo $b->isbn; ?><br>
					Halaman : <?php echo $b->halaman; ?><br>
				</td>
				<td style="font-size: 11px" class="ctr"><a href="<?= base_url('upload/buku\/') . $b->file; ?>">
						<!-- <img src="..\aset\img\123434.png"  style="display: inline; float: left; margin-right: 20px; width: 80px; height: 80px"> -->
						<i class="icon-file" title="<?php echo $b->file; ?>"></i></a></td>

				<td style="font-size: 11px" class="ctr">
					<?php
					$hasil = $b->keterangan;
					
					if ($hasil == "Disetujui")
					{
				?>
					<div class="btn-group">
						DiSetujui
						<!-- <a href="<?php echo base_URL(); ?>index.php/penelitian/buku/batal/<?php echo $b->id; ?>" class="btn btn-warning btn-sm"><i class="icon-edit icon-white"> </i> Batal</a>
					<a href="<?php echo base_URL(); ?>index.php/penelitian/buku/del/<?php echo $b->id; ?>" class="btn btn-danger btn-sm"><i class="icon-remove icon-white"> </i></a>
					<a href="<?php echo base_URL(); ?>index.php/penelitian/buku/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i></a> -->
					</div>
					<?php
					}
					else
					{
				?>

					<div class="btn-group">
						<!-- <a href="<?php echo base_URL(); ?>index.php/penelitian/buku/ /<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Setujui</a>
					<a href="<?php echo base_URL()?>index.php/penelitian/buku/del/<?php echo $b->id; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
					<i class="icon-trash icon-white"> </i> Tidak Disetujui</a> -->
						Belum DiSetujui
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
				<a href="<?= base_url('index.php/penelitian/buku/edt/') . '/' . $b->id;?>"
						class="btn btn-success btn-sm" role="button" title="Ubah"><i class="icon-edit icon-white"> </i></a>
					<a href="<?= base_url('index.php/penelitian/buku/del/') . '/' . $b->id;?>"
						class="btn btn-danger btn-sm" role="button" title="Hapus"><i class="icon-remove icon-white"> </i></a>
					
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
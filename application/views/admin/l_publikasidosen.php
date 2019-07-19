<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px">Data Publikasi Forum Ilmiah</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/admin/dosenpublikasi/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/admin/dosenpublikasi/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 200px" placeholder="Kata kunci pencarian ..." required>
				<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover">
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
		if (empty($data)) {
			echo "<tr><td colspan='4'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $b->namadosen; ?></td>
			<td><?php echo $b->judul; ?></td>
			<td>Institusi : <?php echo $b->institusi; ?><br>
				Tanggal : <?php echo $b->tanggal; ?><br>
				Tempat : <?php echo $b->tempat; ?>
			</td>
			<td><?php echo $b->file; ?></td>
		
			<td class="ctr">
				<?php
				$hasil = $b->status;
				
				if ($hasil == "Disetujui")
				{
					?>
					<div class="btn-group">
						Disetujui
					</div>
					<td class="ctr">
						<a href="#" class="btn btn-danger btn-sm" role="button" disabled><i class="icon-remove icon-white"> </i></a>
						<a href="#" class="btn btn-success btn-sm" role="button" disabled><i class="icon-edit icon-white"> </i></a>
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
						<a href="<?= base_url('index.php/admin/dosenpublikasi/del/') . '/' . $b->id;?>" class="btn btn-danger btn-sm"><i class="icon-remove icon-white"> </i></a>
						<a href="<?= base_url('index.php/admin/dosenpublikasi/edt/') . '/' . $b->id;?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i></a>
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
			}
		}
		?>
	</tbody>
</table>
<center><ul class="pagination"><?php echo $pagi; ?></ul></center>
</div>

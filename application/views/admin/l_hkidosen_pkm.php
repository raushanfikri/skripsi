<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px">Data Hak Kekayaan Intelektual (HKI) PKM</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/admin/dosenhki_pkm/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/admin/dosenhki_pkm/cari" style="margin-top: 0px">
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
			<th width="10%">No</th>
			<th width="20%">Nama Dosen</th>
			<th width="20%">Judul</th>
			<th width="20%">HKI</th>
			<th width="10%">File</th>
			<th width="20%">Keterangan</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		$no=1;
		if (empty($data)) {
			echo "<tr><td colspan='6'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
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
			<td><?php echo $b->file; ?></td>
		
			<td class="ctr">
				<?php
					$hasil = $b->keterangan;
					
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
			
				<div class="btn-group">
					Menunggu Verifikasi
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

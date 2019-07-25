<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px">Data Seminar PKM</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/dosen/dosenseminar_pkm/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/dosen/dosenseminar_pkm/cari" style="margin-top: 0px">
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
			<th width="15%">Judul</th>
			<th width="15%">Penulis Publikasi</th>
			<th width="15%">Jurnal</th>
			<th width="10%">File</th>
			<th width="10%">Status</th>
			<th width="10%">Aksi</th>
		</tr>
	</thead>
	
	<tbody>
		<?php
		$no=1; 
		if (empty($data)) {
			echo "<tr><td colspan='7'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $b->judul; ?></td>
			<td><?php echo $b->namadosen; ?><br>
				<?php echo $b->penulis_2; ?><br>
				<?php echo $b->penulis_3; ?><br>
			</td>
			<td>Jurnal : <?php echo $b->jurnal; ?><br>
				Jenis : <?php echo $b->jenis; ?><br>
				ISSN : <?php echo $b->issn; ?><br>
				Volume : <?php echo $b->volume; ?><br>
				Nomor : <?php echo $b->no; ?><br>
				Halaman : <?php echo $b->halaman; ?><br>
				Url : <?php echo $b->url; ?><br>
			</td>
			<td><a href="<?= base_url('upload/seminarpkm\/') . $b->file; ?>">
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
						<a href="<?= base_url('index.php/dosen/dosenseminar_pkm/del/') . '/' . $b->id;?>" class="btn btn-danger btn-sm"><i class="icon-remove icon-white"> </i></a>
						<a href="<?= base_url('index.php/dosen/dosenseminar_pkm/edt/') . '/' . $b->id;?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i></a>
					</td>

				<?php
					}
				?>
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

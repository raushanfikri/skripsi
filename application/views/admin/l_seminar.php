<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-3"><h3 style="margin-top: 5px">Data Seminar</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/admin/seminar/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/admin/seminar/cari" style="margin-top: 0px">
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
			<th width="20%">Judul</th>
			<th width="20%">Penulis Publikasi</th>
			<th width="20%">Jurnal</th>
			<th width="10%">File</th>
			<th width="10%">Keterangan</th>
		</tr>
	</thead>
	
	<tbody>
		<?php 
		$no= 1;
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
				ISSN : <?php echo $b->issn; ?><br>
				Volume : <?php echo $b->volume; ?><br>
				Nomor : <?php echo $b->no; ?><br>
				Halaman : <?php echo $b->halaman; ?><br>
				Url : <?php echo $b->url; ?><br>
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
					<a href="<?php echo base_URL(); ?>index.php/admin/seminar/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Setujui</a>
					<a href="<?php echo base_URL()?>index.php/admin/seminar/del/<?php echo $b->id; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
					<i class="icon-trash icon-white"> </i> Tidak Disetujui</a>
				</div>	
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

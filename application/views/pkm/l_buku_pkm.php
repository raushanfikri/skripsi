<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px">Data Buku Ajar / Teks</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/pkm/buku_pkm/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/pkm/buku_pkm/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 200px" placeholder="Kata kunci pencarian ..." required>
				<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="row" >
			<form class="form-inline" action="<?php echo base_URL(); ?>index.php/pkm/exportPDF/v_bukupkm"
				method="POST">
			  <div class="col-md-1">
			    	<label for="awal">Periode Awal:</label>
				</div>
				<div class="col-md-2">
			    	<input type="date" placeholder="Periode awal" class="form-control" id="awal" name="awal">
			  	</div>
			  	<div class="col-md-1">
			    	<label for="akhir">Periode Akhir:</label>
			    </div>
			    <div class="col-md-2">
			    	<input type="date" placeholder="Periode akhir" class="form-control" id="akhir" name="akhir">
			  	</div>
			  	<div class="col-md-1">
			    	<label for="akhir">Nama Dosen</label>
			    </div>
			  	<div class="col-md-2">
				  	<input type="text" placeholder="Nama Dosen" class="form-control" id="namadosen" name="namadosen">
				</div>
		
			<tr><td width="20%">
			  	<div class="col-md-2">
				  <button type="submit" class="btn btn-default">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>


<?php echo $this->session->flashdata("k");?>

<table class="table table-bordered table-hover">
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
		if (empty($data)) {
			echo "<tr><td colspan='7'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
		?>
		<tr> 	
			<td><?php echo $no; ?></td>
			<td><?php echo $b->namadosen; ?></td>
			<td><?php echo $b->judul; ?></td>
			<td>Penerbit : <?php echo $b->penerbit; ?><br>
				No. ISBN : <?php echo $b->isbn; ?><br>
				Halaman : <?php echo $b->halaman; ?><br>
			</td>
			<td><a href="<?= base_url('upload/bukupkm\/') . $b->file; ?>">
			<?php echo $b->file; ?></a></td>
		
			<td class="ctr">
				<?php
					$hasil = $b->keterangan;
					
					if ($hasil == "Disetujui")
					{
				?>
				<div class="btn-group">
					DiSetujui
					<!-- <a href="<?php echo base_URL(); ?>index.php/pkm/buku/batal/<?php echo $b->id; ?>" class="btn btn-warning btn-sm"><i class="icon-edit icon-white"> </i> Batal</a>
					<a href="<?php echo base_URL(); ?>index.php/pkm/buku/del/<?php echo $b->id; ?>" class="btn btn-danger btn-sm"><i class="icon-remove icon-white"> </i></a>
					<a href="<?php echo base_URL(); ?>index.php/pkm/buku/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i></a> -->
				</div>
				<?php
					}
					else
					{
				?>
			
				<div class="btn-group">
					<!-- <a href="<?php echo base_URL(); ?>index.php/pkm/buku/ /<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Setujui</a>
					<a href="<?php echo base_URL()?>index.php/pkm/buku/del/<?php echo $b->id; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
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
			<td>
				<a href="<?= base_url('index.php/pkm/buku_pkm/del/') . '/' . $b->id;?>" class="btn btn-danger btn-sm" role="button"><i class="icon-remove icon-white"> </i></a>
				<a href="<?= base_url('index.php/pkm/buku_pkm/edt/') . '/' . $b->id;?>" class="btn btn-success btn-sm" role="button"><i class="icon-edit icon-white"> </i></a>
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

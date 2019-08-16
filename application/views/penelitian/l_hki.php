<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px">Data Hak Kekayaan Intelektual (HKI)</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/penelitian/hki/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/penelitian/hki/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 200px" placeholder="Kata kunci pencarian ..." required>
				<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="row">
			<form class="form-inline" action="<?php echo base_URL(); ?>index.php/penelitian/exportPDF/v_hki" method="POST">
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
			<th width="15%">Judul</th>
			<th width="20%">HKI</th>
			<th width="10%">File</th>
			<th width="20%">Status</th>
			<th width="20%">Aksi</th>
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
				<?php
					}
					else
					{
				?>
			
				<div class="btn-group">
					<!-- <a href="<?php echo base_URL(); ?>index.php/penelitian/hki/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Setujui</a>
					<a href="<?php echo base_URL()?>index.php/penelitian/hki/del/<?php echo $b->id; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
					<i class="icon-trash icon-white"> </i>  -->
				Belum Disetujui</a>
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
				<a href="<?= base_url('index.php/penelitian/hki/del/') . '/' . $b->id;?>" class="btn btn-danger btn-sm" role="button"><i class="icon-remove icon-white"> </i></a>
				<a href="<?= base_url('index.php/penelitian/hki/edt/') . '/' . $b->id;?>" class="btn btn-success btn-sm" role="button"><i class="icon-edit icon-white"> </i></a>
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

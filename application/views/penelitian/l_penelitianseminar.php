<div class="clearfix">

	<div class="panel panel-info">
		<div class="panel-heading" style="overflow: auto">
			<div class="col-md-6">
				<h3 style="margin-top: 5px">Data Penelitian</h3>
			</div>
			<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
			<div class="col-md-2">
				<a href="<?php echo base_URL(); ?>index.php/penelitian/penelitiann/add" class="btn btn-info"><i
						class="icon-plus-sign icon-white"> </i> Tambah Data</a>
			</div>
			<?php 
		//}

		?>
			<div class="col-md-3"></div>
			<!-- <div class="col-md-4">
				<form class="navbar-form navbar-left" method="post"
					action="<?php echo base_URL(); ?>index.php/penelitian/penelitiann/cari" style="margin-top: 0px">
					<input type="text" class="form-control" name="q" style="width: 200px"
						placeholder="Kata kunci pencarian ..." required>
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
				<th width="15%">Judul</th>
				<th width="15%">Personil</th>
				<th width="15%">Penelitian</th>
				<th width="15%">Dana</th>
				<th width="10%">File</th>
				<th width="10%">Status</th>
				<th width="15%">Aksi</th>
			</tr>
		</thead>

		<tbody>
			<?php 
		$no=1;
		// if (empty($data)) {
		// 	echo "<tr><td colspan='8'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		// } else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
				$get_personil = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->join("dosen","dosen.nidn=detail_anggotapenelitian.nidn")->where("penelitian.idpenelitian",$b->idpenelitian)->order_by("ket","DESC")->get()->result();
		?>
			<tr>
				<td style="font-size: 11px"><?php echo $no; ?></td>
				<td style="font-size: 11px"><?php echo $b->judulpenelitian; ?></td>
				<td style="font-size: 11px">
					<?php 
				foreach($get_personil as $pr){
					echo "<li>$pr->namadosen</li>";
				}
				?>
				</td>
				<td style="font-size: 11px">Jenis : <?php echo $b->jenis; ?><br>
					Bidang : <?php echo $b->bidang; ?><br>
					TSE : <?php echo $b->tse; ?><br>
				</td>
				<td style="font-size: 11px">Sumber : <?php echo $b->sumber; ?><br>
					Institusi : <?php echo $b->institusi; ?><br>
					Jumlah : <?php echo $b->jumlah; ?><br>
				</td>
				<td style="font-size: 11px" class="ctr"><a href="<?= base_url('upload/penelitian\/') . $b->file; ?>">
                        <!-- <img src="..\aset\img\123434.png"  style="display: inline; float: left; margin-right: 20px; width: 80px; height: 80px"> -->
                        <i class="icon-file" title="<?php echo $b->file; ?>"></i></a></td>
					

				<td style="font-size: 11px" class="ctr">
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
						<!-- <a href="<?php echo base_URL(); ?>index.php/penelitian/penelitian/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Setujui</a>
					<a href="<?php echo base_URL()?>index.php/penelitian/penelitian/del/<?php echo $b->id; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
					<i class="icon-trash icon-white"> </i> -->
						Belum Disetujui</a>
					</div>
					<?php
					}
				?>
				<td class="ctr">

					<a href="<?= base_url('index.php/penelitian/detail_seminar/') . '/' . $b->idpenelitian;?>"
						class="btn btn-warning btn-sm" title="Tambah Data Artikel Prosiding"><i class="icon-file icon-white">
						</i></a>
					<a href="<?= base_url('index.php/penelitian/penelitiann/edt/') . '/' . $b->idpenelitian;?>"
						class="btn btn-success btn-sm" role="button" title="Ubah"><i class="icon-edit icon-white"> </i></a>
					<a href="<?= base_url('index.php/penelitian/penelitiann/del/') . '/' . $b->idpenelitian;?>"
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
	<center>
		<ul class="pagination"><?php echo $pagi; ?></ul>
	</center>
</div>

<script type="text/javascript">
	
$(function () {
	    $("#table").dataTable({
	      "iDisplayLength": 10,
	    });
	});
	
</script>
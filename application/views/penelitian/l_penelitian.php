<div class="clearfix">

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="col-md-6"><h3 style="margin-top: 5px">Data Penelitian</h3></div>
		<?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?> 
		<div class="col-md-2">
			<a href="<?php echo base_URL(); ?>index.php/penelitian/penelitiann/add" class="btn btn-info"><i class="icon-plus-sign icon-white"> </i> Tambah Data</a>
		</div>
		<?php 
		//}

		?>
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<form class="navbar-form navbar-left" method="post" action="<?php echo base_URL(); ?>index.php/penelitian/penelitiann/cari" style="margin-top: 0px">
				<input type="text" class="form-control" name="q" style="width: 200px" placeholder="Kata kunci pencarian ..." required>
				<button type="submit" class="btn btn-danger"><i class="icon-search icon-white"> </i> Cari</button>
			</form>
		</div>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading" style="overflow: auto">
		<div class="row">
			<form class="form-inline" action="<?php echo base_URL(); ?>index.php/penelitian/exportPDF/v_penelitian" method="POST">
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

<table class="table table-bordered table-hover" id="id">
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
		if (empty($data)) {
			echo "<tr><td colspan='8'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
				$get_personil = $this->db->select("*")->from("penelitian")->join("detail_anggotapenelitian","detail_anggotapenelitian.idpenelitian=penelitian.idpenelitian")->join("dosen","dosen.nidn=detail_anggotapenelitian.nidn")->where("penelitian.idpenelitian",$b->idpenelitian)->order_by("ket","DESC")->get()->result();
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $b->judulpenelitian; ?></td>
			<td>
				<?php 
				foreach($get_personil as $pr){
					echo "<li>$pr->namadosen</li>";
				}
				?>	
			</td>
			<td>Jenis : <?php echo $b->jenis; ?><br>
				Bidang : <?php echo $b->bidang; ?><br>
				TSE : <?php echo $b->tse; ?><br>
			</td>
			<td>Sumber : <?php echo $b->sumber; ?><br>
				Institusi : <?php echo $b->institusi; ?><br>
				Jumlah : <?php echo $b->jumlah; ?><br>
			</td>
			<td><a href="<?= base_url('upload/penelitian\/') . $b->file; ?>">
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
					<!-- <a href="<?php echo base_URL(); ?>index.php/penelitian/penelitian/edt/<?php echo $b->id; ?>" class="btn btn-success btn-sm"><i class="icon-edit icon-white"> </i> Setujui</a>
					<a href="<?php echo base_URL()?>index.php/penelitian/penelitian/del/<?php echo $b->id; ?>" class="btn btn-warning btn-sm" onclick="return confirm('Anda Yakin..?')">
					<i class="icon-trash icon-white"> </i> -->
					Belum Disetujui</a>
				</div>	
				<?php
					}
				?>
				<td class="ctr">
				<a href="<?= base_url('index.php/penelitian/detail_anggota/') . '/' . $b->idpenelitian;?>" class="btn btn-primary btn-sm" title="Tambah Data Anggota"><i class="icon-list icon-white"> </i></a>
				<a href="<?= base_url('index.php/penelitian/penelitiann/del/') . '/' . $b->idpenelitian;?>" class="btn btn-danger btn-sm" role="button"><i class="icon-remove icon-white"> </i></a>
				<a href="<?= base_url('index.php/penelitian/penelitiann/edt/') . '/' . $b->idpenelitian;?>" class="btn btn-success btn-sm" role="button"><i class="icon-edit icon-white"> </i></a>
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

<!-- <script type="text/javascript">
	function addRowHandlers() {
  var table = document.getElementById("id");
  var rows = table.getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    var currentRow = table.rows[i];
    var createClickHandler = function(row) {
      return function() {
        var cell = row.getElementsByTagName("td")[0];
        var id = cell.innerHTML;
        alert("id:" + id);
      };
    };
    currentRow.onclick = createClickHandler(currentRow);
  }
}



</script> -->
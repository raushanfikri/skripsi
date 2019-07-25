<div class="panel panel-info">
	<div class="panel-heading"><h3 style="margin-top: 5px">Dashboard</h3></div>
</div>

<div class="panel panel-success">
	<div class="panel-heading">Statistik Manajemen E-Dokumen <?php echo $this->session->userdata('admin_ta'); ?></div>
	<div class="panel-body">
		<div class="col-md-6">
			<b>Data Upload Data E-Dokumen</b>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Bulan</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>Jumlah Total E-Dokumen</td>
						<td>111</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<b>Data Peminjaman Surat Berdasarkan Bulan</b>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Bulan</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>Jumlah Total Peminjaman Surat</td>
						<td>111</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="clearfix"></div>

		<div class="col-md-6">
			<b>Data Pengembalian Surat Berdasarkan Bulan</b>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>Jumlah Total Pengembalian Surat</td>
						<td>1111</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="col-md-6">
			<b>Data Surat Belum Dikembalikan</b>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						<td>Jumlah Total Surat Belum Di Kembalikan</td>
						<td>1111</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

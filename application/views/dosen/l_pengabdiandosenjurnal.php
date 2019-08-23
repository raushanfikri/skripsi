<div class="clearfix">

    <div class="panel panel-info">
        <div class="panel-heading" style="overflow: auto">
            <div class="col-md-3">
                <h3 style="margin-top: 5px">Data Pengabdian</h3>
            </div>
            <?php 
	//	if ($this->session->userdata('admin_level') == "Super Admin") {
		?>
            <div class="col-md-12">
                <!-- <a href="<?php echo base_URL(); ?>index.php/dosen/dosenpengabdian/add" class="btn btn-info"><i
                        class="icon-plus-sign icon-white"> </i> Tambah Data</a> -->
            </div>
            <?php 
		//}

		?>

        </div>
    </div>


    <?php echo $this->session->flashdata("k");?>

    <table class="table table-bordered table-hover" id="table">
        <thead>
            <tr>
            <th width="5%">No</th>
                <th width="15%" >Judul</th>
                <th width="10%">Personil</th>
                <th width="15%">Mitra</th>
                <th width="10%">Penelitian</th>
                <th width="15%">Dana</th>
                <th width="5%">File</th>
                <th width="10%">Status</th>
                <th width="15%">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php 
		$no= 1;
		/*if (empty($data)) {
			echo "<tr><td colspan='8'  style='text-align: center; font-weight: bold'>--Data tidak ditemukan--</td></tr>";
		} else {*/
			$no 	= ($this->uri->segment(4) + 1);
			foreach ($data as $b) {
                $get_personil = $this->db->select("*")->from("pengabdiann")->join("detail_anggotapengabdian",
                "detail_anggotapengabdian.idpengabdian=pengabdiann.idpengabdian")->join("dosen",
                "dosen.nidn=detail_anggotapengabdian.nidn")->where("pengabdiann.idpengabdian",$b->idpengabdian)->
                order_by("ket","DESC")->get()->result();
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
                <td style="font-size: 11px">Mitra : <?php echo $b->mitra; ?><br>
                    Alamat Mitra    : <?php echo $b->alamatmitra; ?><br>
                    Kelompok Mitra  : <?php echo $b->kelompokmitra; ?><br>
                </td>
                <td style="font-size: 11px">Jenis : <?php echo $b->jenis; ?><br>
                    Bidang : <?php echo $b->bidang; ?><br>
                    TSE : <?php echo $b->tse; ?><br>
                </td>
                <td style="font-size: 11px">Sumber : <?php echo $b->sumber; ?><br>
                    Institusi : <?php echo $b->institusi; ?><br>
                    Jumlah : <?php echo $b->jumlah; ?><br>
                </td>
                <td style="font-size: 11px" class="ctr"><a href="<?= base_url('upload/pengabdian\/') . $b->file; ?>">
                        <!-- <img src="..\aset\img\123434.png"  style="display: inline; float: left; margin-right: 20px; width: 80px; height: 80px"> -->
                        <i class="icon-file" title="<?php echo $b->file; ?>"></i></a></td>
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
                    <a href="<?= base_url('index.php/dosen/detail_jurnalpkm/') . '/' . $b->idpengabdian;?>"
                        class="btn btn-info btn-sm" title="Tambah Data Anggota"><i class="icon-list icon-white">
                        </i></a>
                    <a href="#" class="btn btn-success btn-sm" role="button" disabled><i class="icon-edit icon-white">
                        </i></a>
                    <a href="#" class="btn btn-danger btn-sm" role="button" disabled><i class="icon-remove icon-white">
                        </i></a>

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
                    <a href="<?= base_url('index.php/dosen/detail_jurnalpkm/') . '/' . $b->idpengabdian;?>"
                        class="btn btn-info btn-sm" title="Tambah Data Anggota"><i class="icon-list icon-white">
                        </i></a>
                    <a href="<?= base_url('index.php/dosen/dosenpengabdian/edt/') . '/' . $b->idpengabdian;?>"
                        class="btn btn-success btn-sm" title="Ubah"><i class="icon-edit icon-white"> </i></a>
                    <a href="<?= base_url('index.php/dosen/dosenpengabdian/del/') . '/' . $b->idpengabdian;?>"
                        class="btn btn-danger btn-sm" title="Hapus"><i class="icon-remove icon-white"> </i></a>

                </td>
                <?php
					}
				?>
                </td>
            </tr>
            <?php 
			$no++;
			//}
		}
		?>
        </tbody>
    </table>
    <!-- <center>
        <ul class="pagination"><?php echo $pagi; ?></ul>
    </center> -->
</div>

<script type="text/javascript">
	
$(function () {
	    $("#table").dataTable({
	      "iDisplayLength": 10,
	    });
	});
	
</script>
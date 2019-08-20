<!-- general form elements -->
<?php echo $this->session->flashdata("k");?>
<div class="well">
  <div class="box-header with-border">
    <h3 class="box-title">Tambah Data Anggota</h3>
  </div>

  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" action="<?=base_url()?>index.php/dosen/simpan_anggotapengabdian">
    <div class="box-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Dosen</label>
        <input type="hidden" name="id" value="<?=$id?>">
        <select name="dosen" class="form-control" required>
          <option value="" disabled="" selected="">Pilih Dosen</option>
          <?php
          $dosen = $this->db->get("dosen");
          foreach($dosen->result() as $d){
            echo "<option value='$d->nidn'>$d->namadosen</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
      <tr><td>
        <br><button type="submit" class="btn btn-primary">Tambah Anggota</button>
      </td></tr>
      <a href="<?php echo base_URL(); ?>index.php/dosen/dosenpengabdian" class="btn btn-success"><i class="icon icon-arrow-left icon-white"></i> Kembali</a>
    </div>
  </form>
</div>
<!-- /.box -->

<!-- Tabel -->
<div class="well">
<table class="table table-bordered table-hover" id="anggota">
  <thead>
    <tr>
      <th width="5%">No</th>
      <th width="15%">NIDN</th>
      <th width="15%">Nama Dosen</th>
      <th width="20%">Status</th>
      <th width="10%">Aksi</th>
    </tr>
  </thead>
  
  <tbody>
    <?php
      $no=0;
      foreach($anggota->result() as $r){ $no++;
    ?>
    <tr>
      <td><?=$no?></td>
      <td><?=$r->nidn?></td>
      <td><?=$r->namadosen?></td>
      <td><?=$r->ket?></td>
      <td>
        <?php if($r->ket=='anggota'){ ?>
        <a href="<?=base_url()?>index.php/dosen/hapus_anggotapengabdian/<?=$r->idpengabdian?>/<?=$r->nidn?>" class="btn btn-danger btn-xs">Hapus</a>
        <?php }else{ ?>
        <a href="javascript:;" disabled class="btn btn-danger btn-xs">Hapus</a>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>

<script type="text/javascript">
  $(function () {
      $("#anggota").dataTable({
        "iDisplayLength": 10,
      });
  });
</script>
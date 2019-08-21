<!-- general form elements -->
<?php echo $this->session->flashdata("k");?>
<div class="well">
  <div class="box-header with-border">
    <h3 class="box-title">Tambah Data Luaran</h3>
  </div>

  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" action="<?=base_url()?>index.php/dosen/simpan_luaranpengabdian">
    <div class="box-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Daftar Luaran</label>
        <input type="hidden" name="id" value="<?=$id?>">
        <select name="luaran" class="form-control" required>
          <option value="" disabled="" selected="">Pilih Luaran</option>
          <?php
          $luaran = $this->db->get("luaran");
          foreach($luaran->result() as $d){
            echo "<option value='$d->idluaran'>$d->namaluaran</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
      <tr><td>
        <br><button type="submit" class="btn btn-primary">Tambah Luaran</button>
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
      <th width="15%">Nama Luaran</th>
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
      <td><?=$r->namaluaran?></td>
      <td class="ctr">
        <a href="<?=base_url()?>index.php/dosen/hapus_luaranpengabdian/<?=$r->idpengabdian?>/<?=$r->idluaran?>"
         class="btn btn-danger btn-xs">Hapus</a>
       
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>

<script type="text/javascript">
  $(function () {
      $("#namaluaran").dataTable({
        "iDisplayLength": 10,
      });
  });
</script>
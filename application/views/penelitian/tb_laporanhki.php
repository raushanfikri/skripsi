<div class="well">
<table class="table table-bordered table-hover" id="anggota">
  <thead>
    <tr>
        <th width="5%">No</th>
        <th width="10%">Nama Dosen</th>
        <th width="10%">Judul Pengabdian</th>
        <th width="10%">Judul HKI</th>
        <th width="10%">Jenis HKI</th>
        <th width="10%">Nomor Pendaftaran</th>
        <th width="15%">Status</th>
        <th width="10%">Nomor HKI</th>
    </tr>
  </thead>
  
  <tbody>
    <?php
      $no=0;
      foreach($result->result() as $r){ $no++;
    ?>
    <tr>
      <td><?=$no?></td>
      <td><?=$r->namadosen?></td>
      <td><?=$r->judulpenelitian?></td>
      <td><?=$r->judul?></td>
      <td><?=$r->jenis?></td>
      <td><?=$r->nomorpendaftaran?></td>
      <td><?=$r->status?></td>
      <td><?=$r->nohki?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>
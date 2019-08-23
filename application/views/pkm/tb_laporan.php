<div class="well">
<table class="table table-bordered table-hover" id="anggota">
  <thead>
    <tr>
        <th width="5%">No</th>
        <th width="10%">Nama Dosen</th> 
        <th width="10%">Judul Pengabdian</th>
        <th width="10%">Judul Publikasi</th>
        <th width="10%">Institusi</th>
        <th width="15%">Tanggal</th>
        <th width="15%">Tempat</th>
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
      <td><?=$r->institusi?></td>
      <td><?=$r->tanggal?></td>
      <td><?=$r->tempat?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>
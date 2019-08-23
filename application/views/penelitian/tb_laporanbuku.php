<div class="well">
<table class="table table-bordered table-hover" id="anggota">
  <thead>
    <tr>
        <th width="5%">No</th>
        <th width="10%">Nama Dosen</th>
        <th width="10%">Judul Pengabdian</th>
        <th width="10%">Judul Buku</th>
        <th width="10%">Penerbit</th>
        <th width="10%">ISBN</th>
        <th width="15%">Halaman</th>

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
      <td><?=$r->penerbit?></td>
      <td><?=$r->isbn?></td>
      <td><?=$r->halaman?></td>
      
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>
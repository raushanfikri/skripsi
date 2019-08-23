<div class="well">
<table class="table table-bordered table-hover" id="anggota">
  <thead>
    <tr>
        <th width="5%">No</th>
        <th width="10%">Nama Dosen</th>
        <th width="10%">Judul Pengabdian</th>
        <th width="10%">Judul Jurnal</th>
        <th width="10%">Nama Jurnal</th>
        <th width="10%">Jenis Jurnal</th>
        <th width="10%">Peran Penulis</th>
        <th width="5%">Tahun</th>
        <th width="10%">Volume</th>
        <th width="10%">No Jurnal</th>
        <th width="10%">ISSN</th>

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
      <td><?=$r->namajurnal?></td>
      <td><?=$r->jenis?></td>
      <td><?=$r->peranpenulis?></td>
      <td><?=$r->tahun?></td>
      <td><?=$r->volume?></td>
      <td><?=$r->no?></td>
      <td><?=$r->issn?></td>
      
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>
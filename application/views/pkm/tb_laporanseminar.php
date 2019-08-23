<div class="well">
<table class="table table-bordered table-hover" id="anggota">
  <thead>
    <tr>
        <th width="5%">No</th>
        <th width="10%">Nama Dosen</th>
        <th width="10%">Judul Pengabdian</th>
        <th width="10%">Nama Prosiding</th>
        <th width="10%">Tahun Prosiding</th>
        <th width="10%">Peran Penulis</th>
        <th width="10%">Volume</th>
        <th width="10%">No Prosiding</th>
        <th width="10%">ISBN/ISBN</th>
        <th width="10%">Jenis Prosiding</th>
        

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
      <td><?=$r->namaprosiding?></td>
      <td><?=$r->tahunprosiding?></td>
      <td><?=$r->peranpenulis?></td>
      <td><?=$r->volume?></td>
      <td><?=$r->no?></td>
      <td><?=$r->isbn?></td>
      <td><?=$r->jenisprosiding?></td>
     
      
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>
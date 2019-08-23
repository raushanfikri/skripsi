<div class="well">
  <div class="box-header with-border">
    <h3 class="box-title">Cetak Laporan</h3>
  </div>

  <!-- /.box-header -->
  <!-- form start -->
  <form method="post" id="form-cetak" action="<?=base_url()?>index.php/pkm/cetak_laporan" target="_blank">
    <div class="box-body">
      <div class="form-group">
        <input type="hidden" id="caption" name="caption">
        <label for="exampleInputEmail1">Daftar Luaran</label>
        <select onchange="tes()" name="luaran" class="form-control" required>
          <option value="" disabled="" selected="">Pilih Luaran</option>
          <?php
          $luaran = $this->db->get("luaran");
          foreach($luaran->result() as $d){
            echo "<option value='$d->idluaran'>$d->namaluaran</option>";
          }
          ?>
        </select>
        <label for="exampleInputEmail1">Periode Awal</label>
        <input onchange="tes()" type="date" id="awal" name="awal" 
							class="form-control" required>
        <label for="exampleInputEmail1">Periode Akhir</label>
        <input onchange="tes()" type="date" id="akhir" name="akhir" 
							class="form-control" required>
        
        <label for="exampleInputEmail1">Nama Dosen</label>
        <input id="namadosen" type="text" name="namadosen" class="form-control" >
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
      <tr><td>
        <br><button type="button" id="btn_tampil" class="btn btn-info">
        <i class="icon icon-list icon-white"></i> Detail Laporan </button>
      </td></tr>
      <button type="submit" id="btn_cetak" class="btn btn-success">
      <i class="icon icon-print icon-white"></i> Cetak</button>
      
    </div>
  </form>
</div>
<div id="show"></div>

<script type="text/javascript">

function tes(){
  var hasil = $('select option:selected').text();
  $('#caption').val(hasil);
}


//$('#form-cetak').submit(function (event) {
$("#btn_tampil").click(function(){


    dataString = $("#form-cetak").serialize();
    $.ajax({
        type:"POST",
        url:"<?php echo base_url(); ?>index.php/pkm/laporan",
        data:dataString,
        
        success: function(msg){
            $('#show').html(msg);
        },
    });
    event.preventDefault();
});
</script>
<?php
$hs = ' <table style="text-align:center">
            <tr>
                <td>
                </td>
            </tr>
            <tr>
                <td style="font-size: 20px; font-weight: bold;">Universitas Teknokrat Indonesia</td>
            </tr>
            <tr>
                <td style="font-size: 12px; font-weight: normal;">Lembaga Penelitian dan Pengabdian Masyarakat </td>
            </tr>
            <tr>
                <td style="font-size: 10px; font-weight: normal;">Jalan Zainal Abidin Pagaralam 9-11 Kedaton Telp. (0721) 702022</td>
            </tr>
            <tr>
                <td>__________________________________________________</td>
            </tr>
        </table>';
    $pdf = new DigiPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $title = "Laporan Rekapitulasi";
    $pdf->SetTitle($title);
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, $hs);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->setFontSubsetting(false);
    $pdf->AddPage();
    $no =1;
?>

<html>
    <head>
        <style>
            table
            {
                border-spacing: 0;
                /* border: 0.5px solid #000; */
                /* border-collapse: collapse; */
            }
            td, th 
            {
                padding:0;
                border: 0.2px solid #000;   
            }
            thead 
            {
                display: table-header-group;
            }
            tr > th {
                background-color: #ddd;
                text-align: center;
                font-weight: bold;
            }
            .ttd > tr > td {
                border: none;
            }
        </style>
    <head>
    <body>
        <br><br><br>
        <h2 style="text-align: center" >Laporan Data Publikasi Ilmiah PKM</h2>
        <table>
            
            <tr style="text-align: center">
                <th width="5%">No</th>
                <th width="20%">Nama Dosen</th> 
                <th width="20%">Judul Pengabdian</th>
                <th width="15%">Judul Publikasi</th>
                <th width="10%">Institusi</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Tempat</th>
                
            </tr>
            <?php
                 $no=0;
                foreach($result->result() as $q){ $no++;
            ?>
            <tr>
                <<!-- td><?php echo date('Y', strtotime($q->tanggal)) ?></td>
                <td><?php echo date('F', strtotime($q->tanggal)) ?></td> -->
                <td><?=$no?></td>
                <!-- <td style="text-align:right"><?php echo $q->judul; ?></td> -->
                <td><?php echo $q->namadosen; ?></td>
                <td><?php echo $q->judulpenelitian?></td>
                <td><?php echo $q->judul?></td>
                <td><?php echo $q->institusi?></td>
                <td><?php echo $q->tanggal?></td>
                <td><?php echo $q->tempat?></td>
                
            </tr>
            <?php } ?>
        </table>


        <br><br><br>
        <table class="ttd">
            <br><br><br>
            <tr><td colspan="5"></td><td colspan="2">Bandar Lampung, <?php echo $hariini;?></td></tr><br>
            <tr><td colspan="5"></td><td colspan="2">Mengetahui,</td></tr>
            <tr><td colspan="5" height="50"></td><td colspan="2" height="50">Ketua LPPM</td></tr>
            <tr><td colspan="5"></td><td colspan="2">Amarudin., S.Kom., M.Eng </td></tr>
        </table>
    </body>
</html>

<?php
    $content = ob_get_contents();
    ob_end_clean();
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->Output('contoh1.pdf', 'I');    
?>
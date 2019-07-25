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

    ob_start();
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
        <h2 style="text-align: center" >Laporan Data Seminar PKM </h2>
        <table>

            <tr style="text-align: center">
            <th width="10%">No</th>
            <th width="20%">Judul</th>
            <th width="20%">Penulis Publikasi</th>
            <th width="20%">Jurnal</th>
            <th width="15%">File</th>
            <th width="15%">Status</th>
                
            </tr>
            <?php foreach($query as $q) : ?>
            <tr>
                <<!-- td><?php echo date('Y', strtotime($q->tanggal)) ?></td>
                <td><?php echo date('F', strtotime($q->tanggal)) ?></td> -->
                <td><?php echo $no; ?></td>
                <td style="text-align:right"><?php echo $q->judul; ?></td>
                <td style="text-align:right"><?php echo $q->namadosen; ?><br>
                                            <?php echo $q->penulis_2; ?><br>
                                            <?php echo $q->penulis_3; ?><br>
                </td>
                <td style="text-align:right">Jurnal : <?php echo $q->jurnal; ?><br>
                                            Jenis : <?php echo $q->jenis; ?><br>                
                                            ISSN : <?php echo $q->issn; ?><br>
                                            Volume : <?php echo $q->volume; ?><br>
                                            Nomor : <?php echo $q->no; ?><br>
                                            Halaman : <?php echo $q->halaman; ?><br>
                                            url : <?php echo $q->url; ?><br>
                </td>
                <td style="text-align:right"><?php echo $q->file ?></td>
                <td style="text-align:right"><?php echo $q->keterangan ?></td>
                
            </tr>
            <?php 

            $no++;
            endforeach; ?>
        </table>
        <br><br><br>
        <table class="ttd">
            <br><br><br>
            <tr><td colspan="7"></td><td colspan="2">Mengetahui,</td></tr>
            <tr><td colspan="7" height="50"></td><td colspan="2" height="50">Ketua LPPM</td></tr>
            <tr><td colspan="7"></td><td colspan="2">Amarudin., S.Kom., M.Eng </td></tr>
        </table>
    </body>
</html>

<?php
    $content = ob_get_contents();
    ob_end_clean();
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->Output('contoh1.pdf', 'I');    
?>
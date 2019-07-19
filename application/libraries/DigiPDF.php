<?php

// function tcpdf()
// {
//     //require_once('tcpdf/config/lang/eng.php');
//     require_once('tcpdf/config/tcpdf_config.php');
//     require_once('tcpdf/tcpdf.php');
// }

// require_once('tcpdf/config/tcpdf_config.php');
// require_once('tcpdf/tcpdf.php');

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class DigiPDF extends TCPDF
{
     //Page header
     public function Header() 
     {
        // Logo
        $image_file = base_url('aset/img/UNIVERSITASTEKNOKRAT.png');
        $headerData = $this->getHeaderData();
        $this->Image($image_file, 15, 10, 20, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        // $this->Cell(0, 15, 'PT DIGITAL GOLDEN COMMUNICATION', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln(5);
        // $this->SetFont('helvetica', 'R', 12);
        // $this->Cell(0, 12, 'Jalan Teuku Umar No 10 G Penengahan - Kedaton Bandar Lampung', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->writeHTML($headerData['string']);
    }

    // Page footer
    public function Footer() 
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Hal.  '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function rupiah($num) 
    {
        $res = "Rp " .  number_format($num, 2, ',', '.');
        return $res;
    }
}
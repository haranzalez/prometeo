<?php
include '../PDF/pdf.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$formato = 1;
$mesini = '2016-01';
$mesfin = '2016-12';
$pdf = new PDF(null,null,null);
print_r($pdf->folder_list());


?>
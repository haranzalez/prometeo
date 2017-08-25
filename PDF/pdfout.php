<?php
    require '../PDF/pdf.php';
    if(isset($_POST['formato']) && isset($_POST['mesini']) && isset($_POST['mesfin']))
    {
        $pdf = new PDF($_POST['formato'],$_POST['mesini'],$_POST['mesfin']);
        header("Content-type: application/pdf");
        echo $pdf->return_pdf($doc_id);
    }else{
        $doc_id = $_GET['docid'];
        $pdf = new PDF(null,null,null);
        header("Content-type: application/pdf");
        echo $pdf->return_pdf($doc_id);
    }
?>
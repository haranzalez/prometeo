<?php
    include '../src/dbcred.php';
    require_once('../src/Files.php');
    require_once('pdf.php');
    if(isset($_POST['formato']) && isset($_POST['mesini']) && isset($_POST['mesfin']) && isset($_POST['nit_empresa']))
    {
        $pdf = new PDF($_POST['formato'],$_POST['mesini'],$_POST['mesfin'],$_POST['nit_empresa']);
        header("Content-type: application/pdf; charset=UTF-8");
        echo $pdf->doc_out();
    }else{
        $doc_id = $_GET['docid'];
        $file = new Files($db);
        header("Content-type: application/pdf; charset=UTF-8");
        echo $file->return_pdf($doc_id);
    }
?>
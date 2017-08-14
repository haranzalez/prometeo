<?php
    require '../PDF/pdf.php';
    if(isset($_POST['formato']) && isset($_POST['mesini']) && isset($_POST['mesfin']))
    {
        $pdf = new PDF($_POST['formato'],$_POST['mesini'],$_POST['mesfin']);
        $pdf->doc_out();
    }else{
        echo 'ERR: one or more variables are not set.';
    }

?>
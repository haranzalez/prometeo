<?php
include '../PDF/pdf.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include 'dbcred.php';
require_once('Doc.php');
require_once('Log.php');
require_once('Files.php');
require_once('Reg.php');


$bot = new Reg($db);
echo $bot->getSenderEmail($id = 1);
print_r($bot->getSenderEmail($id = 1));
echo $bot->ReSendRegEmail('haranzalez@gmail.com');
//echo $doc->folder_list();

//var_dump($doc->folder_list());


?>
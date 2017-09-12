<?php
include '../PDF/pdf.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include 'dbcred.php';
require_once('Doc.php');
require_once('Log.php');
require_once('Files.php');


$bot = new Files($db);
echo $bot->check_user();
//echo $doc->folder_list();

//var_dump($doc->folder_list());


?>
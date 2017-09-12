
<?php
/*!
 * controler.php
 * Version BETA 
 * Hans Christian Aranzalez - <haranzalez@gmail.com>
 */ 
    ob_start();
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //INCLUDES
    include 'dbcred.php';
    require_once('Reg.php');
    require_once('Log.php');
    require_once('Doc.php');
    require_once('Files.php');
    require_once('usersettings.php');
    require_once('../PDF/pdf.php');
    

    //VALUES
    $client_id = (isset($_SESSION['nit']))?$_SESSION['nit']:false;
    $request = (isset($_GET['req']))?$_GET['req']:false;
    $requestP = (isset($_POST['req2']))?$_POST['req2']:false;
    $email = (isset($_GET['email']))?$_GET['email']:false;
    $recuPassEmail = (isset($_GET['client_email']))?$_GET['client_email']:false;
    $username = (isset($_POST['user_name']))?$_POST['user_name']:false;
    $pass = (isset($_POST['user_pass']))?$_POST['user_pass']:false;
    $usrLout = (isset($_GET['user']))?$_GET['user']:false;
    $id_empresa = (isset($_GET['idemp']))?$_GET['idemp']:false;
    $mesini = (isset($_GET['mesini']))?$_GET['mesini']:false;
    $mesfin = (isset($_GET['mesfin']))?$_GET['mesfin']:false;
    $codigoFormato = (isset($_GET['codform']))?$_GET['codform']:false;
    $document = (isset($_POST['document']))?$_POST['document']:false;
    $nombre_folder = (isset($_GET['folderName']))?$_GET['folderName']:false;
    $doc_id = (isset($_GET['docid']))?$_GET['docid']:false;
    $editUserObj = (isset($_POST['obj']))?$_POST['obj']:false;
    $encVal = (isset($_GET['encVal']))?$_GET['encVal']:false;

    //CLASSES CONSTRUCTORS
    $reg = new Reg($db);
    $log = new Log($db);
    $doc = new Doc($db); 
    $files = new Files($db);
    $user = new Usettings($db);
    $nullPDF = new PDF(null,null,null,null);

    //REQUESTS
    if($request == 'confi' && $email != false)
    {
        echo $email;
        if($reg->confirmReg($email))
         {
            header('Location: '.$siteURI.'/promTest/confirm.php?conf=true&email='.$email);
         }
    }
    if($request == 'regi')
    {
         echo $reg->register($_POST);
    }
    if($request == 'pass' && $recuPassEmail != false)
    {
         echo $log->sendPass($recuPassEmail);
    }
    if($request == 'empvin')
    {
        $reso = $doc->emprsas();
        echo json_encode($reso->pkg);
    }
    if($request == 'cert' && $codigoFormato != false && $mesini != false && $mesfin != false && $id_empresa != false)
    {
        echo json_encode($doc->generar_certificado($codigoFormato, $mesini, $mesfin, $id_empresa));
    }
    if($request == 'login' && $username != false && $pass != false)
    {
        $log->checkLogIn();
        
        $res = $log->login($username, $pass);
        if($res == 'success!')
        {
            echo 1;
        }else if($res === false)
        {
           echo 0;
           
        }else if($res == 'no activo')
        {
            echo 2;
            
        }else if($res == 'not in db'){
            echo 3;
        } 
        
    }
    if($request == 'periodos' && $id_empresa != false && $codigoFormato != false)
    {
        echo json_encode($doc->periodos($id_empresa, $codigoFormato));
        //echo $doc->generar_certificado();
    }
    if($request == 'formatos' && $id_empresa != false)
    {
        echo json_encode($doc->formatos($id_empresa));
        //echo $doc->generar_certificado();
    }
    if($request == 'guardarcert' && isset($_POST['img']) && isset($_POST['formato']) && isset($_POST['mesini']) && isset($_POST['mesfin']))
    {
       $pdf = new PDF($_POST['formato'],$_POST['mesini'],$_POST['mesfin'], $_POST['nit_empresa']);
       $fname = $_POST['folder'];
       echo $pdf->guardar_en_db($fname);
    }
    if($request == 'files')
    {
        
        echo json_encode($files->folder_list());
    }
    if($request == 'newFold' && $nombre_folder != false)
    {
        
        echo $files->create_folder($nombre_folder);
    }
    if($request == 'opendir' && $nombre_folder != false)
    {
        echo json_encode($files->open_dir($nombre_folder));
    }
    if($request == 'delfile' && $doc_id != false)
    {
        
        echo $files->del_doc($doc_id);
    }
    if($request == 'deldir' && $nombre_folder != false)
    {
        
        echo $files->del_folder($nombre_folder);
    }
    

    //USER SETTINGS
    if($request == 'infouser')
    {
        echo json_encode($user->info_usuario());
    }
    if($request == 'edituser' && $editUserObj != false)
    {
        echo $user->actualizar_datos($editUserObj);
    }
    if($request == 'changepass')
    {
        $pass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];
        if($newpass == $_POST['newpassconfi']){
            echo $user->cambiar_clave($pass, $newpass);
        }
    }
    if($request = 'encrypt' && $encVal != false)
    {
        echo $nullPDF->encrypt($encVal);
    }

    
    
    

?>
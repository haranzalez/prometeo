<?php 
    ob_start();
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //INCLUDES
    require 'dbcred.php';
    require 'Reg.php';
    require 'Log.php';
    require_once 'Doc.php';
    require 'Files.php';
    require 'usersettings.php';
    require '../PDF/pdf.php';

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

    //CLASSES CONSTRUCTORS
    $reg = new Reg($db);
    $log = new Log($db);
    $doc = new Doc($db); 
    $files = new Files();
    $user = new Usettings($db);

    //REQUESTS
    if($request == 'confi' && $email != false)
    {
        if($reg->confirmReg($email))
         {
            header('Location: http://70.35.196.223/promTest/confirm.php?conf=true&email='.$email);
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
    if($request == 'cert' && $codigoFormato != false && $mesini != false && $mesfin != false)
    {
        echo json_encode($doc->generar_certificado($codigoFormato, $mesini, $mesfin));
    }
    if($request == 'login' && $username != false && $pass != false)
    {
        $log->checkLogIn();
        
        $res = $log->login($username, $pass);
        if($res === false)
        {
           echo 'Su correo electronico o contrasena esta incorrecto. Por favor trate denuevo, o si olvido su contrasena recuperela <button style="color:#333;" class="recuPassBtn" type="button">aqui.</button>';
           
        }else if($res == 'no activo')
        {
            echo "Al parecer su correo electronico aun no se a confirmado. Por favor revise su correo electronico para activar su cuenta";
            
        }else if($res == true)
        {
            echo true;
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
       $pdf = new PDF($_POST['formato'],$_POST['mesini'],$_POST['mesfin']);
       $fname = $_POST['folder'];
       echo $pdf->guardar_en_db($fname);
    }
    if($request == 'files')
    {
        $pdf = new PDF(null,null,null);
        echo json_encode($pdf->folder_list());
    }
    if($request == 'newFold' && $nombre_folder != false)
    {
        $pdf = new PDF(null,null,null);
        echo $pdf->create_folder($nombre_folder);
    }
    if($request == 'opendir' && $nombre_folder != false)
    {
        echo json_encode($files->open_dir($nombre_folder));
    }
    if($request == 'delfile' && $doc_id != false)
    {
        $pdf = new PDF(null,null,null);
        echo $pdf->del_doc($doc_id);
    }
    if($request == 'deldir' && $nombre_folder != false)
    {
        $pdf = new PDF(null,null,null);
        echo $pdf->del_folder($nombre_folder);
    }
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

    
    
    

?>
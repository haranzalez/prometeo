
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
    require_once 'vendor/autoload.php';
    include 'sitecred.php';
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
    $fnum = (isset($_GET['fnum']))?$_GET['fnum']:false;
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
        if($reg->confirmReg($email))
         {
            header('Location: '.$siteURI.'/confirm.php?conf=true&email='.$email);
         }
    }
    if($request == 'regi')
    {
         echo $reg->register($_POST);
    }
    if($request == 'regEmail' && $email != false){
        echo $reg->ReSendRegEmail($email);
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
    if($request == 'movef' && $nombre_folder != false && $doc_id != false){
        echo $files->move_file($nombre_folder,$doc_id);
    }
    if($request == 'editfol' && $nombre_folder != false && $fnum != false){
        echo $files->edit_folder_name($nombre_folder,$fnum);
    }

    if($request == 'contactEmail'){
        
        $user_email = $_POST['email'];
        $user_name = $_POST['name'];
        $user_lastname = $_POST['lastname'];
        $user_tel = (isset($_POST['tel']))?$_POST['tel']:'No aplicado';
        $user_movil = (isset($_POST['mobile']))?$_POST['mobile']:'No aplicado';
        $clientCopy = (isset($_POST['copyEmail']))?true:false;
        $user_message = $_POST['message'];
        $captcha = (!empty($_POST['g-recaptcha-response']))?true:false;

        if($captcha){
            $bodyStyle = "background-color:#FFCC66;";
            $wrapperStyles = "background-color:white;
            width:96%;
            box-shadow:0px 1px 1px #333;
            border-radius:2px;
            margin:auto;";
            $messStyles = "padding:60px;line-height:1.6;text-align: justify;
            text-justify: inter-word;";
            $logoStyles = "text-align:center;
            padding:20px 0px;";
            $h3Style = "color:black;
            font-size:14px;";
            $confirmBtnStyle = "text-decoration:none;
            margin:auto;
            width:30%;
            display:block;
            background-color:darkred;
            padding:10px;
            border:none;
            border-radius:3px;
            font-size:10pt;
            color:white;";
            $emailToSendTo = $reg->getSenderEmail($id = 2);
            $mail = new PHPMailer;
            $mail->From = 'info@sqlsoluciones.com';
            $mail->FromName = "Prometeo";
            if($clientCopy){
                $mail->addAddress($user_email);
            }
            $mail->addAddress($emailToSendTo);
            $mail->isHTML(true);
            $mail->Subject = "Nuevo Contacto";
            $html = '<!DOCTYPE html>
            <head>
                <meta charset="utf-8">
            </head>
            <body style="'.$bodyStyle.'">
                <div class="logo" style="'.$logoStyles.'">
                    <img style="width:220px;" src="http://'.SITE_URI.'img/logo_ppal.png" alt="">
                    <h3 style="'.$h3Style.'">
                    SQL SOLUCIONES INFORMATICAS SAS<br/>
                    Nuevo Contacto
                    </h3>
                
                </div>
                <div class="wrapper" style="'.$wrapperStyles.'">
                    
                        <div style="'.$messStyles.'">
                            <p style="">
                                Un nuevo mensaje se a registrado con los siguientes datos:
                            </p>
                            
                            <table>
                            <tr><td style="white-space: nowrap;">Correo electronico:</td><td>'.$user_email.'</td></tr>
                            <tr><td style="white-space: nowrap;">Nombre:</td><td>'.$user_name.'</td></tr>
                            <tr><td style="white-space: nowrap;">Apellido:</td><td>'.$user_lastname.'</td></tr>
                            <tr><td style="white-space: nowrap;">Telefono Fijo:</td><td>'.$user_tel.'</td></tr>
                            <tr><td style="white-space: nowrap;">Telefono Movil:</td><td>'.$user_movil.'</td></tr>
                            <tr><td style="white-space: nowrap;">Mensaje:</td><td>'.$user_message.'</td></tr>
                            </table>
    
                           
                    </div>
    
                    <div class="footer">
                        <p style="color:#666;padding:50px 0px;text-align:center;position:absolute;bottom:0;left:0;width:100%;">&copy;2017 Prometeo.</p>
                    </div>
                </div>
            </body>
        </html>';
            $mail->Body = $html;
            if(!$mail->send()) 
            {
                echo "Err: " . $mail->ErrorInfo;
            } 
            else 
            {
                echo true;
            }

        }else{
            echo 2;
        }

       
        
        
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
    if($request == 'changepass' && isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['newpassconfi']))
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
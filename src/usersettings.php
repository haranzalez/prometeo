<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'vendor/autoload.php';
include 'sitecred.php';

require_once('Reg.php');
error_reporting(E_ALL);

    class Usettings{

        public function __construct($db)
        {
            $this->_mail = new PHPMailer;
            $this->siteURI = SITE_URI;
            $this->db = $db;
            $this->table = 'users_web';
            $this->nit = (isset($_SESSION['nit']))?$_SESSION['nit']:false;
            $this->email = (isset($_SESSION['email']))?$_SESSION['email']:false;
            $reg = new Reg($db);
            $this->sendEmail = $reg->getSenderEmail($id = 1);
            
          
            
        }
        public function info_usuario()
        {
            $sql = "SELECT * FROM $this->table WHERE client_email = '".$this->email."'";
            $res = $this->db->query($sql);
            $row = $res->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        public function actualizar_datos($arr)
        {
            $data = json_decode("$arr", true);
            if($data['key'] == 'client_name'){
                $_SESSION['user_full_name'] = $data['d'].' '.$_SESSION['user_lastname'];
            }else if($data['key'] == 'client_lastname')
            {
                $_SESSION['user_full_name'] = $_SESSION['user_name'].' '.$data['d'];
            }
            $sql = "UPDATE $this->table SET ".$data['field'];
            $sql .= " WHERE client_email = '".$this->email."'";
            $res = $this->db->query($sql);
            if($res){
                return 1;
            }
        }
        
        public function cambiar_clave($pass, $newPass)
        {
            $sql = "SELECT * FROM users_web WHERE client_email = '$this->email' AND client_password = '$pass' LIMIT 1";
            $res = $this->db->query($sql);
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if($res->rowCount() > 0)
            {
                $sql2 = "UPDATE $this->table SET client_password = '". $newPass . "' WHERE client_email = '$this->email'";
                $res2 = $this->db->query($sql2);
                if($res2){
                    $this->send_pass_change_email($pass, $newPass);
                    return true;
                } 
            }else{
                return false;
            }
        }

        public function send_pass_change_email($pass, $newPass)
        {
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

            $this->_mail->From = $this->sendEmail;
            $this->_mail->FromName = "Prometeo";
            $this->_mail->addAddress($this->email, $_SESSION['user_full_name']);
            $this->_mail->addReplyTo($this->sendEmail, "Responda a");
            $this->_mail->isHTML(true);
            $this->_mail->Subject = "Cambio de contraseña";
        
            $this->_mail->Body = '<!DOCTYPE html>
                <head>
                    <meta charset="utf-8">
                </head>
                <body style="'.$bodyStyle.'">
                    <div class="logo" style="'.$logoStyles.'">
                        <img style="width:220px;" src="http://'.$this->siteURI.'img/logo_ppal.png" alt="">
                        <h3 style="'.$h3Style.'">
                        SQL SOLUCIONES INFORMATICAS SAS<br/>
                        Cambio de contraseña
                        </h3>
                    </div>
                    <div class="wrapper" style="'.$wrapperStyles.'">
                        
                            <div style="'.$messStyles.'">
                                <p style="">
                                    Este correo es para confirmarle que su contraseña a cambiado.
                                </p>
                                
                                <table>
                                <tr><td><b>Contraseña reciente:</b></td><td>'.$pass.'</td></tr>
                                <tr><td><b>Contraseña nueva:</b></td><td>'.$newPass.'</td></tr>
                                </table>

                                <p>
                                    Si usted no ha tomado ninguna accion para cambiar su contraseña, porfavor comuniquese con nosotros inmediatamente a info@sqlprometeo.com:
                                </p>
                            
                                <p>
                                    <b>Importante</b><br/>
                                    Este correo ha sido enviado automáticamente, 
                                    favor no responder a esta dirección de correo, 
                                    ya que no se encuentra habilitada para recibir mensajes. 
                                    Si requiere mayor información sobre el contenido de este mensaje, 
                                    enviar un correo electrónico a <a href="#">info@sqlsoluciones.com</a>
                                </p>
                        </div>

                        <div class="footer">
                            <p style="color:#666;padding:50px 0px;text-align:center;position:absolute;bottom:0;left:0;width:100%;">&copy;2017 Prometeo.</p>
                        </div>
                    </div>
                </body>
            </html>';

            if(!$this->_mail->send()) 
            {
                return "Err: " . $this->_mail->ErrorInfo;
            } 
            else 
            {
                return true;
            }
           
        }


    }

    





?>
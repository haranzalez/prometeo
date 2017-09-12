<?php 
   ob_start();
   require 'vendor/autoload.php';
   include 'sitecred.php';
   class Log
   {
       public function __construct($db)
       {
           $this->_mail = new PHPMailer;
           $this->_conn = $db;
           $this->_email = (isset($_SESSION['user']))?$_SESSION['user']:false;
           $this->_sessid = (isset($_SESSION['sess']))?$_SESSION['sess']:false;
           $this->_isLogedIn = ($this->_email && $this->_sessid)?$this->checkLogIn():false;
           $this->siteURI = SITE_URI;
           
       }
        private function sessionID()
       {
            $y = date('y');
            $m = date('n');
            return 'S'.$y.$m.rand(100, 1000);
       }

       public function checkLogIn()
       {
            try{
                $sql = "SELECT * FROM users_web WHERE client_email = '$this->_email' AND client_session_id = '$this->_sessid' LIMIT 1";
                $res = $this->_conn->query($sql);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                if($res->rowCount() > 0)
                {
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                print_r($this->_conn->errorInfo());
                
            }       
       }
       public function check_if_exist($email){
        $sql = "SELECT * FROM users_web WHERE client_email = '$email'";
        $res = $this->_conn->query($sql);
        $row = $res->fetch(PDO::FETCH_ASSOC);
        if($res->rowCount() > 0){
            return true;
        }else{
            return false;
        }
       }
       public function login($username, $pass)
       {
           if($this->check_if_exist($username)){
            if($this->_isLogedIn === false)
            {
                try{
                 $sql = "SELECT * FROM users_web WHERE client_email = '$username' AND client_password = '$pass' LIMIT 1";
                 $res = $this->_conn->query($sql);
                 $row = $res->fetch(PDO::FETCH_ASSOC);
                 
                 if($res->rowCount() > 0)
                     {
                         
                         if($row['client_active'] == 0)
                         {
                             return "no activo";
                         }else{
                             $this->_isLogedIn = true;
                             $this->_sessid = $this->sessionID();
                             $this->_user = $row['client_name'].' '.$row['client_lastname'];
 
                             $_SESSION['user'] =  $this->_user;
                             $_SESSION['user_name'] = $row['client_name'];
                             $_SESSION['user_lastname'] = $row['client_lastname'];
                             $_SESSION['user_full_name'] = $row['client_name'] . ' ' . $row['client_lastname'];
                             $_SESSION['sess'] = $this->_sessid;
                             $_SESSION['email'] = $row['client_email'];
                             $_SESSION['nit'] = $row['client_cedula'];
 
                             $sqlUpdt = "UPDATE users_web SET client_session_id = '$this->_sessid' WHERE client_email = '$username' AND client_password = '$pass'";
                             $this->_conn->query($sqlUpdt);
                             
                             return 'success!';
                         }
                     }else{
                         return false;
                     }
                }catch(Exception $e){
                     print_r($this->_conn->errorInfo());
                     
                }
                
            }else{
                return true;
            }
           }else{
               return 'not in db';
           }
          
       }
       public function sendPass($email)
       {
            $sql = "SELECT * FROM users_web WHERE client_email = '$email' LIMIT 1";
            $res = $this->_conn->query($sql);
            
             if($res->rowCount() > 0)
             {
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    
                    $this->_mail->From = "info@sqlsoluciones.com";
                    $this->_mail->FromName = "Prometeo";
                    $this->_mail->addAddress($email, $row['client_name'].' '.$row['client_lastname']);
                    $this->_mail->addReplyTo("info@sqlsoluciones.com", "Responder");
                    $this->_mail->isHTML(true);
                    $this->_mail->Subject = "Prometeo Ingreso al WebSite";
                    $this->_mail->Body = '<!DOCTYPE html><head><meta charset="utf-8"></head><body>';
                    $this->_mail->Body .= '<div class="wrapper">';
                    $this->_mail->Body .= '<div class="logo" style="background-color:#ffcc66;text-align:center;padding:20px 0px;"><img src="http://'.$this->siteURI.'img/logo_ppal.png" alt="">
                    <h3>SQL SOLUCIONES INFORMATICAS SAS
                    Reenvió de contraseña - Olvido de Clave</h3>
                    </div>';
                    $this->_mail->Body .= '<div class="message">
                    <p style="">Recientemente hemos recibido una solicitud para reenvió de Contraseña.</p><p> Usted puede ingresar a la plataforma con el correo: '.$email.'Y la Contraseña: '.$row['client_password'].'</p>
                    <p>
                        <b>Importante</b>
                        Este correo ha sido enviado automáticamente, favor no responder a esta dirección de correo, ya que no
                        se encuentra habilitada para recibir mensajes. Si requiere mayor información sobre el contenido de este
                        mensaje, enviar un correo electrónico a <a href="#">info@sqlsoluciones.com</a>
                    </p>
                </div>';
                    $this->_mail->Body .= '<div class="footer">
                    <p style="color:#666;padding:50px 0px;text-align:center;position:absolute;bottom:0;left:0;width:100%;">&copy;2017 Prometeo.</p>
                </div>';
                    $this->_mail->Body .= ' </div></body></html>';
                    if(!$this->_mail->send()) 
                    {
                        return "Err: " . $this->_mail->ErrorInfo;
                    } 
                    else 
                    {
                        return true;
                    }
                   
             }else{
                 return $email;
             }
       }

      
   }
 
 
 
 
 
 
 
 ?>
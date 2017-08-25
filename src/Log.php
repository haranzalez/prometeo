<?php 
   ob_start();
   require_once 'vendor/autoload.php';
   class Log
   {
       public function __construct($db)
       {
           $this->_mail = new PHPMailer;
           $this->_conn = $db;
           $this->_email = (isset($_SESSION['user']))?$_SESSION['user']:false;
           $this->_sessid = (isset($_SESSION['sess']))?$_SESSION['sess']:false;
           $this->_isLogedIn = ($this->_email && $this->_sessid)?$this->checkLogIn():false;
           
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
                    $destination = 'portal.php?m='.$row['client_active'];
                    header("Location: ".$destination);
                    exit;
                }
            }catch(Exception $e){
                print_r($this->_conn->errorInfo());
                
            }       
       }

       public function login($username, $pass)
       {
           $destination = 'portal.php';
           if($this->_isLogedIn === false)
           {
               try{
                $sql = "SELECT * FROM users_web WHERE client_email = '$username' AND client_password = '$pass' LIMIT 1";
                $res = $this->_conn->query($sql);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                if($res->rowCount() > 0)
                    {

                        if($row['client_active'] != 1)
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
                            
                            return true;
                        }
                    }else{
                        return false;
                    }
               }catch(Exception $e){
                    print_r($this->_conn->errorInfo());
                    
               }
               
           }
           return 'is logged in is not false';
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
                    $this->_mail->Subject = "Bienvenido a Prometeo!";
                    $this->_mail->Body = '<!DOCTYPE html><head><meta charset="utf-8"></head><body>';
                    $this->_mail->Body .= '<div class="wrapper">';
                    $this->_mail->Body .= '<div class="logo" style="background-color:#ffcc66;text-align:center;padding:20px 0px;"><img src="http://70.35.196.223/promTest/img/logo_ppal.png" alt="">
                    <h3>Hola '.$row['client_name'].' '.$row['client_lastname'].'</h3>
                    </div>';
                    $this->_mail->Body .= '<div class="message">
                    <p style="line-height:1.5;text-align:center;">Deacuerdo a su solicitud, su clave de acceso es:</p>
                    <div style="text-align:center;padding:30px;"><a href="http://local.dev/prometeo/login.php" style="text-decoration:none;margin:auto;width:30%;display:block;background-color:orangered;padding:20px;border:none;border-radius:5px;font-size:18pt;color:white;">'.$row['client_password'].'</a></div>
                    <p style="line-height:1.5;text-align:center;">
                        Si requiere de mas ayuda, no dude en escribirnos a <a href="#">info@sqlsoluciones.com</a>
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
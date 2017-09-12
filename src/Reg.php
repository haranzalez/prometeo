<?php 
    require_once 'vendor/autoload.php';
    include 'sitecred.php';
    class Reg {

        public function __construct($db)
        {

            $this->_mail = new PHPMailer;
            $this->_conn = $db;
            $this->_headings = $this->getHeadings();
            $this->siteURI = SITE_URI;

        }
        private function getHeadings()
        {
            $q = "select * from information_schema.columns where
table_name='users_web'";
            $_cTheadings = $this->_conn->query($q);
            return $_cTheadings->fetchAll(PDO::FETCH_COLUMN);
        }
        private function checkReg($user_email)
        {
            $sql = "SELECT * FROM users_web WHERE client_email = '".$user_email."'";
            $res = $this->_conn->query($sql);
            if($res->rowCount() > 0)
            {
                return true;
            }else if($res->rowCount() == 0)
            {
                return false;
            }

        }
        private function ID()
        {
            $y = date('y');
            $m = date('n');
            return $y.$m.rand(100, 1000);   
        }
        public function register($postArr)
        {
            try{
                $check = $this->checkReg($postArr['client_email']);
                
                if($check)
                {
                    return false;
                }else{
                    
                    $sql = "INSERT INTO users_web ";
                   
                    $sql .= "VALUES(";
                    
                    foreach ($postArr as $key => $value) {
                         
                        $sql .= "'".$value."',";
                       
                    }
                    $sql .= "false,0)";
                    
                    $this->_conn->query($sql);
                    if(!$this->regEmail($postArr['client_email'], $postArr['client_names'], $postArr['client_lastnames'],$postArr['client_pass']))
                    {
                        return false;
                    }else{
                        return true;
                    }
                    

                }
                
            }catch(PDOException $ex) {
                echo $ex;
                
            }
            
        }

        public function confirmReg($email)
        {
            $sql = "SELECT * FROM users_web WHERE client_email = '$email'";
            $result = $this->_conn->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if($result->rowCount() > 0)
            {
                try{
                    $sql2 = "UPDATE users_web SET client_active = true WHERE client_email = '".$email."'";
                    $res = $this->_conn->query($sql2);
                    
                    if($res)
                    {
                        return true;
                    }
                }catch(PDOException $ex) {
                    return $ex;
                }
               
            }
        }
        public function regEmail($user_email, $user_name, $user_lastname,$pass)
        {

            $this->_mail->From = "info@sqlprometeo.com";
            $this->_mail->FromName = "Prometeo";
            $this->_mail->addAddress($user_email, $user_name.' '.$user_lastname);
            $this->_mail->addReplyTo("info@sqlprometeo.com", "Responda a");
            $this->_mail->isHTML(true);
            $this->_mail->Subject = "Bienvenido a Prometeo!";
            $this->_mail->Body = "<!DOCTYPE html><head><meta charset='utf-8'></head><body>";
            $this->_mail->Body .= '<div class="wrapper">';
            $this->_mail->Body .= '<div class="logo" style="background-color:#ffcc66;text-align:center;padding:20px 0px;"><img src="http://'.$this->siteURI.'img/logo_ppal.png" alt="">
            <h3>Bienvenido '.$user_name.' '.$user_lastname.'</h3>
            <p>Un placer de tenerte abordo!</p>
            </div>';
            $this->_mail->Body .= '<div class="message">
            <p style="line-height:1.5;">Le informamos que su cuenta ha sido registrada en nuestro portal con los siguientes datos para ingresar
            a nuestro portal:</p>
            <table>
            <tr><td>Correo electronico:</td><td>'.$user_email.'</td></tr>
            <tr><td>Contraseña:</td><td>'.$pass.'</td></tr>
            </table>
            <p>Gracias por registrarse.
            Con el fin de Activar su cuenta haga click en el siguiente botón:</p>
            <div style="text-align:center;padding:30px;"><a href="http://www.sqlprometeo.com/src/controler.php?req=confi&email='.$user_email.'" style="text-decoration:none;margin:auto;width:30%;display:block;background-color:orangered;padding:20px;border:none;border-radius:5px;font-size:18pt;color:white;">Confirmar Email</a></div>
            <p style="line-height:1.5;">
                Una vez confirmado, podra acceder al portal de Prometeo.
            </p>
            <p><b>Importante</b>
            Este correo ha sido enviado automáticamente, favor no responder a esta dirección de correo, ya que no
            se encuentra habilitada para recibir mensajes. Si requiere mayor información sobre el contenido de este
            mensaje, enviar un correo electrónico a <a href="#">info@sqlsoluciones.com</a></p>
            </div>';
            $this->_mail->Body .= '<div class="footer">
                <p style="color:#666;padding:50px 0px;text-align:center;position:absolute;bottom:0;left:0;width:100%;">&copy;2017 Prometeo.</p>
            </div>';
            $this->_mail->Body .= '</div></body></html>';
            
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
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
            $this->sendEmail = $this->getSenderEmail($id = 1);

        }

        //USANDO TABLA prmtros_gnrles
        public function getSenderEmail($id){
            $sql = "SELECT vlor_prmtro_1 FROM prmtros_gnrles WHERE id_prmtro = '".$id."'";
            $res = $this->_conn->query($sql);
            
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                return $row['vlor_prmtro_1'];
            }
        }

        //ENCABESADOS TABLA users_web
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
        public function ReSendRegEmail($email){
            $sql = "SELECT * FROM users_web WHERE client_email = '".$email."'";
            $res = $this->_conn->query($sql);
            
            if($res->rowCount() > 0)
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC)){
                    if($this->regEmail($row['client_email'], $row['client_name'], $row['client_lastname'], $row['client_password']))
                    {
                        return true;
                    }else{
                        return "ERR";
                    }
                    
                }
                
            }else if($res->rowCount() == 0)
            {
                return 'Email not registered';
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
            $this->_mail->addAddress($user_email, $user_name.' '.$user_lastname);
            $this->_mail->addReplyTo($this->sendEmail, "Responda a");
            $this->_mail->isHTML(true);
            $this->_mail->Subject = "Bienvenido a Prometeo!";
            $html = '<!DOCTYPE html>
            <head>
                <meta charset="utf-8">
            </head>
            <body style="'.$bodyStyle.'">
                <div class="logo" style="'.$logoStyles.'">
                    <img style="width:220px;" src="http://'.$this->siteURI.'img/logo_ppal.png" alt="">
                
                </div>
                <div class="wrapper" style="'.$wrapperStyles.'">
                    
                        <div style="'.$messStyles.'">
                            <p style="">
                                Bienvenido '.$user_name.' '.$user_lastname.',<br/><br/>
                                Le informamos que su cuenta ha sido registrada en nuestra
                                plataforma con los siguientes datos de ingreso:
                            </p>
                            
                            <table>
                            <tr><td>Correo electronico:</td><td>'.$user_email.'</td></tr>
                            <tr><td>Contraseña:</td><td>'.$pass.'</td></tr>
                            </table>

                            <p>
                                Gracias por registrarse. Con el fin de Activar su cuenta haga click en el siguiente botón:
                            </p>
                            <div style="text-align:center;padding:20px;">
                                <a href="'.$this->siteURI.'src/controler.php?req=confi&email='.$user_email.'" style="'.$confirmBtnStyle.'">Confirmar Registro</a>
                            </div>
                            <p>Una vez confirmado, podra acceder al portal de Prometeo.</p>

                            
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
            $this->_mail->Body = $html;

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
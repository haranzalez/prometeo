<?php
     require 'src/dbcred.php';
     require_once('src/Log.php');
     require_once('src/Reg.php');
     $login = new Log($db);
     $reg = new Reg($db);
     $conf = (isset($_GET['conf']))?$_GET['conf']:false;
     $email = (isset($_GET['email']))?$_GET['email']:false;

     if($conf && $email)
     {
        $sql = "SELECT * FROM users_web WHERE client_email = '$email' AND client_active = 1 LIMIT 1";
        $result = $db->query($sql);
        
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if(count($row) > 0)
        {
            if($login->login($row['client_email'], $row['client_password']) == "success!"){
                header("Location: http://www.sqlprometeo.com/portal.php");
            }
            
        }else{
            header("Location: http://www.sqlprometeo.com/login.php");
        }
        
     }else{
         echo 'ERROR!';
     }
     

?>


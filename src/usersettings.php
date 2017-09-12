<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    class Usettings{

        public function __construct($db)
        {
            $this->db = $db;
            $this->table = 'users_web';
            $this->nit = (isset($_SESSION['nit']))?$_SESSION['nit']:false;
            $this->email = (isset($_SESSION['email']))?$_SESSION['email']:false;
        }
        public function info_usuario()
        {
            $sql = "SELECT * FROM $this->table WHERE client_cedula = '".$this->nit."'";
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
            if(count($row) > 0)
            {
                $sql2 = "UPDATE $this->table SET client_password = '". $newPass . "' WHERE client_email = '$this->email'";
                $res2 = $this->db->query($sql2);
                if($res2){
                    return true;
                } 
            }else{
                return false;
            }
        }


    }

    





?>
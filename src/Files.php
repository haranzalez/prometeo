<?php 


require_once('../PDF/fpdf.php');
    class Files extends FPDF
    {
        public function __construct($db){
            $this->nit = (isset($_SESSION['nit']))?$_SESSION['nit']:false;
            $this->email = (isset($_SESSION['email']))?$_SESSION['email']:false;
            $this->db = $db;
        }
        
        function return_pdf($doc_id)
        {
            $sql = "SELECT nmbre_pdf FROM usrios_web_mnjo_flders_det WHERE email_usrio = '".$this->email."' AND id_dcmnto = ".$doc_id;
            $res = $this->db->query($sql);
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $result = pg_unescape_bytea($row['nmbre_pdf']);
            return $result;
        }
        function all_pdf(){
            $sql = "SELECT asnto_dcmnto FROM usrios_web_mnjo_flders_det WHERE email_usrio = '".$this->email."'";
            $res = $this->db->query($sql);
            $arr = array();
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if(count($row) > 0)
            {
                while($row){
                    $arr['nombre'] = $row['asnto_dcmnto'].'.pdf';
                }
                return $arr;
            }else{
                $arr['nofiles'] = 'No hay documentos.';
                return $arr;
            }
            
        }
        function check_user()
        {
            $sql = "SELECT COUNT(*) FROM usrios_web_mnjo_flders_enc WHERE email_usrio = '".$this->email."'";
            $res = $this->db->query($sql);
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if($row['count'] != 0)
            {
                return true;
            }else{
                return false;
            }
        }
        
        function check_folder($name)
        {
            $sql = "SELECT COUNT(*) FROM usrios_web_mnjo_flders_enc WHERE nmbre_flder = '".$name."' AND email_usrio = '".$this->email."'";
            $res = $this->db->query($sql);
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if($row['count'] != 0)
            {
                return true;
            }else{
                return false;
            }
        }
        function create_folder($name){
            if(isset($name))
            {
                if($name == 'Bandeja de entrada' && $this->check_folder($name) === false)
                {
                    $bnum = 1;
                    
                    $sql = "INSERT INTO usrios_web_mnjo_flders_enc (email_usrio,
                    nmro_flder,
                    nmbre_flder,
                    nmro_orden)
                    VALUES('".$this->email."',
                    '".$bnum."',
                    'Bandeja de entrada',
                    1)";
                    $res = $this->db->query($sql);
                    if($res)
                    {
                        return true;
                    }
                }else if($this->check_folder($name) === false){
                    
                    $fnum = $this->check_last_folder() + 1;
                    $sql = "INSERT INTO usrios_web_mnjo_flders_enc (email_usrio,
                    nmro_flder,
                    nmbre_flder)
                    VALUES('".$this->email."',
                    '".$fnum."',
                    '".$name."')";
                    $res = $this->db->query($sql);
                    if($res)
                    {
                        return true;
                    }
        
                }else if($this->check_folder($name) === true){
                    return false;
                }
            }
            
            
        }
        function cfolder($name)
        {
            if($this->check_user() === false && isset($name))
            {
                $bnum = 1;
    
                $sql = "INSERT INTO usrios_web_mnjo_flders_enc (email_usrio,
                nmro_flder,
                nmbre_flder,
                nmro_orden)
                VALUES('".$this->email."',
                '".$bnum."',
                'Bandeja de entrada',
                1)";
                $res = $this->db->query($sql);
    
                if($res && $this->check_folder($name) !== true){
                    $fnum = $this->check_last_folder() + 1;
                    $sql = "INSERT INTO usrios_web_mnjo_flders_enc (email_usrio,
                    nmro_flder,
                    nmbre_flder)
                    VALUES('".$this->email."',
                    '".$fnum."',
                    '".$name."')";
                    $res = $this->db->query($sql);
                    if($res)
                    {
                        return true;
                    }
    
                }else if($this->check_folder($name) === true){
                    return 'Folder already exist';
                }
            }else if($this->check_user() === true && isset($name)){
    
                if($this->check_folder($name) !== true){
    
                    $fnum = $this->check_last_folder() + 1;
    
                    $sql = "INSERT INTO usrios_web_mnjo_flders_enc (email_usrio,
                    nmro_flder,
                    nmbre_flder)
                    VALUES('".$this->email."',
                    '".$fnum."',
                    '".$name."')";
                    $res = $this->db->query($sql);
    
                    if($res)
                    {
                        return true;
                    }
    
                }else if($this->check_folder($name) === true)
                {
                    return 'Folder already exist';
                }
               
            }else{
    
                return false;
    
            }
            
           
        }
        function check_last_folder()
        {
            $sql = "SELECT * FROM usrios_web_mnjo_flders_enc WHERE email_usrio = '".$this->email."' order by nmro_orden";
            $res = $this->db->query($sql);
            $arr = array();
            while($row = $res->fetch(PDO::FETCH_ASSOC))
            {
                $arr[] = $row['nmro_flder'];
            }
           
            return max($arr);
        }
        function folder_list()
        {
            $sql = "SELECT * FROM usrios_web_mnjo_flders_enc WHERE email_usrio = '".$this->email."' order by nmro_orden";
            $res = $this->db->query($sql);

            $main = array();
            
            while($row = $res->fetch(PDO::FETCH_ASSOC))
            {
                $main[$row['nmbre_flder']] = array();
                $sqlfi = "SELECT * FROM usrios_web_mnjo_flders_det WHERE email_usrio = '".$this->email."' AND nmro_flder = ".$row['nmro_flder'];
                $resfi = $this->db->query($sqlfi);
                $main[$row['nmbre_flder']]['folder_number'] = ($row['nmbre_flder'] == 'Bandeja de entrada')?1:$row['nmro_flder'];
                while($rowfi = $resfi->fetch(PDO::FETCH_ASSOC))
                {
                    $main[$row['nmbre_flder']][$rowfi['asnto_dcmnto']] = $rowfi['id_dcmnto'] . '_' . $rowfi['fcha_dcmnto'];   
                }
            }
            return $main;
           
        
        }
    
        function del_doc($doc_id)
        {
            $sql = "DELETE FROM usrios_web_mnjo_flders_det WHERE email_usrio = '".$this->email."' AND id_dcmnto = ".$doc_id;
            $res = $this->db->query($sql);
            if($res)
            {
                return true;
            }else{
                return false;
            }
        }
    
        function del_folder($fname)
        {
            $sqlfiles = "DELETE FROM usrios_web_mnjo_flders_det WHERE email_usrio = '".$this->email."' AND nmro_flder = '".$fname."'";
            $resFiles = $this->db->query($sqlfiles);
            if($resFiles)
            {
                $sql = "DELETE FROM usrios_web_mnjo_flders_enc WHERE email_usrio = '".$this->email."' AND nmro_flder = '".$fname."'";
                $res = $this->db->query($sql);
                if($res)
                {
                    return true;
                }else{
                    return false;
                }
    
            }
            
    
        }
        function edit_folder_name($name, $fnum)
        {
            $sql = "UPDATE usrios_web_mnjo_flders_enc SET nmbre_flder = '".$name."' WHERE email_usrio = '".$this->email."' AND nmro_flder = '".$fnum."'";
            $res = $this->db->query($sql);
            if($res){
                return true;
            }else{
                return false;
            }
        }
        function move_file($fnum,$docid){
            $sql = "UPDATE usrios_web_mnjo_flders_det SET nmro_flder = '".$fnum."' WHERE id_dcmnto = '".$docid."' AND email_usrio = '".$this->email."'";
            $res = $this->db->query($sql);
            if($res){
                return true;
            }else{
                return false;
            }
        }
        function encrypt($val)
        {
            return sha1($val);
        }
       
    }

    /*
    select count(*)
INTO:nmro_rgtsros
from usrios_web_mnjo_flders_enc
where email_usrio = '*'
and nmro_flder = 1

if nmro_rgstros = 0 THEN
//gRABO REGISTRO DE BANDEJA ENTRADA
in


select max(nmro_flder)
INTO:nmro_rgstros
from usrios_web_mnjo_flders_enc
where email_usrio = '*';

nmro_flder = nmro_rgstros ++
funtion (nmro_flder,nmbre_flder)

select 


    */

    
    

?>

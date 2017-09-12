<?php 
	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    error_reporting(E_ALL);

    class Doc {

        public function __construct($db){
            include 'dbcred.php';
            $this->_conn = $db;
            $this->_nit = (isset($_SESSION['nit']))?$_SESSION['nit']:false;
            $this->generar_certificadoSQL = '';
            $this->emprsasSQL = '';
            $this->getFieldsSQL = '';
            $this->formatosSQL = '';
            $this->periodosSQL = '';
        }
        private function generar_id($type)
        {
            $y = date('y');
            $m = date('n');
            return $type.$y.$m.rand(100, 1000);
        }
        /*public function vars(){
            echo $this->generar_certificadoSQL.'<br/>';
            echo $this->emprsasSQL.'<br/>';
            echo $this->getFieldsSQL.'<br/>';
            echo $this->formatosSQL.'<br/>';
            echo $this->periodosSQL.'<br/>';
        }*/
        public function emprsas()
        {
            
            if($this->_nit != false)
            {
                $sql = "DROP TABLE if exists tbla_tmpral;";
            	
                $sql .= "CREATE TEMP TABLE tbla_tmpral AS
                SELECT *
                FROM mvmnto_frmto_cncpto
                WHERE id_trcro = '$this->_nit';";

                $sql .= "SELECT DISTINCT 
                b.id_emprsa,
                b.nmbre_rzon_scial,
                B.DRCCION,
                B.WEB_SITE,
                B.CDGO_COLOR,
                b.lgtpo_emprsa
                from tbla_tmpral a,
                emprsas b,
                users_web c
                WHERE a.id_trcro = c.client_cedula
                AND  a.id_emprsa = b.id_emprsa
                AND  c.client_cedula = '$this->_nit'
                AND  b.actvo = 1";

                $this->emprsasSQL = $sql;
                $res = $this->_conn->query($sql);
                
                $arr = array();
                $arrId = array();
                $i = 0;
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    $stream = stream_get_contents($row['lgtpo_emprsa']);
                    $data = substr($stream, 1);
                    $data_final = $data;
                    $row['lgtpo_emprsa'] = $data_final;

                    $sql2 = "SELECT 
                    b.nmbre_pais,   
                    c.nmbre_mncpio,   
                    d.nmbre_cntcto,
                    d.alias_cntcto,
                    d.tlfno_fjo,
                    d.tlfno_mvil,
                    d.email_cntcto
               FROM emprsas a,   
                    paises b,   
                    mncpios c,
                    cntctos_emprsas d
           
              WHERE ( a.cdgo_pais = b.cdgo_pais ) and  
                    ( b.cdgo_pais = c.cdgo_pais ) and  
                    ( a.cdgo_dpto = c.cdgo_dpto ) and  
                    ( a.cdgo_mncpio = c.cdgo_mncpio ) and
                    (a.id_emprsa = d.id_emprsa) AND
                    ( a.id_emprsa = '".$row['id_emprsa']."' )";
                    $res2 = $this->_conn->query($sql2);
                    while($row2 = $res2->fetch(PDO::FETCH_ASSOC)){
                        $row['nmbre_pais'] = $row2['nmbre_pais'];
                        $row['nmbre_mncpio'] = $row2['nmbre_mncpio'];
                        $row['nmbre_cntcto'] = $row2['nmbre_cntcto'];
                        $row['alias_cntcto'] = $row2['alias_cntcto'];
                        $row['tlfno_fjo'] = $row2['tlfno_fjo'];
                        $row['tlfno_mvil'] = $row2['tlfno_mvil'];
                        $row['email_cntcto'] = $row2['email_cntcto'];
                    }
                    $arr[] = $row;
                }

                $result = new stdClass();
                $result->pkg = $arr;
                return $result;

            }else{
                return 'NIT FALSE';
            }
        }
        public function generar_certificado($codigo_formato, $mes_inicial, $mes_final, $nit_empresa)
        {
            try{

                $mv = $this->getFields($nit_empresa);
                $id_emp = $mv['id_emprsa'];
                

                //$sql = "DROP TABLE if exists tbla_tmpral;";
                
                /*$sql = "SELECT *
                FROM mvmnto_frmto_cncpto
                WHERE id_emprsa = $id_emp
                AND id_trcro = '$this->_nit';";*/

                $sql = "SELECT a.id_emprsa,   
                a.nmbre_rzon_scial,   
                a.drccion,   
                a.web_site,
                a.lgtpo_emprsa,
                b.nmbre_pais,      
                c.nmbre_mncpio,   
                d.cdgo_frmto,   
                d.nmbre_frmto,   
                d.enc_frmto,   
                d.pie_frmto,   
                e.ano_mes_incial,   
                e.nmbre_trcro,   
                e.vlor_grvble,
                f.nmbre_cncpto,   
                g.prcntje_aplccion,  
                e.ano_mes_fnal,   
                e.cdgo_cncpto,   
                e.id_trcro   
                FROM emprsas a,   
                paises b,   
                mncpios c,   
                frmtos_dfndos d,   
                mvmnto_frmto_cncpto e,
                cncptos_dfndos f,   
                cncptos_dfndos_prmtros g  
                WHERE ( a.cdgo_pais = b.cdgo_pais ) and  
                ( b.cdgo_pais = c.cdgo_pais ) and  
                ( a.cdgo_dpto = c.cdgo_dpto ) and  
                ( a.cdgo_mncpio = c.cdgo_mncpio ) and  
                ( a.id_emprsa = d.id_emprsa ) and  
                ( e.id_emprsa = a.id_emprsa ) and  
                ( e.cdgo_frmto = d.cdgo_frmto ) and  
                ( e.id_emprsa = f.id_emprsa ) and  
                ( e.cdgo_cncpto = f.cdgo_cncpto ) and  
                ( e.id_emprsa = g.id_emprsa ) and  
                ( e.cdgo_cncpto = g.cdgo_cncpto ) and   
                ( f.id_emprsa = g.id_emprsa ) and  
                ( f.cdgo_cncpto = g.cdgo_cncpto ) and  
                ( a.id_emprsa = $nit_empresa ) AND  
                ( d.cdgo_frmto = $codigo_formato ) AND  
                ( e.ano_mes_incial = '$mes_inicial' ) AND  
                ( e.ano_mes_fnal = '$mes_final' ) AND  
                (e.id_trcro = '$this->_nit' );";
                 
                $this->generar_certificadoSQL = $sql;
                $res = $this->_conn->query($sql);
                $arr = array();
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    $stream = stream_get_contents($row['lgtpo_emprsa']);
                    $row['lgtpo_emprsa'] = substr($stream, 1);
                    $arr[] = $row;
                }
                return $arr;

            }catch (Exception $e) {
                return 'Err(generar_certificado): '.  $e->getMessage(). "\n";
            }
            
        }
        public function getFields($cedula){
            try{
                $sql = "SELECT * FROM mvmnto_frmto_cncpto WHERE id_trcro = $cedula::varchar";
                $this->getFieldsSQL = $sql;
                $res = $this->_conn->query($sql);
                return $res->fetch(PDO::FETCH_ASSOC);
            }catch(Exception $e){
                return 'Err(getFields): '.  $e->getMessage(). "\n";
            }
            
        }
        public function periodos($id_empresa, $codigo_formato)
        {
            try{
                $sql = "DROP TABLE if exists tbla_tmpral;";
                $sql .= "CREATE TEMP TABLE tbla_tmpral AS
                SELECT *
                FROM mvmnto_frmto_cncpto
                WHERE id_emprsa = $id_empresa;";
                $sql .= "SELECT DISTINCT a.ano_mes_incial, a.ano_mes_fnal  
                FROM tbla_tmpral a WHERE a.id_emprsa = $id_empresa AND a.cdgo_frmto = $codigo_formato";
                $this->periodosSQL = $sql;
                $res = $this->_conn->query($sql);

                $arr = array();
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) 
                {
                    $arr[] = $row;
                }
                return $arr;
            }catch(Exception $e){
                return 'Err(periodos): '.  $e->getMessage(). "\n";
            }
        }
        public function formatos($id){

            try{
                $sql = "DROP TABLE if exists tbla_tmpral;";
                $sql .= "CREATE TEMP TABLE tbla_tmpral AS
                SELECT *
                FROM mvmnto_frmto_cncpto
                WHERE id_emprsa = $id
                AND id_trcro = '$this->_nit';";

                $sql .= "SELECT DISTINCT a.cdgo_frmto,
                b.nmbre_frmto,
                a.id_emprsa
                FROM tbla_tmpral  a,
                frmtos_dfndos b
                WHERE a.id_emprsa = b.id_emprsa
                AND  a.cdgo_frmto = b.cdgo_frmto
                AND  a.id_trcro = '$this->_nit'
                AND  a.id_emprsa = $id
                AND  b.actvo = 1";
                $this->formatosSQL = $sql;
                $res = $this->_conn->query($sql);

                $arr = array();
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    $arr[] = $row;
                }
                return $arr;
                
            }catch(Exception $e){
                return 'Err(periodos): '.  $e->getMessage(). "\n";
            }
            
        }
        
       
        
    }
    


?>

<?php 


    /* periodos: drop table tbla_tmpral; 
 CREATE TEMP TABLE tbla_tmpral AS
    SELECT *
	FROM mvmnto_frmto_cncpto
	WHERE id_emprsa = 900320471;

SELECT DISTINCT A.ano_mes_incial,   
         					A.ano_mes_fnal  
    FROM tbla_tmpral  a
   WHERE ( a.id_emprsa = 900320471 ) AND  
         ( a.cdgo_frmto = 1 )
    ;
    ;*/

    /* formatos: CREATE TEMP TABLE tbla_tmpral AS
    SELECT *
	FROM mvmnto_frmto_cncpto
	WHERE id_emprsa = 900320471
	   AND id_trcro = '93368231';


SELECT DISTINCT a.cdgo_frmto,
		  b.nmbre_frmto
FROM tbla_tmpral  a,
		frmtos_dfndos b,
		users_web c
WHERE a.id_trcro = c.client_cedula
   AND  a.id_emprsa = b.id_emprsa
   AND  a.cdgo_frmto = b.cdgo_frmto
   AND  a.id_emprsa = 900320471
   AND  c.client_cedula = '93368231'
   AND  b.actvo = 1
;*/

/* empresas vinculadas: CREATE TEMP TABLE tbla_tmpral AS
    SELECT *
	FROM mvmnto_frmto_cncpto
	WHERE id_trcro = '93368231';


SELECT DISTINCT b.id_emprsa,
		   b.nmbre_rzon_scial,
		   B.DRCCION,
		   B.WEB_SITE,
		   B.CDGO_COLOR
from	    tbla_tmpral a,
			emprsas b,
			users_web c
WHERE a.id_trcro = c.client_cedula
   AND  a.id_emprsa = b.id_emprsa
   AND  c.client_cedula = '93368231'
   AND  b.actvo = 1
; */

/*certificado: DROP TABLE tbla_tmpral;

 CREATE TEMP TABLE tbla_tmpral AS
    SELECT *
	FROM mvmnto_frmto_cncpto
	WHERE id_emprsa = 900320471
	   AND id_trcro = '800197268';


SELECT 	a.id_emprsa,   
                a.nmbre_rzon_scial,   
                a.drccion,   
                a.web_site,
                b.nmbre_pais,      
                c.nmbre_mncpio,   
                d.cdgo_frmto,   
                d.nmbre_frmto,   
                d.enc_frmto,   
                d.pie_frmto,   
                e.ano_mes_incial,   
                e.nmbre_trcro,   
                e.vlor_grvble,
                f.nmbre_cncpto,   
                g.prcntje_aplccion,  
                e.ano_mes_fnal,   
                e.cdgo_cncpto,   
                e.id_trcro   
                FROM emprsas a,   
                paises b,   
                mncpios c,   
                frmtos_dfndos d,   
                tbla_tmpral e,
                cncptos_dfndos f,   
                cncptos_dfndos_prmtros g  
                WHERE (e.id_emprsa = a.id_emprsa) AND 
						 (a.cdgo_pais = b.cdgo_pais) AND  
                			(a.cdgo_pais = c.cdgo_pais) AND  
			              (a.cdgo_dpto = c.cdgo_dpto) AND  
                			(a.cdgo_mncpio = c.cdgo_mncpio) AND
						(e.id_emprsa = d.id_emprsa) AND
						(e.cdgo_frmto = d.cdgo_frmto) AND     
						(e.id_emprsa = f.id_emprsa) AND  
                            (e.cdgo_cncpto = f.cdgo_cncpto) AND  
		                  (e.id_emprsa = g.id_emprsa) AND
                			(e.cdgo_cncpto = g.cdgo_cncpto)  AND
                			((e.id_emprsa = 900320471) AND 
                			(e.cdgo_frmto = 1) AND  
                			(e.ano_mes_incial = '2016-01') AND  
                			(e.ano_mes_fnal = '2016-12') AND  
                			(e.id_trcro = '800197268'));*/



?>






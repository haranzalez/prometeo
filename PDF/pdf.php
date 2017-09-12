<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
ob_start();

include '../src/dbcred.php';

require_once('fpdf.php');
require_once('../src/Doc.php');



class PDF extends FPDF
{

   
    protected $col = 0; 
    protected $y0;      

    public function __construct($formato, $mesini, $mesfin, $id_empresa)
    {
        include '../src/dbcred.php';
        $orientation='P'; $unit='mm'; $format='A4';
        parent::__construct($orientation,$unit,$format);
        $this->title = '';
        $this->db = $db;
        $this->nit = (isset($_SESSION['nit']))?$_SESSION['nit']:false;
        $this->email = (isset($_SESSION['email']))?$_SESSION['email']:false;
        $this->formato = (isset($formato))?$formato:null;
        $this->mesini = (isset($mesini))?$mesini:null;
        $this->mesfin = (isset($mesfin))?$mesfin:null;
        $this->id_empresa = (isset($id_empresa))?$id_empresa:null;
        $this->docClass = new Doc($this->db);
        $this->data_certificate = ($this->data_certificate() != false)?$this->data_certificate():array();
        $this->notaY = 165;
    }
    private function generar_id($type)
    {
        $y = date('y');
        $m = date('n');
        return $type.$y.$m.rand(100, 1000);
    }
    function fecha_de_hoy()
    {
        $y = date('Y');
        $m = date('m');
        $d = date('d');
        return $m.'/'.$d.'/'.$y;
    }
    function doc_out($type='pdf')
    {
        if($type == 'pdf')
        {
            if(count($this->data_certificate) >= 1)
            {
                $this->SetMargins(20, 10, 20);
                $this->AddPage();
                $this->title = 'CERTIFICADO DE '.$this->data_certificate[0]['nmbre_frmto'].' ANO GRAVABLE '.substr($this->data_certificate[0]['ano_mes_fnal'],0,4);
                $this->SetTitle($this->title);
                $this->logo();
                $this->Header();
                $this->emDate();
                $this->companyDetails();
                $this->tabla1();
                $this->tabla2();
                $this->nota();
                $raw = $this->Output('S');
                return $raw;
            }else if(count($this->data_certificate) == 0){
               echo "Se a producido un error<br/>Ref: doc_out()";
            }

        }
        
        

    }
    function messages($type){

    }
    function data_certificate()
    {
        if($this->formato == null && $this->mesini == null && $this->mesfin == null)
        {
            return false;
        }else{
            return $this->docClass->generar_certificado($this->formato, $this->mesini, $this->mesfin, $this->id_empresa);
        }
        
    }
    function logo()
    {
        if(isset($_POST['img']))
        {
            $d = $_POST['img'];
           
            $w = 20; $h = 13;
            $raw = base64_decode($d);
            $file = $_SERVER['DOCUMENT_ROOT'] . '/PDF/temp/'.rand() . '.jpeg';
            $success = file_put_contents($file, $raw);
            $this->Image($file,$w,$h,50,40);
            unlink($file);
        }
        
        
    }
    function vars(){
        echo $this->title . '<br/>';
        echo '<br/>';
        var_dump($this->db);
        echo '<br/>';
        echo '<br/>';
        echo $this->nit.'</br>';
        echo '<br/>';
        echo $this->formato.'<br/>';
        echo '<br/>';
        echo $this->mesini.'<br/>';
        echo '<br/>';
        echo $this->mesfin.'<br/>';
        echo '<br/>';
        var_dump($this->docClass);
        echo '<br/>';
        echo '<br/>';
        var_dump($this->data_certificate);
    }
    function guardar_certificado($folder_name)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/promTest/PDF/documents/';
        $path = (isset($folder_name) && $folder_name != null && $folder_name != 'null')?$dir.$this->nit.'/'.$folder_name:$dir.$this->nit;
        if(is_dir($path)) {
            $file = $this->data_certificate[0]['nmbre_frmto'].'_'.$this->generar_id('D');
            $this->SetMargins(20, 10, 20);
            $this->AddPage();
            $this->title = 'CERTIFICADO DE '.$this->data_certificate[0]['nmbre_frmto'].' ANO GRAVABLE '.substr($this->data_certificate[0]['ano_mes_fnal'],0,4);
            $this->SetTitle($this->title);
            $this->logo();
            $this->Header();
            $this->emDate();
            $this->companyDetails();
            $this->tabla1();
            $this->tabla2();
            $this->nota();
            $raw = $this->Output('S');
            $save = file_put_contents($path.'/'.$file.'.pdf', $raw);
            return $file.'.pdf';
        }else{
            mkdir($path);
            $file = $this->data_certificate[0]['nmbre_frmto'].'_'.$this->generar_id('D');
            $this->SetMargins(20, 10, 20);
            $this->AddPage();
            $this->title = 'CERTIFICADO DE '.$this->data_certificate[0]['nmbre_frmto'].' ANO GRAVABLE '.substr($this->data_certificate[0]['ano_mes_fnal'],0,4);
            $this->SetTitle($this->title);
            $this->logo();
            $this->Header();
            $this->emDate();
            $this->companyDetails();
            $this->tabla1();
            $this->tabla2();
            $this->nota();
            $raw = $this->Output('S');
            $save = file_put_contents($path.'/'.$file.'.pdf', $raw);
            return $file.'.pdf';
        }
    }
    
    
    function Header()
    {
        // Page header
        
        global $subTitle;
        $this->SetY(55);
        $this->SetFont('Arial','B',15);
        $w = $this->GetStringWidth($this->title)-6;
        $this->SetX((250-$w)/2);

        $this->MultiCell(130,6,$this->title,0,'C');
        
        $this->Ln(10);
        // Save ordinate
        $this->y0 = $this->GetY();
    }
    function emDate()
    {
        $this->SetY(65);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(3,3,3);
        $this->Cell(0,10,'Fecha Emision '.$this->fecha_de_hoy(),0,0,'C');
    }
    function companyDetails()
    {
        $x = 100;
        $this->SetY(21);
        $this->SetX($x);
        
        $this->SetFont('Arial','B',11);
        $this->SetTextColor(3,3,3);
        $this->Cell(0,10,utf8_decode($this->data_certificate[0]['nmbre_trcro']),0,0,'C',false);
        $this->Ln(5);
        $this->SetX($x);
        $this->Cell(0,10,'NIT:'.number_format($this->data_certificate[0]['id_emprsa']),0,0,'C',false);
        $this->Ln(5);
        $this->SetX($x);
        $this->SetFont('Arial','',11);
        $this->Cell(0,10,$this->data_certificate[0]['drccion'],0,0,'C',false);
        $this->Ln(5);
        $this->SetX($x);
        $this->Cell(0,10,'Telefonos: 4447292',0,0,'C',false);
        $this->Ln(5);
        $this->SetX($x);
        $this->Cell(0,10,$this->data_certificate[0]['nmbre_mncpio'].', '.$this->data_certificate[0]['nmbre_pais'],0,0,'C',false);
        $this->Ln(5);
        $this->SetX($x);
        $this->Cell(0,10,$this->data_certificate[0]['web_site'],0,0,'C',false);
        
    }
    function tabla1()
    {
        try{
        $this->SetY(80);
        $this->SetFont('Arial','B',9);
        $this->SetTextColor(3,3,3);
        $this->SetDrawColor(180,180,180);
        $this->cell(0,10,'Retencion practicada a:',0,0,'L',false);
        
        $this->Ln();
        $this->cell(83,6,'Razon Social:','B');
        $this->SetFont('Arial','',9);
        $this->cell(83,6,utf8_encode($this->data_certificate[0]['nmbre_trcro']),'B');
        $this->Ln();
        $this->SetFont('Arial','B',9);
        $this->cell(83,6,'NIT:','B');
        $this->SetFont('Arial','',9);
        $this->cell(83,6,number_format($this->data_certificate[0]['id_emprsa']),'B');
        
    }catch(PDOException $ex) {
        print_r($db->errorInfo());
    }
         

        
    }
    function tabla2()
    {
        // Header
        $header = array('Concepto', 'Tasa', 'Base', 'Retencion');
        $data = array();
        if(count($this->data_certificate) > 1)
        {
            for ($i=0; $i < count($this->data_certificate); $i++) { 
                $data[] = $this->data_certificate[$i]['nmbre_cncpto'];
                $data[] = $this->data_certificate[$i]['prcntje_aplccion'].'%';
                $data[] = ($this->data_certificate[$i]['vlor_grvble'] * $this->data_certificate[$i]['prcntje_aplccion'])/100;
                $data[] = $this->data_certificate[$i]['vlor_grvble'];
            }
        }else if(count($this->data_certificate) == 1){
            $data['nombre'] = $this->data_certificate[0]['nmbre_cncpto'];
            $data['porce'] = $this->data_certificate[0]['prcntje_aplccion'].'%';
            $data['val1'] = ($this->data_certificate[0]['vlor_grvble'] * $this->data_certificate[0]['prcntje_aplccion'])/100;
            $data['val2'] = $this->data_certificate[0]['vlor_grvble'];
        }
        
        $this->SetY(102);
        $this->SetFont('Arial','',10);
        $this->SetTextColor(3,3,3);
        $this->SetDrawColor(180,180,180);
        $this->Cell(0,10,'Por los conceptos que se detallan a continuacion:',0,0,'L',false);
        $this->Ln();
        $headerCellWidth = array(83,28,28,27);
        $j = 0;
        foreach($header as $col)
        {
            $this->SetFont('Arial','B',10);
            $this->SetFillColor(200,200,200);
            $this->Cell($headerCellWidth[$j],7,$col,1,0,'L',true);
            $j++;
        }
        $this->Ln();
        $this->SetFont('Arial','',10);

      
        $j = 0;
        $i = 0;
        $n  = 0;
        $val1 = array();
        $val2 = array();
    
       foreach ($data as $key => $value) {
        if(count($this->data_certificate) == 1){
            if($key == 'nombre'){
            $this->Cell(83,6,$value,0);
            }else if($key == 'porce'){
            $this->Cell(28,6,$value,0);
            }else if($key == 'val1'){
            $val1[] = $value;
            $this->Cell(28,6,number_format($value, 2, ',', ','),0);
            }else if($key == 'val2'){
            $val2[] = $value;
            $this->Cell(27,6,number_format($value, 2, ',', ','),0);
            }
        }else if(count($this->data_certificate) > 1)
        {
            if($i > 3){
                $this->Ln();
                $i = 0;
            }
            if(is_numeric($value)){
                if ($j % 2 == 0){
                    $val1[] = $value;
                }else{
                    $val2[] = $value;
                }
                
                $this->Cell($headerCellWidth[$i],6,number_format($value, 2, ',', ','),0);
            }else{
                $this->Cell($headerCellWidth[$i],6,$value,0);
            }

        }
        $j++;
        $i++;
          
          
       }

         
             
        $totalBase = array_sum($val1);
        $totalRete = array_sum($val2);
             
       
        
        
        
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(111,6,'TOTAL:','T',0,'R');
        $this->SetFont('Arial','',10);
        $this->Cell(28,6, number_format($totalBase, 2, ',', ','),'T');
        $this->Cell(28,6,number_format($totalRete, 2, ',', ','),'T');
        $this->Ln();
    }
    function nota()
    {
        $subject = $this->data_certificate[0]['pie_frmto'];
        $pattern = '/(\d{2})\/(\d{2})\/(\d{4})/';
        preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 3);
        $txt = str_replace($matches[0][0], $this->fecha_de_hoy(), $subject);;
        $this->SetY($this->notaY);
        $this->SetFont('Arial','',10);
        $this->SetTextColor(3,3,3);
        $this->MultiCell(0,5,$txt,0,'J',false);
        $this->Ln();
       
    }

    function Footer()
    {
        // Page footer
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(128);
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }

    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        $x = 10+$col*65;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        // Method accepting or not automatic page break
        if($this->col<2)
        {
            // Go to next column
            $this->SetCol($this->col+1);
            // Set ordinate to top
            $this->SetY($this->y0);
            // Keep on page
            return false;
        }
        else
        {
            // Go back to first column
            $this->SetCol(0);
            // Page break
            return true;
        }
    }

    function guardar_en_db($fname)
    {
        try{


            $file = $this->data_certificate[0]['nmbre_rzon_scial'].'_'.$this->data_certificate[0]['nmbre_frmto'].'.pdf';
            if($this->check_file($fname) === false)
            {
                $this->SetMargins(20, 10, 20);
                $this->AddPage();
                $this->title = 'CERTIFICADO DE '.$this->data_certificate[0]['nmbre_frmto'].' ANO GRAVABLE '.substr($this->data_certificate[0]['ano_mes_fnal'],0,4);
                $this->SetTitle($this->title);
                $this->logo();
                $this->Header();
                $this->emDate();
                $this->companyDetails();
                $this->tabla1();
                $this->tabla2();
                $this->nota();
                
                $raw = pg_escape_bytea($this->Output('S'));
    
                $sql = "INSERT INTO usrios_web_mnjo_flders_det
                (email_usrio,
                nmro_flder,
                asnto_dcmnto,
                fcha_dcmnto,
                nmbre_pdf )
                VALUES ('".$this->email."',
                '".$fname."',
                '".$file."',
                '".$this->fecha_de_hoy()."',
                '".$raw."')";
                $res = $this->db->query($sql);
    
                if($res)
                {
                    return $file;
                }else{
                    return false;
                }
            }else{
                // $pieces = explode('.', $file);
                // $file = $pieces[0].'_'.rand().'.'.$pieces[1];
                $this->SetMargins(20, 10, 20);
                $this->AddPage();
                $this->title = 'CERTIFICADO DE '.$this->data_certificate[0]['nmbre_frmto'].' ANO GRAVABLE '.substr($this->data_certificate[0]['ano_mes_fnal'],0,4);
                $this->SetTitle($this->title);
                $this->logo();
                $this->Header();
                $this->emDate();
                $this->companyDetails();
                $this->tabla1();
                $this->tabla2();
                $this->nota();
    
                $raw = pg_escape_bytea($this->Output('S'));
    
                $sql = "INSERT INTO usrios_web_mnjo_flders_det
                (email_usrio,
                nmro_flder,
                asnto_dcmnto,
                fcha_dcmnto,
                nmbre_pdf )
                VALUES ('".$this->email."',
                '".$fname."',
                '".$file."',
                '".$this->fecha_de_hoy()."',
                '".$raw."')";
                $res = $this->db->query($sql);
    
                if($res)
                {
                    return $file;
                }else{
                    return false;
                }
            }
            
        }catch(Exception $e){
            return 'Err(guardar_en_db): '.  $e->getMessage(). "\n";
        }
        
    }
    function check_file($fname)
    {
        $sql = "SELECT COUNT(*) FROM usrios_web_mnjo_flders_enc WHERE email_usrio = '".$this->email."' AND nmbre_flder = '".$fname."'";
        $res = $this->db->query($sql);
        $row = $res->fetch(PDO::FETCH_ASSOC);
        if($row['count'] != 0)
        {
            return true;
        }else{
            return false;
        }
    }
    
    
    

    
      

   

}

/*$pdf = new PDF('1','2016-01', '2016-12');
$pdf->vars();
echo '<br/>';
$pdf->docClass->vars();*/
   



?>
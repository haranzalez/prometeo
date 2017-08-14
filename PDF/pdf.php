<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
ob_start();

include '../src/dbcred.php';
require('fpdf.php');
include '../src/Doc.php';



class PDF extends FPDF
{

   
    protected $col = 0; 
    protected $y0;      

    public function __construct($formato, $mesini, $mesfin)
    {
        $orientation='P'; $unit='mm'; $format='A4';
        parent::__construct($orientation,$unit,$format);
        $this->title = '';
        $this->db = new PDO('pgsql:host=localhost;dbname=prometeo;', 'hans', 'prometeodb');
        $this->nit = $_SESSION['nit'];
        $this->formato = $formato;
        $this->mesini = $mesini;
        $this->mesfin = $mesfin;
        $this->docClass = new Doc($this->db);
        $this->data_certificate = $this->data_certificate();
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
        return $d.'/'.$m.'/'.$y;
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
                $this->Output();
            }else if(count($this->data_certificate) == 0){
               echo "Perdona la molestia, pero se a producido un error generando su certificado. El administrador ya ah sido notificado. Porfavor trate de nuevo mas tarder. Gracias por su paciencia.";
            }

        }
        
        

    }
    function messages($type){

    }
    function data_certificate()
    {
        $fields = $this->docClass->getFields($this->nit);
        return $this->docClass->generar_certificado($this->formato, $this->mesini, $this->mesfin);
    }
    function logo()
    {
        $d = $_POST['img'];
        $w = 20; $h = 25;
        $raw = base64_decode($d);
        $file = $_SERVER['DOCUMENT_ROOT'] . '/promTest/PDF/temp/'.rand() . '.jpeg';
        $success = file_put_contents($file, $raw);
        $this->Image($file,$w,$h);
        unlink($file);
    
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
        $this->Cell(0,10,$this->data_certificate[0]['nmbre_rzon_scial'],0,0,'C',false);
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
        $this->cell(83,6,$this->data_certificate[0]['nmbre_rzon_scial'],'B');
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
        $header = array('Concepto', 'Taza', 'Base', 'Retencion');
        $data = array();
        if(count($this->data_certificate) > 1)
        {
            for ($i=0; $i < count($this->data_certificate); $i++) { 
                $data[] = strtolower($this->data_certificate[$i]['nmbre_cncpto']);
                $data[] = $this->data_certificate[$i]['prcntje_aplccion'].'%';
                $data['val1'] = number_format(($this->data_certificate[$i]['vlor_grvble'] * $this->data_certificate[$i]['prcntje_aplccion'])/100);
                $data['val2'] = number_format($this->data_certificate[$i]['vlor_grvble']);
             }
        }else if(count($this->data_certificate) == 1){
            $data[] = strtolower($this->data_certificate[0]['nmbre_cncpto']);
            $data[] = $this->data_certificate[0]['prcntje_aplccion'].'%';
            $data[] = number_format(($this->data_certificate[0]['vlor_grvble'] * $this->data_certificate[0]['prcntje_aplccion'])/100);
            $data[] = number_format($this->data_certificate[0]['vlor_grvble']);
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
           
        // Data
        $i = 0;
        $val1 = array();
        $val2 = array();
        foreach($data as $key => $row)
        {
           if($i <= 3)
           {
                if($key == "val1"){
                    $val1[] = str_replace(',', '', $row); 
                }else if($key == "val2"){
                    $val2[] = str_replace(',', '', $row);
                }  
               $this->Cell($headerCellWidth[$i],6,$row,0);
               $i++;
           }else{
               if($i >= 3){
                 $this->Ln();
               }
               if($key == "val1"){
                    $val1[] = str_replace(',', '', $row); 
                }else if($key == "val2"){
                    $val2[] = str_replace(',', '', $row);
                }  
            
               $i = 0;
               $this->Cell($headerCellWidth[$i],6,$row,0);
               $i++;
           }
        }
        if(count($data) > 4){
            
            $totalBase = array_sum($val1);
            $totalRete = array_sum($val2);
            
        }else{
            $totalBase = (str_replace( ',', '', $data[2]));
            $totalRete = (str_replace( ',', '', $data[3]));
        }
        
        
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(111,6,'TOTAL:','T',0,'R');
        $this->SetFont('Arial','',10);
        $this->Cell(28,6,number_format($totalBase),'T');
        $this->Cell(28,6,number_format($totalRete),'T');
    }
    function nota()
    {
        $subject = $this->data_certificate[0]['pie_frmto'];
        $pattern = '/(\d{2})\/(\d{2})\/(\d{4})/';
        preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 3);
        $txt = str_replace($matches[0][0], $this->fecha_de_hoy(), $subject);;
        $this->SetY(145);
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

    
      

   

}

/*$pdf = new PDF('1','2016-01', '2016-12');
$pdf->vars();
echo '<br/>';
$pdf->docClass->vars();*/
   



?>
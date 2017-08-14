<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    class Files
    {
        public function __construct(){
            $this->nit = $_SESSION['nit'];
            $this->dir = $_SERVER['DOCUMENT_ROOT'] . '/promTest/PDF/documents/'.$this->nit;
            $this->file_list = $this->read_files();
        }
        private function read_files(){
            $pkg = array();
            $pkg['nit'] = $this->nit;
            $files_main = scandir($this->dir);
            unset($files_main[0]);
            unset($files_main[1]);
            if(count($files_main) == 0){
                $pkg['nofiles'] = 'No hay documentos';
                return $pkg;
            }else{
                $pkg['files_main'] = $files_main;
                $i = 0;
                foreach($files_main as $file)
                {
                    $f = substr($file, -4);
                    if($f[0] != '.'){
                        $name = 'file_'.$i;
                        $arr = array();
                        $fh = opendir($this->dir.'/'.$file);
                        $arr['folder'] = $file; 
                        while($row = readdir($fh)) 
                        {
                            if($row == '.' || $row == '..'){
                                continue;
                            }else{
                                $arr[] = $row;
                            }
                        }
                    }
                    if(isset($name))
                    {
                        $pkg[$name] = $arr;
                    }
                    $i++;
                }
                return $pkg;
            }
        }
        public function del_file($file)
        {
            $fh = fopen($this->dir.'/'.$file, 'w');
            fclose($fh);
            unlink($file);
        }
        public function new_dir($name)
        {
            mkdir($this->dir.'/'.$name);
            return 1;
        }
        public function open_dir($dir_name)
        {
            $files = scandir($this->dir.'/'.$dir_name);
            unset($files[0]);
            unset($files[1]);
            
            $pkg = new stdClass;
            $pkg->nit = $this->nit;
            $pkg->files = $files;
            return $pkg;
        }
    }

    

    
    

?>

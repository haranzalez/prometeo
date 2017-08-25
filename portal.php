<?php 
    session_start();
    if(isset($_GET['logout']))
    {
        global $user;
        $users = $_SESSION["user"];
        unset($_SESSION["user"], $_SESSION["user_full_name"], $_SESSION["sess"], $_SESSION['timestamp'], $_SESSION['email']);
        
    }
   
    if(!isset($_SESSION['user']) && !isset($_SESSION['sess']))
    {
       
       $destination = 'login.php?user='.$users;
       header("Location: ".$destination);
       exit;
    }
    $user = (isset($_SESSION['user_full_name']))?$_SESSION['user_full_name']:'Uknown';
    $nit = (isset($_SESSION['nit']))?$_SESSION['nit']:'Uknown';
    

    

?>
<?php include 'includes/header.inc.php';?>
<link rel="stylesheet" href="css/portal.css">
<style>
body {
     background-color: #FFCC66;
     font-size:9pt !important;
 }
</style>
</head>

<body>
    
    <!-- CREAR FOLDER MODAL -->    
    <!-- SELECT FOLDER MODAL -->
    <div id="formDialog">
        <form>
            <fieldset>
            </fieldset>
        </form>
    </div>
    <!-- MODAL CONFIMACION CERTIFICADO GUARDADO -->
    <div id="dialog-message" > 
    </div>
    <!-- MODAL CONFIRMACION ARCHIVO O FOLDER BORRADO -->
    <div id="dialogo_confirmacion" title="ESTAS SEGURO?">
        <p><span class="fa fa-warning" style="float:left; margin: 20px 0;font-size:28pt;color:#FDB813;"></span><spam class="confirmacion_mensaje"></spam></p>
    </div>

    
    <div class="headerPortal">
        <div class="row">
            <div class="col-md-12 logo_corporativo"></div>
            <div class="col-md-10"><img class="logoPortal" src="img/logo_ppal.png" alt=""></div>
            <div class="col-md-2 slogan"><p><b>SQL Soluciones Informaticas SAS</b><br/> Tel: 524 24 36 <br/>Email: info@sqlprometeo.com <br/>www.sqlprometeo.com</p></div>
        </div>
    </div>


<!-- CERTIFICADO -->
<div class="certificado">

    <div class="col-md-6 cert_logo_container"><img class="logo_certificado" style="width:150px;" src="http://placehold.it/120x80" alt=""></div>
    <div class="col-md-6 detalles_empresa">
        <p>
            <spam class="certificado_nombre_empresa" style="text-transform: uppercase;font-weight: 800;"></spam><br/>
            NIT: <spam class="certificado_nit_empresa" style="font-weight: 700;"></spam><br/>
            <spam class="certificado_direccion_empresa"></spam><br/>
            <spam class="certificado_ciudad_empresa"></spam>
        </p>
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-md-12 certificado_formato"></div>
    </div>
    <div class="row">
        <div class="col-md-12 certificado_fecha_emicion"></div>
    </div>
    <h4>Pretencion practicada a:</h4>
    <div class="tabla1">
        <div class="row" >
            <div class="col-md-6" style="font-weight:500;"><p style="margin:0px !important;">Nombre Razon Social:</p></div>
            <div class="col-md-6"><p class="certificado_nombre_empresa"></p></div>
        </div>
        <div class="row">
            <div class="col-md-6" style="font-weight:500;"><p style="margin:0px !important;">NIT:</p></div>
            <div class="col-md-6"><p class="certificado_nit_empresa"></p></div>
        </div>
    </div>
    <p>Por los conceptos que se detallan a continuacion:</p>
    <div class="tabla2">

        <div class="row headings" style="background-color:#ccc;font-weight:800;padding:0px 10px !important;">
            <div class="col-md-6" style="text-align:center;">Concepto</div>
            <div class="col-md-2" style="text-align:right;">Tasa %</div>
            <div class="col-md-2" style="text-align:right;">Base</div>
            <div class="col-md-2" style="text-align:right;">Retencion</div>
        </div>

        <div class="row" style="border-top:1px solid #ccc;padding:0px 10px !important;">
            <div class="col-md-8" style="text-align:right;font-weight:800;">TOTAL: </div>
            <div class="col-md-2 certificado_total_base" style="padding:0px; text-align:right;"></div>
            <div class="col-md-2 certificado_total_retencion" style="padding:0px;text-align:right;"></div>
        </div>
    </div>
    <p class="certificado_footer" style="padding-top:20px;">Lorem ipsum dolor sit amet, consectetur adipisicingolestiaquidem, inventore accusamus nulla eos quos illo unde voluptates incidunt aliquid ad, ex cum fuga ea, nobis officia rerum. Odio, nam.</p>


</div>           
<!-- CERTIFICADO -->

    <div class="wrapper">
       
        <div class="main row">
        <div class="loadingCtn"><div class="loading"></div></div>
            <!-- SIDE BAR -->
            <div class="sideBar col-md-2">

                <div class="row">
                    
                    <div class="col-md-12" style="font-size:8pt;">
                        <div style="padding:20px; color:#444;">
                            <h5 style="color:#222;font-size:14pt;"><i style="font-size:17pt;" class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $user; ?></h5>
                            <p style="padding-left:33px;">ID: <?php echo $nit; ?></p>
                        </div>
                        
                    </div>
                </div>

                <ul class="cPannel">
                <li><a href="#" class="portalNavDocBtn" data-nav="2" data-empresa="documents" ><i class="fa fa-files-o" aria-hidden="true"></i>  Manejo de documentos</a></li>
                <li><ul class="folderlist" style="list-style:none;"></ul></li>
                <li><a href="#" class="portalNavEmpBtn" data-nav="1" data-empresa="empVinculadas"><i class="fa fa-building" aria-hidden="true"></i>  Empresas vinculadas</a></li>
                <li><a href="#" class="portalNavEmpBtn" data-nav="1" data-empresa="empVinculadas"><i class="fa fa-certificate" aria-hidden="true"></i>  Generar Certificado</a></li>
                <li><a href="#" class="portalNavPqrsBtn"><i class="fa fa-question-circle" aria-hidden="true"></i>  PQRS</a></li>
                </ul>
               
                 <ul class="cPannelBottom">
                    <li><a href="#" class="portalNavCambiarDatosBtn"><i class="fa fa-id-card-o" aria-hidden="true"></i>  Cambiar datos</a></li>
                    <li><a href="portal.php?logout=true" class="logOutBtn"><i class="fa fa-power-off" aria-hidden="true"></i>  Salir</a></li>
                </ul>

            </div>
            <!-- SIDE BAR ENDS -->
            
            <div class="dash col-md-10">
            
            <div class="cambiarDatosFormCtnr"></div>

            <div class="empresas_contenedor"><h4 class="secTitle" style="color:#ccc;">Empresas Vinculadas</h4><div class="empRowCtnr"></div></div>

            <div class="fileContainer"><div class="filesLoading"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span></div></div>
            </div>
            <div class="documentos">
                
                <div class="btn-group">
               
                </div>
            </div>

        </div>
             
    </div>

    <footer style="text-align: center; padding:30px 0px;width:50%;margin:auto;">
            <p style="color: #fcb72d">&copy;2017 Prometeo. Todos los derechos reservados.</p>
    </footer>
    <?php include 'includes/footer.inc.php';?>

</body>

</html>
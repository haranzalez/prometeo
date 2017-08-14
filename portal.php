<?php 
    session_start();
    if(isset($_GET['logout']))
    {
        global $user;
        $users = $_SESSION["user"];
        unset($_SESSION["user"], $_SESSION["user_full_name"], $_SESSION["sess"], $_SESSION['timestamp']);
        
    }
   
    if(!isset($_SESSION['user']) && !isset($_SESSION['sess']))
    {
       $destination = 'login.php?user='.$users;
       header("Location: ".$destination);
       exit;
    }

    $user = (isset($_SESSION['user_full_name']))?$_SESSION['user_full_name']:'Uknown';

?>



<?php include 'includes/header.inc.php';?>
    <style>
        body{
            background-color:#FFCC66;
        }

        /*JQUERY UI */
        #dialog-message .ui-dialog-titlebar{
            background-color:green;
            color:white;
        }
        #crearFolderForm .ui-dialog-titlebar{
            background-color:blue;
            color:white;
        }

        /*SUB CLASES*/
        a:focus, button:focus, input:focus
        {
            outline:none;
        }
        #dialog-message, #crearFolderForm, #selectFolderForm, .detalles_folder{
            display:none;
        }
        .detalles_folder{
            position:absolute;
            width:100%;
            height:100%;
            z-index: 2020;
            padding:50px 150px;
            background-color: rgba(35,35,45,1);
        }
        .borde_radio_3px
        {
            border-radius:3px;
        }
        .row{
            margin: 0px !important;
            padding:0px !important;
        }
        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-2, .col-10{
            margin: 0px !important;
            padding:0px !important;
        }
        /*SUB CLASES*/
        .logoPortal{
            width:170px;
        }
        .loadingCtn
        {
            width:100%;
            height:100%;
            position:fixed;
            z-index:2020;
            background-color:rgba(255,255,255,.5);
            display: none;
        }
        .loading{
            
            z-index:2020;
            margin-top:20% !important;
            width: 82px;
            height: 82px;
            background: url(img/loadingOrange.svg);
            background-size: 82px 82px;
            margin:auto;
        }
        .certificado{
            display: none;
        }
        .dash{
            padding:5px 17px !important;
            
        }
       
        .empBox
        {
           background-color:white;
           box-shadow:0px 0px 5px #ccc;
           margin-bottom:10px !important;
           font-size:8pt !important;
           width: 100%;
           font-size:8pt;
           cursor:pointer;
           
        }
        .empresas_contenedor, .fileContainer
        {
            display:none;
        }
        .datos_empresa_contenedor
        {
            width:90%;
            margin:auto;
        }
        .datos_de_empresa
        {
            font-size:9pt !important;
        }
        .datosEmpresa
        {
            background-color:white;
            box-shadow:0px 0px 5px #ccc;
        }
        .perCtner
        {
            background-color:white;
            box-shadow:0px 0px 5px #ccc;
        }
        .formatoCtner
        {
            background-color:white;
            box-shadow:0px 0px 5px #ccc;
            padding:0px;
            width:95%;
        }
        .formato, .period
        {
            color:#333;
        }
        .formato:hover, .period:hover
        {
            background-color:#333;
            color:#ccc;
            cursor:pointer;
            text-decoration:none;
        }
        .formato:focus, .period:focus{
            background-color:#333;
            color:#ccc;
        }
        
        .generar_certificado_boton{
            padding:15px 0px;
            text-align:center;
            width:100%;
        }
        .generar_certificado_boton .imprimirBtn, .generar_certificado_boton .pdfBtn, .generar_certificado_boton .guardarBtn
        {
            background-color:darkgreen;
            border:none;
            color:white;
            padding:8px;
            font-size:18pt;
            box-shadow: 0px 0px 5px #aaa;
            display:none;
        }
        .generar_certificado_boton .imprimirBtn:hover
        {
            background-color:green;
        }
        .generar_certificado_boton .pdfBtn
        {
            background-color:darkred;
        }
        .generar_certificado_boton .pdfBtn:hover
        {
            background-color:red;
        }
        .generar_certificado_boton .guardarBtn{
            background-color:orangered;
        }
        .generar_certificado_boton .guardarBtn:hover{
            background-color:orange;
        }
        .fileContainer{
            position:relative;
        }
        .filesLoading{
            display:none;
            position:absolute;
            left:50%;
            top:20%;
        }
        

    </style>

</head>

<body>
    <ul class="folderlist">
    
    </ul>
    <!-- DETALLES FOLDER -->
    <div class="detalles_folder">
    <i style="position:absolute;right:0;top:0;" class="fa fa-times-circle-o" aria-hidden="true"></i>
        <h2>Nombre de Folder</h2>
    </div>
    <!-- CREAR FOLDER MODAL -->    
    <div id="crearFolderForm" title="Crear Folder">
        <form>
            <fieldset>
            <input type="text" placeholder="Nombre" name="folderName" id="folderName" class="text ui-widget-content ui-corner-all">
            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>
    <!-- SELECT FOLDER MODAL -->
    <div id="selectFolderForm" title="Seleccione Folder">
        <form>
            <fieldset>
            <select name="folderList" form="carform">
                <option value="">HOME</option>
            </select>
            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>
    
    <!-- MODAL CONFIMACION CERTIFICADO GUARDADO -->
    <div id="dialog-message" title="CERTIFICADO GUARDADO">
    <p><span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>Certificado guardado exitosamente!.</p>
    <p>Nombre de documento: <b><spam style="font-size:8pt;" class="dialog_mess"></spam></b></p>
    </div>
    <div class="loadingCtn"><div class="loading"></div></div>
    
     <div class="headerPortal">
        <div class="row">
            <div class="col-md-12"><img class="logoPortal" src="img/logo_ppal.png" alt=""></div>
        </div>
    </div>

<!-- CERTIFICADO -->
<div class="certificado">

    <div class="col-md-6 cert_logo_container"><img class="logo_certificado" src="http://placehold.it/120x80" alt=""></div>
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

            <!-- SIDE BAR -->
            <div class="sideBar col-md-3">

                <div class="row">
                    <div class="col-md-6"><img src="http://placehold.it/100x100" alt=""></div>
                    <div class="col-md-6">
                        <h5>John Smith</h5>
                        <a href="#">john@email.com</a>
                    </div>
                </div>

                <ul class="cPannel">
                    <li><a href="#" class="portalNavEmpBtn" data-nav="1" data-empresa="empVinculadas"><i class="fa fa-building" aria-hidden="true"></i>  Empresas vinculadas</a></li>
                    <li><a href="#" class="portalNavDocBtn" data-nav="2" data-empresa="documents"><i class="fa fa-file-text-o" aria-hidden="true"></i>  Manejo de documentos</a></li>
                </ul>
               
                 <ul class="cPannelBottom">
                    <li><a href="#"><i class="fa fa-id-card-o" aria-hidden="true"></i>  Cambiar datos</a></li>
                    <li><a href="#"><i class="fa fa-lock" aria-hidden="true"></i>  Cambiar clave</a></li>
                    <li><a href="portal.php?logout=true"><i class="fa fa-power-off" aria-hidden="true"></i>  Salir</a></li>
                </ul>

            </div>
            <!-- SIDE BAR ENDS -->
            
            <div class="dash col-md-9" style="padding:10px 20px !important;position:relative;margin-top:2% !important;">
                <div class="empresas_contenedor"><h4 class="secTitle" style="color:#ccc;">Empresas Vinculadas</h4></div>

                <div class="fileContainer"><div class="filesLoading"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span></div></div>
                </div>
            <div class="documentos">
                
                <div class="btn-group">
               
                </div>
            </div>

        </div>
             
    </div>

    <footer style="text-align: center; padding:25px;width:50%;margin:auto;">
            <p style="color: #fcb72d">&copy;2017 Prometeo. Todos los derechos reservados.</p>
    </footer>
    <?php include 'includes/footer.inc.php';?>
<script>

//FUNCIONES CORRELATIVAS
        //JQUERY UI
        $('.fileContainer').button().on( "click", '.newFolderBtn', function() {
            dialog = $( "#crearFolderForm" ).dialog({
                autoOpen: false,
                height: 160,
                width: 350,
                modal: true,
                buttons: {
                    "Crear Folder": crearFolder,
                    Cancel: function() {
                    dialog.dialog( "close" );
                    }
                },
                close: function() {
                    form[ 0 ].reset();
                }
            });
                form = dialog.find( "form" ).on( "submit", function( event ) {
                event.preventDefault();
                
                crearFolder();
                dialog.dialog( "close" );
            });
            dialog.dialog( "open" );
        });
        
     
        
        //NAVEGACION
        $('.portalNavEmpBtn').on('click', function(){
            var dpb = $(this).attr('data-empresa');
            if(dpb = 'empVinculadas')
            {
                document.body.style.backgroundColor = '#FFCC66';
                empresas_vinculadas();
            }
        });
        $('.portalNavDocBtn').on('click', function(){
            var dpb = $(this).attr('data-empresa');
            if(dpb = 'documents')
            {
                document.body.style.backgroundColor = '#FFCC66';
                renderFiles();
            }
        });
        //NAVEGACION END

        //DASH FUNCTIONS
        $('.dash').on('click', '.perCtner .period', function(){
            $('.period i').hide();
            $(this).focus();
            $(this).find('i').show();
            var mesini = $(this).find('.mes_inicial').text();
            var mesfin = $(this).find('.mes_final').text();
            $('.generar_certificado_boton .imprimirBtn').attr('data-mesini', mesini);
            $('.generar_certificado_boton .imprimirBtn').attr('data-mesfin', mesfin);
            
            $('.generar_certificado_boton .guardarBtn').attr('data-mesini', mesini);
            $('.generar_certificado_boton .guardarBtn').attr('data-mesfin', mesfin);
            $('.generar_certificado_boton .imprimirBtn').show();
            $('.generar_certificado_boton .pdfBtn').show();
            $('.generar_certificado_boton .guardarBtn').show();
        });

        $('.dash').on('click','.formatoCtner .formato', function(){
            $('.formato i').hide();
            $(this).focus();
            $(this).find('i').show();
            var id_emp = $(this).attr('data-idemp');
            var codigo_formato = $(this).attr('data-codigoFormato');
            periodos(id_emp, codigo_formato);
            $('.generar_certificado_boton .imprimirBtn').attr('data-codform', $(this).attr('data-codigoFormato'));
            $('.generar_certificado_boton .guardarBtn').attr('data-codform', $(this).attr('data-codigoFormato'));
        });

        $('.dash').on('click','.empBox', function(){
            $('.empresas_contenedor').hide();
            generar_datos_de_empresa($(this));
        });


        //GENERAR CERTIFICADO BTN
         $(".dash").on('click','.datos_de_empresa .generar_certificado_boton .imprimirBtn', function(){
            $('.generar_certificado_boton .imprimirBtn').html('<i style="font-size:18pt !important;" class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');
            var formato = $(this).attr('data-codform');
            var mesini = $(this).attr('data-mesini');
            var mesfin = $(this).attr('data-mesfin');
            generar_certificado(formato, mesini, mesfin);

         });
         
        $('.pdfBtn').on('click', function(){
            var html = document.getElementsByClassName('certificado')[0];
            
        });
        //GUARDAR CERTIFICADO
        $('.dash').on('click','.datos_de_empresa .generar_certificado_boton .guardarBtn', function(){
           guardar_certificado();
        });

        $('.fileContainer').on('click','.folderBtn', function(){
            var data = $(this).attr('data-folder');
            open_folder(data);
        });


/*************** FUNCIONES **********************/
//FUNCIONES COMPLEMENTARIAS
        function hexToBase64(str) {
            
            if(str != false)
            {
                return btoa(String.fromCharCode.apply(null, str.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" ")));
            }else{
                return 'http://placehold.it/50x50';
            }
            
        }
        function tdate(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;

            var yyyy = today.getFullYear();
            if(dd < 10){
                dd = '0' + dd;
            } 
            if(mm < 10){
                mm = '0' + mm;
            } 
            var today = dd+'/'+mm+'/'+yyyy;
            return today;
        }
        function PrintElem(){
            var elem = document.getElementsByClassName('modal-body')[0];
            dimsW = 900;
            dimsH = 665;
            var x = screen.width/2 - dimsW/2;
            var y = screen.height/2 - dimsH/2;
            var mywindow = window.open('', 'PRINT', 'height='+dimsH+',width='+dimsW+',left='+x+',top='+y);

            mywindow.document.write('<html><head><title>PROMETEO - CERTIFICADO</title>');
            mywindow.document.write('<link rel="stylesheet" href="http://70.35.196.223/promTest/css/certificado.css"><link rel="stylesheet" href="http://70.35.196.223/promTest/css/bootstrap.css"><link rel="stylesheet" href="http://70.35.196.223/promTest/css/font-awesome.css">');
            mywindow.document.write('</head><body>');
            mywindow.document.write(elem.innerHTML);
            mywindow.document.write('<script src="http://70.35.196.223/promTest/js/jquery-3.2.1.js"><\/script>'+
            '<script src="http://70.35.196.223/promTest/js/bootstrap.js"><\/script>'+
            '<script src="http://70.35.196.223/promTest/js/jspdf.js"><\/script>'+
            '<script src="http://70.35.196.223/promTest/js/html2canvas.js"><\/script>'+
            '<script src="http://70.35.196.223/promTest/js/main.js?newversion"><\/script>');
            mywindow.document.write('</body></html>');
            
           
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;

        }

//FUNCIONES AJAX
        function empresas_vinculadas(){
            $('.loadingCtn').show();
            clearAll();
            $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=empvin",
                success: function(res) {
                    $(".portalNavBtn[data-nav=1]").focus();
                    
                    var d = JSON.parse(res);
                    
                    if(d.length > 0)
                    {
                        for (var i = 0; i < d.length; i++) 
                        {
                                var img = d[i].lgtpo_emprsa;
                                var html = '<div class="row" style="margin-bottom:3px !important;font-size:8pt !important;">'+                                       
                                '<div class="col-md-12 empBox borde_radio_3px" style="padding:0px 20px !important;">'+
                                    '<h6 class="razonSocial" data-razonSocial="'+d[i].nmbre_rzon_scial+'">'+d[i].nmbre_rzon_scial+'</h6>'+
                                    '<p style="font-size:8pt;" class="nitEmp" data-nit="'+d[i].id_emprsa+'" data-color="'+d[i].cdgo_color+'">NIT: '+d[i].id_emprsa.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</p>'+
                                    '<input type="hidden" class="dirEmpresa" value="'+d[i].drccion+'">'+
                                    '<input type="hidden" class="paisEmpresa" value="'+d[i].nmbre_pais+'">'+
                                    '<input type="hidden" class="municipioEmpresa" value="'+d[i].nmbre_mncpio+'">'+
                                    '<input type="hidden" class="webEmpresa" value="'+d[i].web_site+'">'+
                                    '<input type="hidden" class="logo_empresa" value="'+img+'">'+
                                '</div>'+
                                '</div>';
                                
                            
                            
                            $('.logoPortal').attr('src', 'img/logo_ppal.png');
                            $('.empresas_contenedor').append(html);
                            
                        }
                        $('.empresas_contenedor').fadeIn();
                        $('.loadingCtn').fadeOut();
                    }
                }
            });
            
        }
        function generar_datos_de_empresa(el){
            $('.empresas_contenedor').fadeOut();
            $('.datos_empresa_contenedor').remove();

            var color = $(el).find('p').attr('data-color');
            var colorFinal = color.slice(0,-3);
            var imgData = $(el).find('.logo_empresa').val();
           
            var img = 'data:image/jpeg;base64,'+hexToBase64(imgData);
            document.body.style.backgroundColor = colorFinal;
            $('.dtsEmpLogo').attr('src', img);
             
            var html = '<div class="datos_empresa_contenedor">'+
            '<div class="row" style="text-align:center;"><img src="'+img+'"></div>'+
            '<h4 style="color:#ccc;text-align:center;">Datos de empresa</h4>'+
            '<div class="datos_de_empresa">'+
                '<div class="datosEmpresa borde_radio_3px" style="padding:5px 5px !important;">'+
                    '<div class="row">'+
                        '<div class="col-md-6">'+
                            '<div class="row">'+
                                '<div class="col-md-3"><strong>Razon Social:</strong></div>'+
                                '<div class="col-md-9 nombre_empresa"> '+$(el).find('.razonSocial').attr('data-razonSocial').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();})+'</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-3"><strong>NIT:</strong></div>'+
                                '<div class="col-md-9 nit_empresa">'+$(el).find('.nitEmp').attr('data-nit').toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-6">'+
                            '<div class="row">'+
                                '<div class="col-md-3"><strong>Direccion:</strong></div>'+
                                '<div class="col-md-9 direccion_empresa">'+$(el).find('.dirEmpresa').val()+'</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-3"><strong>Sition Web:</strong></div>'+
                                '<div class="col-md-9 web_site"><a href="http://'+$(el).find('.webEmpresa').val()+'">'+$(el).find('.webEmpresa').val()+'</a></div>'+
                            '</div>'+
                        '</div>'+                     
                    '</div>'+                   
                '</div>'+
                '<div class="row formato_periodo_empresa">'+
                    '<div class="col-md-6">'+
                        '<h4 style="color:#ccc;text-align:center;">Formatos</h4>'+
                        '<div class="formatoCtner borde_radio_3px"></div>'+
                    '</div>'+
                    '<div class="col-md-6">'+
                        '<h4 style="color:#ccc;text-align:center;">Periodos</h4>'+
                        '<div class="perCtner borde_radio_3px"></div>'+
                    '</div>'+
                '</div>'+
                '<div class="generar_certificado_boton">'+
                '<h4 style="color:#ccc;text-align:center;">Generar Certificado</h4>'+
                    '<div class="row" style="width:25%;margin:auto !important;">'+
                        '<div class="col-md-4" >'+
                        '<div style="text-align:center;width:95%;">'+
                        '<button type="button" class="imprimirBtn borde_radio_3px"><i class="glyphicon glyphicon-print"></i></button>'+
                        '</div>'+
                            
                        '</div>'+
                        '<div class="col-md-4" >'+
                        '<div style="text-align:center;">'+
                        '<form id="pdfFrm" target="_blank" action="PDF/pdfout.php" method="post">'+
                        '<button type="submit" title="PDF" class="pdfBtn borde_radio_3px"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>'+
                        '<input type="hidden" name="img" value="'+hexToBase64(imgData)+'">'+
                        '<input type="hidden" name="formato" value="">'+
                        '<input type="hidden" name="mesini" value="">'+
                        '<input type="hidden" name="mesfin" value="">'+
                        '</form>'+
                        '</div>'+
                        '</div>'+
                        '<div class="col-md-4">'+
                        '<div style="text-align:center;width:95%;">'+
                        '<form id="saveFrm" method="post">'+
                        '<button type="button" title="Guardar" class="guardarBtn borde_radio_3px"><i class="glyphicon glyphicon-floppy-disk"></i></button>'+
                        '<input type="hidden" name="img" value="'+hexToBase64(imgData)+'">'+
                        '<input type="hidden" name="formato" value="">'+
                        '<input type="hidden" name="mesini" value="">'+
                        '<input type="hidden" name="mesfin" value="">'+
                        '</form>'+
                        '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '</div>';

            $('.dash').append(html);
            formatos($(el).find('.nitEmp').attr('data-nit'));
            
        }
        function generar_certificado(formato, mesini, mesfin){
            $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=cert&codform="+formato+"&mesini="+mesini+"&mesfin="+mesfin,
                success: function(res) {
                    
                    if(res != 'false'){
                       var d = JSON.parse(res);
                       
                       
                        if(d[0].lgtpo_emprsa != false)
                        {
                            var imgData = d[0].lgtpo_emprsa;
                            var img = 'data:image/jpeg;base64,'+hexToBase64(imgData);
                        }else{
                            var img = 'http://placehold.it/50x50';
                        }

                        $('.logo_certificado').attr('src', img);
                        $('.certificado_nombre_empresa').text(d[0].nmbre_rzon_scial);
                        $('.certificado_nit_empresa').text(d[0].id_emprsa.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                        $('.certificado_direccion_empresa').text(d[0].drccion);
                        $('.certificado_ciudad_empresa').text(d[0].nmbre_mncpio+', '+d[0].nmbre_pais);
                        $('.certificado_formato').html('<h3>CERTIFICADO DE '+d[0].nmbre_frmto+'<br/>AÑO GRAVABLE '+d[0].ano_mes_fnal.substr(0, 4)+'</h3>');
                        $('.certificado_fecha_emicion').html('<p style="text-align:center;">Fecha Emisión: '+tdate()+'</p>');

                        var m = d[0].pie_frmto.match(/(\d{2})\/(\d{2})\/(\d{4})/).toString().substring(0, 10);
                        $('.certificado_footer').text(d[0].pie_frmto.replace(m, tdate()));

                        var total_base = [];
                        var total_retencion = [];
                        $(".concepto").remove();
                        for (var i = 0; i < d.length; i++) {
                           var base =(d[i].vlor_grvble * d[i].prcntje_aplccion)/100;
                           total_base.push(base);
                           total_retencion.push(Math.round(d[i].vlor_grvble));
                            var html = '<div class="row concepto" style="padding:0px 10px !important;">'+
                                '<div class="col-md-6 certificado_nombre_concepto">'+d[i].nmbre_cncpto.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()})+'</div>'+
                                '<div class="col-md-2 certificado_taza" style="text-align:right;">'+d[i].prcntje_aplccion+'%</div>'+
                                '<div class="col-md-2 certificado_base" style="text-align:right;">'+base.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>'+
                                '<div class="col-md-2 certificado_retencion" style="text-align:right;">'+Math.round(d[i].vlor_grvble).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>'+
                            '</div>';

                         $(html).insertAfter('.headings');
                       }
                       function add(a, b) {
                            return a + b;
                       }
                       var totalB = total_base.reduce(add, 0);
                       var totalR = total_retencion.reduce(add, 0);
                       $('.certificado_total_base').html(totalB.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                       $('.certificado_total_retencion').html(totalR.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

                       //PrintElem();
                       window.print();
                       $('.generar_certificado_boton .imprimirBtn').html('<i class="glyphicon glyphicon-print"></i>');    
                    }else{
                         console.log('resultado falso');
                    }
                }
            });
        }
        function guardar_certificado(){
            
            $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=files",
                success: function(res) {
                   console.log(res);
                   var d = JSON.parse(res);
                   var html = '';
                   $('.file').remove();
                   for(var key in d['files_main'])
                    {
                        var last4 = d['files_main'][key].substr(d['files_main'][key].length - 4);
                        
                        if(last4.charAt(0) != '.')
                        {
                           html = html+'<option class="file" value="'+d['files_main'][key]+'">'+d['files_main'][key]+'</option>';
                        }else{
                            console.log(d['files_main'][key]);
                        }
                
                    }
                    $('#selectFolderForm form select').append(html);

                    dialog = $( "#selectFolderForm" ).dialog({
                        autoOpen: false,
                        height: 160,
                        width: 350,
                        modal: true,
                        buttons: {
                            "Guardar Documento": savecer,
                            Cancel: function() {
                            dialog.dialog( "close" );
                            }
                        },
                        close: function() {
                            form[ 0 ].reset();
                        }
                    });
                        form = dialog.find( "form" ).on( "submit", function( event ) {
                        event.preventDefault();
                        savecer();
                        dialog.dialog( "close" );
                    });
                    dialog.dialog( "open" );
                    
                }
            });
            function savecer()
            {
                var data = $('#saveFrm').serialize();
                var f = dialog.find('form').find('select').val();
                        console.log(f);
                $.ajax({
                    async: true,
                    type: "post",
                    data: data+"&folder="+f,
                    url: "src/controler.php?req=guardarcert",
                    success: function(res) {
                        $('#dialog-message .dialog_mess').text(res);
                        $( "#dialog-message" ).dialog({
                            modal: true,
                            buttons: {
                                Ok: function() {
                                $(this).dialog( "close" );
                                }
                            }
                        });
                    }
                });
            }
            /**/
        }
        function periodos(id_emp, codigo_formato){
            $('.loadingCtn').show();
            $('.perCtner .row').remove();
            $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=periodos&idemp="+id_emp+"&codform="+codigo_formato,
                success: function(res) {
                    var d = JSON.parse(res);
                                       for (var i = 0; i < d.length; i++) {
                        $('.generar_certificado_boton #pdfFrm input[name=mesini]').val(d[i].ano_mes_incial);
                        $('.generar_certificado_boton #pdfFrm input[name=mesfin]').val(d[i].ano_mes_fnal);
                        $('.generar_certificado_boton #saveFrm input[name=mesini]').val(d[i].ano_mes_incial);
                        $('.generar_certificado_boton #saveFrm input[name=mesfin]').val(d[i].ano_mes_fnal);
                        var htmlPeriodos = '<a href="#" style="display:block;padding:5px !important;font-size:8pt !important;width:100%;" class="row period">'+
                        '<div class="col-md-5 mes_inicial">'+d[i].ano_mes_incial+'</div>'+
                        '<div class="col-md-5 mes_final">'+d[i].ano_mes_fnal+'</div>'+
                        '<div class="col-md-2"><i style="float:right;display:none;" class="formIcon glyphicon glyphicon-ok"></i></div>'+
                        '</a>';
                        $('.perCtner').append(htmlPeriodos);
                        $('.loadingCtn').fadeOut();
                    }
                    
                }
            });
        }
        function formatos(id_emp){
            $('.loading').show();
            $('.formatoCtner a').remove();
            $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=formatos&idemp="+id_emp,
                success: function(res) {
                    var d = JSON.parse(res);
                                       for (var i = 0; i < d.length; i++) {
                        var html = '<a href="#" style="display:block;padding:5px !important;font-size:8pt !important;width:100%;" class="formato" data-codigoFormato="'+d[i].cdgo_frmto+'" data-idemp="'+d[i].id_emprsa+'">'+d[i].nmbre_frmto+' <i style="float:right;display:none;" class="formIcon glyphicon glyphicon-ok"></i></a>';
                        $('.formatoCtner').append(html);
                        $('.generar_certificado_boton #pdfFrm input[name=formato]').val(d[i].cdgo_frmto);
                        $('.generar_certificado_boton #saveFrm input[name=formato]').val(d[i].cdgo_frmto);
                        $('.loadingCtn').fadeOut();
                        
                    }
                }
            });
        }
        function renderFiles(){
            $('.loadingCtn').show();
            clearAll();
            $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=files",
                success: function(res) {
                    var d = JSON.parse(res);
                    var styleDocTile = 'border-radius:3px;background-color:rgba(3,3,3,.5);padding:20px;font-size:8pt;height:130px;box-shadow:0px 0px 5px #ccc;';
                    var styleDocCols = 'color:white;text-align:center;padding:6px !important;position:relative !important;';
                    var html = '<div class="row">';
                    if(d['nofiles'])
                    {
                        html = html+'<p>'+d['nofiles']+'</p>';
                    }else{
                        var linksUrl = 'http://70.35.196.223/promTest/PDF/documents/'+d['nit']+'/';
                        //html = html+'<ul class="fileList">';
                        var i = 0;
                        for(var key in d['files_main'])
                        {
                            var last4 = d['files_main'][key].substr(d['files_main'][key].length - 4);
                            
                            if(last4.charAt(0) == '.')
                            {
                                html = html+'<div class="col-md-4" style="'+styleDocCols+'"><div><a style="'+styleDocTile+'color:white;display:block;" target="blank" href="'+linksUrl+d['files_main'][key]+'"><i style="font-size:40pt;color:darkred;" class="fa fa-file-pdf-o" aria-hidden="true"></i><br/><br/>'+d['files_main'][key]+'</a></div></div>';
                            }else{
                                html2 = html2+'<li><a class="folderBtn" href="#" data-folder="'+d['files_main'][key]+'"><i style="font-size:50pt;color:#FDB813;" class="fa fa-folder" aria-hidden="true"></i>  '+d['files_main'][key]+'</a></li>';
                                
                            }
                            i++;
                        }
                        html = html+'</div>';
                    }
                    html = html+'<div class="filesBtnContainer"><button type="button" class="newFolderBtn"><i class="fa fa-plus" aria-hidden="true"></i> Crear Folder</button></div>';
                    $('.fileContainer').append(html);
                    
                    $('.fileContainer').fadeIn();
                    $('.loadingCtn').fadeOut();
                }
            });
        }
        function crearFolder(){
            var data = dialog.find("form").serialize();
            $.ajax({
                async: true,
                type: 'get',
                url: 'src/controler.php?req=newFold&'+data,
                success: function(res){
                  if(res == 1){
                    dialog.dialog("close");
                    renderFiles();
                  }else{
                      console.log('folder ya existe');
                  }
                }
            });
        }
        function clearAll(){
            $('.datos_empresa_contenedor').remove();
            $('.empresas_contenedor .row').remove();
            $('.fileContainer div').remove();
            $('.fileContainer .filesBtnContainer').remove();
            $('.empresas_contenedor').hide();
        }
        function open_folder(folder)
        {
            $('.detalles_folder').fadeOut();
            $('.detalles_folder .row').remove();
            $.ajax({
                async: true,
                type: 'get',
                url: 'src/controler.php?req=opendir&folderName='+folder,
                success: function(res){
                var d = JSON.parse(res);
                    console.log(folder);
                    var linksUrl = 'http://70.35.196.223/promTest/PDF/documents/'+d['nit']+'/';
                    var styleDocTile = 'border-radius:3px;background-color:rgba(3,3,3,.5);padding:20px;font-size:8pt;height:130px;box-shadow:0px 0px 5px #000;';
                    var styleDocCols = 'color:white;text-align:center;padding:6px !important;position:relative !important;';
                    var html = '<div class="row">';
                    for(var key in d['files'])
                    {
                        html = html+'<div class="col-md-2" style="'+styleDocCols+'"><div><a style="'+styleDocTile+'color:white;display:block;" target="blank" href="'+linksUrl+folder+'/'+d['files'][key]+'"><i style="font-size:40pt;color:darkred;" class="fa fa-file-pdf-o" aria-hidden="true"></i><br/><br/>'+d['files'][key]+'</a></div></div>';
                    }
                    html = html+'</div>';
                    $('.detalles_folder').append(html);
                    $('.detalles_folder').fadeIn();

                }
            });
            
        }

       

    </script>


</body>

</html>


<?php
    ob_start();
    session_start();
    include 'src/sitecred.php';
 include 'includes/header.inc.php';
 include 'src/dbcred.php';
 require_once('src/Log.php');
 ?>
 
<?php 
    $log = new Log($db);
    echo $log->checkLogIn();

?>
<link rel="stylesheet" href="css/login.css">
<body style="background-color: #FFCC66;">
    <div class="cover_not_available_for_mobile">
        <div class="coverCtn">
        <img src="img/logo_ppal.png" alt="">
        <h2>Disculpe, esta aplicacion aun no esta disponible para trabajar desde un Smart o móvil</h2>
        </div>
        
    </div>
<div class="loadingCtn"><div class="loadBg"><div class="loading"></div><p style="text-align:center;">Trabajando..</p></div>  </div>
   <div id="login-dialog-modal"></div>
   <div class="contain">
      
        <div class="logo">
            <img src="img/logo_ppal.png" alt=""><span style="letter-spacing:2;">(BETA)</span>
            <p style="font-size: 6pt;text-align: center;margin-left: 42px;margin-top: -9;width: 160;padding: 0px !important;">Un Producto SQL SOLUCIONES INFORMATICAS SAS</p>
        </div>
        <div class="logBox">

            <!-- LOGIN REGISTRATION BTNS -->
            <div class="row logBoxActionBtns">
                <div class="col-md-12"><p class="log_box_title"><b>Inicio</b></p></div>
                <!-- <div class="col-md-6"><button class="regBtn" type="button" onclick="$('#loginForm').hide();$('#recPassForm').hide();$('#regForm').show();">Registrarme</button></div> -->
            </div>
            <!--LOGIN REGISTRATION BTNS ENDS-->

            <!-- LOGIN FORM -->
            <form id="loginForm">
                <div class="row">
                    <div class="col-md-12"><i class="userIcon fa fa-at" aria-hidden="true"></i><input class="userName" type="text" required data-parsley-required-message="Su correo electrónico es mandatorio" name="user_name" placeholder="Correo electrónico"></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><i class="passIcon glyphicon glyphicon-lock"></i><input class="userPass" type="password" required data-parsley-required-message="Su contraseña es mandatoria" name="user_pass" placeholder="Contraseña"></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><button type="button" class="logInBtn">Iniciar Sesión</button></div>
                    <!-- CAPTCHA -->
                    <!-- <div class="g-recaptcha" data-sitekey="6Lfk5DAUAAAAAN_iA7IrTiCd0041VYmTtmWDrbDG"></div> -->
                </div>
                
            </form>
            <!--LOGIN FORM ENDS-->

            <!-- REGISTRATION FORM -->
            <form id="regForm">
                <div class="row input_field">
                    <div class="col-md-6" style="padding-right:2px;"><input required data-parsley-required-message="Su nombre es mandatorio" type="text" name="client_names" placeholder="Nombres"></div>
                    <div class="col-md-6" style="padding-left:2px;"><input required data-parsley-required-message="Su apellido es mandatorio" type="text" name="client_lastnames" placeholder="Apellidos"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-required-message="Su correo electronico es mandatorio" type="email" name="client_email" placeholder="Correo electronico"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-6" style="padding-right:2px;"><input type="text" name="client_phone" placeholder="Telefono fijo"></div>
                    <div class="col-md-6" style="padding-left:2px;"><input type="text" name="client_mobile" placeholder="Telefono mobil"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input id="pw" required data-parsley-required-message="Porfavor elija una clave de acceso" type="password" name="client_pass" placeholder="Contrasena"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-equalto="#pw" data-parsley-required-message="Porfavor confirme su clave" type="password" placeholder="Confirmar contrasena"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-required-message="Su cedula o NIT es mandatorio" type="text" name="client_nit" placeholder="Cedula o NIT"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><button type="button" class="regSubBtn">Registrarse</button></div>
                </div>
                
            </form>
            <!--REGISTRATION FORM ENDS-->

            <!--PASSWORD RECOVERY FORM -->
            <form id="recPassForm">
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-required-message="Su correo electronico es mandatorio" type="email" name="client_email" placeholder="* Correo electronico"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><button type="button" class="recuPassSubmitBtn">Recuperar contraseña</button></div>
                </div>
            </form>
            <!--PASSWORD RECOVERY FORM ENDS -->
            
            <!-- LINK DE REGRESO A PAGINA PRINCIPAL -->
            <div class="row newUserLinkBox">
                <div class="col-md-12">
                    <ul>
                    <li><a class="recupassForm" href="#">Olvidé mi Contraseña</a></li>
                    <li>Recordarme <input type="checkbox" class="rememberMe" name="rm"></li>
                    <li><a  class="regresarLink" href="index.php">Regresar</a></li>
                    
                    
                        
                    </ul>
                </div>
            </div>
            <!--LINK DE REGRESO A PAGINA PRINCIPAL ENDS-->

        </div>





    </div>
    <footer style="text-align: center; padding:25px;width:50%;margin:auto;">
            <p style="color: black">&copy;2017 Prometeo. Todos los derechos reservados.</p>
    </footer>


<?php include 'includes/footer.inc.php';?>
  
    <script type="text/javascript"> /*CUSTOM JS*/
        
        init();
        function init(){
            if(readCookie('user') != null && readCookie('pass') != null)
            {
                console.log('pass');
                $('.userName').val(readCookie('user'));
                $('.userPass').val(readCookie('pass'));
                $('.rememberMe').attr('checked', 'true');
            }
            
        }
      
       function showFrom(){
        $('.log_box_title').text('Inicio');
        $("#recPassForm").hide();
        $('#loginForm').show();
        $('.newUserLinkBox .regresarLink').attr('onclick', '');
        setTimeout(function() {
            $('.newUserLinkBox .regresarLink').attr('href', 'index.php');
        }, 1000);
        
       }
       
        
       $(".regSubBtn").on('click', function(){
           var valid = $('#regForm').parsley().validate();

           if(valid)
           {
                var data = $("#regForm").serialize();
                $.ajax({
                    data: data,
                    async: true,
                    type: "post",
                    url: "src/controler.php?req=regi",
                    success: function(res) {
                        console.log(res);
                    if(res == 1)
                    {
                        $('#login-dialog-modal').html('<spam style="color:green;float:left" class="fa fa-check" aria-hidden="true"></spam><p class="dialog_mess">Registro exitoso! Por favor revise su correo electronico para activar su cuenta.</p>');
                        $("#login-dialog-modal").dialog({
                            modal: true,
                            title: 'Exito!',
                            buttons: {
                                Ok: function() {
                                    $(this).dialog("close");
                                }
                            }
                        });
                    }else if(res == 0){
                        $('#login-dialog-modal').html('<spam style="color:orange;float:left" class="fa fa-warning" aria-hidden="true"></spam><p class="dialog_mess">La cuenta de correo ya se encuentra Registrada. Para recuperar su contraseña de ingreso Haga click <button style="color:#333;" class="recuPassBtn" type="button">Aquí.</button></p>');
                        $("#login-dialog-modal").dialog({
                            modal: true,
                            title: 'Atencion!',
                            buttons: {
                                Ok: function() {
                                    $(this).dialog("close");
                                }
                            }
                        });
                       
                    }
                    }
                });
           }
           
       });

       $('.recupassForm').on('click', function(){
        $('.regresarLink').attr('href', '#');
        $('.regresarLink').attr('onclick', 'showFrom();');
        showRecuPassForm();
       });
       function showRecuPassForm(){
           $("#loginForm").hide();
           $("#regForm").hide();
           $('.log_box_title').text('Enviar contraseña');
           $("#recPassForm").show();
           $('.newUserLinkBox a').attr('href', '#');
           $('.newUserLinkBox a').attr('onclick', 'showFrom()');
       }
       
       function recupass(type){
           $('.loadingCtn').show();
           
        if(type == 'insta'){
            var data = $("#loginForm").find('.userName').val();
        }else if(type == 'form'){
            var data = $('#recPassForm').find("input[type='email']").val();
        }
        $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=pass&client_email="+data,
                success: function(res) {
                    console.log(res);
                if(res == 1)
                {
                    $('#login-dialog-modal').html('<spam style="color:green;float:left" class="fa fa-check" aria-hidden="true"></spam><p class="dialog_mess">Se ha enviado un email a su cuenta registrada Por favor revise su correo electrónico. Diríjase luego por la Opción: Ingreso de Usuarios Registrados</p>');
                        $("#login-dialog-modal").dialog({
                            modal: true,
                            title: 'Exito!',
                            buttons: {
                                Ok: function() {
                                    $(this).dialog("close");
                                }
                            }
                        });
                        $(".iniSession").focus();
                        $('#regForm').hide();
                        showFrom();
                        $('.loadingCtn').fadeOut();
                }else{
                    $('#login-dialog-modal').html('<spam style="color:orange;float:left" class="fa fa-warning" aria-hidden="true"></spam><p class="dialog_mess">El Correo electrónico suministrado no existe Creado en nuestros registros.</p>');
                    $("#login-dialog-modal").dialog({
                        modal: true,
                        title: 'Atencion!',
                        buttons: {
                            Ok: function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                     
                     $(".iniSession").focus();
                     $('#regForm').hide();
                     showFrom();
                     $('.loadingCtn').fadeOut();
                }
                }
        });
       }

       $('.recuPassSubmitBtn').on('click', function(){
        recupass('form');
       });

       $('.logInBtn').on('click', function(){
        $('.loadingCtn').show();
        var valid = $('#loginForm').parsley().validate();
        console.log(valid);
        if(valid){
            var data = $('#loginForm').serialize();
            var siteURI = '<?php echo SITE_URI; ?>';
                $.ajax({
                data: data,
                async: true,
                type: "post",
                url: "src/controler.php?req=login",
                success: function(res) {
                    console.log(res);
                if(res == 1)
                {
                    if($('.rememberMe').is(':checked')){
                        var user = $('.userName').val();
                        var pass = $('.userPass').val();
                        createCookie('user',user,5);
                        createCookie('pass',pass,5);
                    }else{
                        eraseCookie('user');
                        eraseCookie('pass');
                    }
                    $('.loadingCtn').fadeOut();
                    window.location.replace("http://"+siteURI+"portal.php");
                }else if(res == 3){
                    $('.loadingCtn').fadeOut();
                    $('#login-dialog-modal').html('<spam style="color:orange;float:left" class="fa fa-warning" aria-hidden="true"></spam><p class="dialog_mess">El Correo electrónico suministrado no existe Creado en nuestros registros.</p>');
                        $("#login-dialog-modal").dialog({
                            modal: true,
                            title: 'Atencion!',
                            buttons: {
                                "Cerrar": function() {
                                    $(this).dialog("close");
                                }
                                
                            }
                        });
                }else if(res == 0){
                    $('.loadingCtn').fadeOut();
                    $('#login-dialog-modal').html('<spam style="color:orange;float:left" class="fa fa-warning" aria-hidden="true"></spam><p class="dialog_mess">El correo electrónico suministrado es correcto Pero su contraseña no. Para recuperar su Contraseña Haga click en el botón RECUPERAR CONTRASEÑA</p>');
                        $("#login-dialog-modal").dialog({
                            modal: true,
                            title: 'Atencion!',
                            buttons: {
                                "Recuperar Contraseña": function() {
                                    recupass('insta');
                                    $(this).dialog("close");
                                },
                                "Cerrar": function() {
                                    $(this).dialog("close");
                                }
                                
                            }
                        });
                    
                }else if(res == 2){
                    $('.loadingCtn').fadeOut();
                    $('#login-dialog-modal').html('<spam style="color:orange;float:left" class="fa fa-warning" aria-hidden="true"></spam><p class="dialog_mess">Al parecer su correo electrónico aún no se ha confirmado. Por favor revíselo, con el fin de Activar su cuenta.</p>');
                        $("#login-dialog-modal").dialog({
                            modal: true,
                            title: 'Atencion!',
                            buttons: {
                                "Cerrar": function() {
                                    $(this).dialog("close");
                                },
                                "Enviar Correo": function(){
                                    var email = $('#loginForm').find('input[type="text"]').val();
                                   
                                    reSendEmail(email);
                                    
                                }
                                
                            }
                        });
                }  
                }
            });
        }
        

       
       });

      

       function reSendEmail(email){
           
        $.ajax({
            async: true,
            type: "post",
            url: "src/controler.php?req=regEmail&email="+email,
            success: function(res) {
               console.log(res);
            }
        });
       }
       
       function createCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + value + expires + "; path=/";
        }

        function readCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

        function eraseCookie(name) {
            createCookie(name,"",-1);
        }
        function encrypt(val) {
        $.ajax({
            async: true,
            type: "get",
            url: "src/controler.php?req=encrypt&encVal=" + val,
            success: function(res) {
                return res.toString();
            }
        });
}
        
        
    </script>


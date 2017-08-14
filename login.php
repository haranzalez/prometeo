

<?php
    ob_start();
    session_start();
 include 'includes/header.inc.php';?>
<?php 

    $mess = (isset($_GET['mess']))?$_GET['mess']:false;

?>
<body style="background-color: #FFCC66;">
    <div class="httMess">
        <p>
       
        </p>
    </div>
   <div class="contain">
      
        <div class="logo">
            <img src="img/logo_ppal.png" alt="">
        </div>
        <div class="logBox">

            <!-- LOGIN REGISTRATION BTNS -->
            <div class="row logBoxActionBtns">
                <div class="col-md-6"><button class="iniSession" type="button" onclick="$('#regForm').hide();$('#recPassForm').hide();$('#loginForm').show();">Iniciar sesion</button></div>
                <div class="col-md-6"><button class="regBtn" type="button" onclick="$('#loginForm').hide();$('#recPassForm').hide();$('#regForm').show();">Registrarme</button></div>
            </div>
            <!--LOGIN REGISTRATION BTNS ENDS-->

            <!-- LOGIN FORM -->
            <form id="loginForm">
                <div class="row">
                    <div class="col-md-12"><i class="userIcon fa fa-at" aria-hidden="true"></i><input class="userName" type="text" name="user_name" placeholder="Correo electronico"></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><i class="passIcon glyphicon glyphicon-lock"></i><input class="userPass" type="password" name="user_pass" placeholder="Clave de acceso"></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><button type="button" class="logInBtn">Iniciar Session</button></div>
                </div>
                 <div class="row input_field">
                    <div class="col-md-12"><p class="feedMess" style="text-align:center;padding-top:3px;color:red;">
                    </p></div>
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
                 <div class="row message_field">
                    <div class="col-md-12"><p class="mess" style="text-align:center;padding-top:10px;"></p></div>
                </div>
                
            </form>
            <!--REGISTRATION FORM ENDS-->

            <!--PASSWORD RECOVERY FORM -->
            <form id="recPassForm">
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-required-message="Su correo electronico es mandatorio" type="email" name="client_email" placeholder="Correo electronico"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><button type="button" class="recuPassSubmitBtn">Recuperar</button></div>
                </div>
            </form>
            <!--PASSWORD RECOVERY FORM ENDS -->
            
            <!-- LINK DE REGRESO A PAGINA PRINCIPAL -->
            <div class="row newUserLinkBox">
                <div class="col-md-12">
                    <p><a href="index.php">Regresar</a></p>
                </div>
            </div>
            <!--LINK DE REGRESO A PAGINA PRINCIPAL ENDS-->

        </div>





    </div>
    <footer style="text-align: center; padding:25px;width:50%;margin:auto;">
            <p style="color: #fcb72d">&copy;2017. Todos los derechos reservados.</p>
    </footer>


<?php include 'includes/footer.inc.php';?>
  
    <script> /*CUSTOM JS*/
        $(function() {
            $(".iniSession").focus();
        });
        
        
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
                        $('.mess').html('Registro exitoso! Por favor revise su correo electronico para activar su cuenta.').css('color','green');
                        $('.message_field').show();
                    }else if(res == 0){
                        $('.mess').html('Al parecer su correo electronico ya esta en uso. Por favor valla a inicio de sesion, o si olvido su contrasena recuperela <button style="color:#333;" class="recuPassBtn" type="button">aqui.</button>').css('color','red');
                        $('.message_field').show();
                       
                    }
                    }
                });
           }
           
       });
       $(".mess").on('click','.recuPassBtn', function(){
           $("#loginForm").hide();
           $("#regForm").hide();
           $("#recPassForm").show();
       });
       
       $('.recuPassSubmitBtn').on('click', function(){
           var data = $("#recPassForm").serialize();
           console.log(data);
           $.ajax({
                data: data,
                async: true,
                type: "get",
                url: "src/controler.php?req=pass",
                success: function(res) {
                    console.log(res);
                if(res == 1)
                {
                    $('.mess').html('Su clave se a enviado exitosamente a su correo electronico').css('color','green');
                    $(".regBtn").focus();
                    $('#loginForm').hide();$('#recPassForm').hide();$('#regForm').show();
                }else{
                     $('.mess').html('Su correo electronico no concuerda con ninguno en nuestra base de datos. Por favor revise su correo electronico o registrese si aun no lo ha hecho.').css('color','red');
                     $(".regBtn").focus();
                     $('#loginForm').hide();$('#recPassForm').hide();$('#regForm').show();
                }
                }
            });
       });

       $('.logInBtn').on('click', function(){
        var data = $('#loginForm').serialize();
        console.log(data);
        $.ajax({
            data: data,
            async: true,
            type: "post",
            url: "src/controler.php?req=login",
            success: function(res) {
                console.log(res);
               if(res == 1)
               {
                 window.location.replace("http://70.35.196.223/promTest/portal.php");
               }else{
                 $('.feedMess').html(res);
               }  
            }
        });
       })
       
            
        
        
    </script>


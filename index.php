<?php include 'includes/header.inc.php';?>
<body>
<div id="login-dialog-modal" style="display:none;"> 
    </div>
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-2"><img src="img/logo_ppal.png" alt=""><p style="font-size: 6pt;text-align: center;margin-left: 18px;margin-top: -6;width: 160;padding: 0px !important;">Un Producto SQL SOLUCIONES INFORMATICAS SAS</p></div>
                        <div class="col-md-10">
                            <p style="text-align:center;width: 280;margin: auto;margin-top: 10;font-size:8pt;color:black;">
                                SQL SOLUCIONES INFORMATICAS SAS<br/>
                                Tel: (572) 5242436<br/>
                                <a style="color:black;" target="blank" href="http://www.sqlsoluciones.com">www.sqlsoluciones.com</a><br/>
                                <a style="color:black;" target="blank" href="mailto:info@sqlsoluciones.com">info@sqlsoluciones.com</a>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="col-md-2"></div>
            </div>
        </div>

        <div class="row subHead">
            <div class="col-md-12">
                <ul class="navLinks ">
                    <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                    <li><i class="fa fa-users" aria-hidden="true"></i> Quienes Somos</li>
                    <li><i class="fa fa-gavel" aria-hidden="true"></i> Normatividad</li>
                    <li><a href="contact.php"><i class="fa fa-phone" aria-hidden="true"></i> Contactenos</a></li>
                </ul>
            </div>
        </div>

        <!--REGISTRATION FORM BEGINS-->
        <div class="formContainer">
             <!-- LOGIN REGISTRATION BTNS -->
             <div class="row logBoxActionBtns">
                <div class="col-md-12"><p class="log_box_title"><b></b></p></div>
                <p style="color:red;font-size:8pt;text-align:center;">Los Campos Marcados en * son Obligatorios.</p>
                <!-- <div class="col-md-6"><button class="regBtn" type="button" onclick="$('#loginForm').hide();$('#recPassForm').hide();$('#regForm').show();">Registrarme</button></div> -->
            </div>
            <!--LOGIN REGISTRATION BTNS ENDS-->
       <!-- REGISTRATION FORM -->
       <form id="regForm">
       <div class="row input_field">
           <div class="col-md-12"><input required data-parsley-required-message="Su correo electrónico es mandatorio" type="email" name="client_email" placeholder="* Correo electronico"></div>
       </div>
       <div class="row input_field">
           <div class="col-md-6" style="padding-right:2px;"><input required data-parsley-required-message="Su nombre es mandatorio" type="text" name="client_names" placeholder="* Nombres"></div>
           <div class="col-md-6" style="padding-left:2px;"><input required data-parsley-required-message="Su apellido es mandatorio" type="text" name="client_lastnames" placeholder="* Apellidos"></div>
       </div>
       
       <div class="row input_field">
           <div class="col-md-6" style="padding-right:2px;"><input type="text" name="client_phone" placeholder="Teléfono fijo"></div>
           <div class="col-md-6" style="padding-left:2px;"><input type="text" name="client_mobile" placeholder="Teléfono móvil"></div>
       </div>
       <div class="row input_field">
           <div class="col-md-12"><input id="pw" required data-parsley-required-message="Porfavor elija una contraseña" type="password" name="client_pass" placeholder="* Contraseña"></div>
       </div>
       <div class="row input_field">
           <div class="col-md-12"><input required data-parsley-equalto="#pw" data-parsley-required-message="Porfavor confirme su clave" type="password" placeholder="* Confirmar contraseña"></div>
       </div>
       <div class="row input_field">
           <div class="col-md-12"><input required data-parsley-required-message="Su cédula o NIT es mandatorio" type="text" name="client_nit" placeholder="* Nit o Cédula del Tercero a Asociar"></div>
       </div>
       <div class="row input_field">
           <div class="col-md-12"><button type="button" class="regSubBtn">Registrarse</button></div>
       </div>
       
   </form>
   <!--REGISTRATION FORM ENDS-->
             <!--PASSWORD RECOVERY FORM -->
            <form id="recPassForm">
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-required-message="Su correo electronico es mandatorio" type="email" name="client_email" placeholder="* Su correo electronico"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><button type="button" class="recuPassSubmitBtn">Enviar</button></div>
                </div>
            </form>
        <!--PASSWORD RECOVERY FORM ENDS -->
            <div class="row">
                <div style="border-top:1px solid #ccc;" class="col-md-12">
                    <p style="text-align:center;padding:10px;"><a class="closeRegBtn" href="#" onclick="$('.formContainer').fadeOut();">Cerrar</a></p>
                </div>
            </div>
      </div>
      <!--REGISTRATION FORM ENDS-->





        <!--MAIN CONTENT BEGINS -->
        <div class="mainContent row">

            <div class="col-md-6">
                <div class="stkContainer row"><!--STOCK TABLE -->
                    <div class="col-md-4">

                        <div class="stkTitle col-md-12">
                            <h4><i class="fa fa-money" aria-hidden="true"></i> DIVISAS</h4>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <small>Dolar TRM </small>
                            </div>
                            <div class="col-md-6">
                                <small>$2,911.66 <i class="triaPositivo glyphicon glyphicon-triangle-top"></i></small>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>Euro </small>
                            </div>
                            <div class="col-md-6">
                                <small>$3,270.00 <i class="triaPositivo glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>Bolivar (BanRep)</small>
                            </div>
                            <div class="col-md-6">
                                <small>$291,46 <i class="triaNegativo glyphicon glyphicon-triangle-bottom"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>Boliver (Cucuta)</small>
                            </div>
                            <div class="col-md-6">
                                <small>$0.53 <i class="triaNeutral glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="col-md-12 stkTitle">
                            <h4><i class="fa fa-usd" aria-hidden="true"></i> TASAS DE INTERES</h4>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <small>Cafe lb. (Sep. 2017)</small>
                            </div>
                            <div class="col-md-6">
                                <small>USD$1,365 <i class="triaPositivo glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>U.V.R</small>
                            </div>
                            <div class="col-md-6">
                                <small>$250.1155 <i class="triaPositivo glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>DTF</small>
                            </div>
                            <div class="col-md-6">
                                <small>6.17% <i class="triaNeutral glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>Petroleo WTI</small>
                            </div>
                            <div class="col-md-6">
                                <small>USD$48.90 <i class="triaNegativo glyphicon glyphicon-triangle-bottom"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>Usura</small>
                            </div>
                            <div class="col-md-6">
                                <small>33.5% <i class="triaPositivo glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">

                        <div class="col-md-12 stkTitle">
                            <h4><i class="fa fa-briefcase" aria-hidden="true"></i> OTROS</h4>
                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <small>COLCAP</small>
                            </div>
                            <div class="col-md-6">
                                <small>1,444.39 <i class="triaNegativo glyphicon glyphicon-triangle-bottom"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>IBR</small>
                            </div>
                            <div class="col-md-6">
                                <small>6.217% <i class="triaPositivo glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <small>Inflacion (Abr-2017)</small>
                            </div>
                            <div class="col-md-6">
                                <small>0.47% <i class="trianeutral glyphicon glyphicon-triangle-top"></i></small>
                            </div>
                        </div>


                    </div>

                </div>

            </div><!--STOCK TABLE ENDS-->

            <div class="col-md-6 mainTitleContainer">
                <h3 class="mainTitle">Nunca la información de sus proveedores, clientes y empleados estuvo tan cerca!</h3>
                <div class="row" style="position:relative;margin:0px !important;padding:0px !important">
                    <div class="col-md-3" style="margin:0px !important;padding:0px !important">
                        <button class="registrarseBtn" type="button" onclick="$('.formContainer').fadeIn();$('.log_box_title b').text('Formulario de Registro');">No se ha Registrado?</button>
                        
                    </div>
                    <div class="col-md-6" style="margin:0px !important;padding:0px !important">
                    <button class="signInBtn" type="button" onclick="window.location.href='login.php'">Ingreso de Usuarios Registrados <i class="fa fa-lock" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

        </div>
       

        <div class="row otherLinks"><!--PARTNERS -->
            <h3 style="">Links de Interes</h3>
            <div class="col-md-2"></div>
            <div class="col-md-2"><a target="blank" href="http://www.sqlsoluciones.com"><img src="img/sql.png" alt=""></a></div>
            <div class="col-md-2"><a target="blank" href="http://www.supersociedades.gov.co/"><img src="img/super.png" alt=""></a></div>
            <div class="col-md-2"><a target="blank" href="http://www.dian.gov.co/"><img src="img/dian.png" alt=""></a></div>
            <div class="col-md-2"><a target="blank" href="http://www.banrep.gov.co/"><img class="bancoRepImg" src="img/BancoRepublica.png" alt=""></a></div>
            <div class="col-md-2"></div>
            
        </div><!--PARTNERS ENDS-->
    </div>
    <!--MAIN CONTENT ENDS-->

   <footer style="text-align: center;padding: 13px;border-top: 1px solid darkred;width:50%;margin:auto;">
        <img style="width:100px;" src="img/watermark.png" alt="">
        <p style="color: black;font-size:10pt;">&copy;2017. Todos los derechos reservados.</p>
    </footer>

   

<?php include 'includes/footer.inc.php';?>

 <script>//CUSTOM SCRIPT
   

       $(".regSubBtn").on('click', function(){
           var valid = $('#regForm').parsley().validate();
            console.log(valid);
           if(valid)
           {
                var data = $("#regForm").serialize();
                console.log(data);
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

       $("#login-dialog-modal").on('click','.recuPassBtn', function(){
           $("#login-dialog-modal").dialog("close");
           //$("#regForm").hide();
           //$(".log_box_title b").text('Enviar contraseña');
           //$("#recPassForm").show();
           var email = $('#regForm').find('input[type="email"]').val();
           $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=pass&client_email="+email,
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
                        
                    }
                }
            });
           

       });
      


       
    </script>
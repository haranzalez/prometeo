<?php include 'includes/header.inc.php';?>
<body>

    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-9" style="border-right:dotted orangered 1px;">
                    <div class="row">
                        <div class="col-md-2"><img src="img/logo_ppal.png" alt=""></div>
                        <div class="col-md-10"></div>
                    </div>

                </div>

                <div class="col-md-2"><button class="signInBtn" type="button" onclick="window.location.href='login.php'"><i class="glyphicon glyphicon-lock"></i> Acceso</button></div>
            </div>
        </div>

        <div class="row subHead">
            <div class="col-md-12">
                <ul class="navLinks ">
                    <li><i class="fa fa-users" aria-hidden="true"></i> Quienes Somos</li>
                    <li><i class="fa fa-gavel" aria-hidden="true"></i> Normatividad</li>
                    <li><i class="fa fa-phone" aria-hidden="true"></i> Contactenos</li>
                </ul>
            </div>
        </div>

        <!--REGISTRATION FORM BEGINS-->
        <div class="formContainer">
        <div class="row">
            <div class="col-md-12 regTitle"><h2 style="text-align:center;">Crear tu cuenta</h2></div>
        </div>
        <form id="regFormMainPage">
                <div class="row input_field">
                    <div class="col-md-6" style="padding-right:2px;"><input required type="text" name="client_names" placeholder="Nombres" data-parsley-required-message="Su nombre es mandatorio"></div>
                    <div class="col-md-6" style="padding-left:2px;"><input required type="text" name="client_lastnames" placeholder="Apellidos" data-parsley-required-message="Su apellido es mandatorio"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-required-message="Su correo electronico es mandatorio" type="email" name="client_email" placeholder="Correo electronico"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-6" style="padding-right:2px;"><input type="text" name="client_phone" placeholder="Telefono fijo"></div>
                    <div class="col-md-6" style="padding-left:2px;"><input type="text" name="client_mobile" placeholder="Telefono mobil"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input data-parsley-required-message="Porfavor elija una clave para su cuenta" required type="password" name="client_pass" placeholder="Contrasena"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input required data-parsley-required-message="Se requiere que confirme su clave" type="password" placeholder="Confirmar contrasena"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><input required required data-parsley-required-message="Su cedula o NIT es mandatorio" type="text" name="client_nit" placeholder="Nit de empresa"></div>
                </div>
                <div class="row input_field">
                    <div class="col-md-12"><button type="button" class="regSubBtn">Registrarse</button></div>
                </div>
                 <div class="row input_field">
                    <div class="col-md-12"><p class="mess" style="text-align:center;padding-top:10px;"></p></div>
                </div>
            </form>
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
                <h2 class="mainTitle">Nunca la información de sus proveedores, clientes y empleados estuvo tan cerca!</h2>
                <div class="row" style="position:relative;"><button class="registrarseBtn" type="button" onclick="$('.formContainer').fadeIn();">Registrarse <i class="fa fa-user-plus" aria-hidden="true"></i></button></div>
            </div>

        </div>

        <div class="row otherLinks"><!--PARTNERS -->
            <h2 style="">Links de Interes</h2>
            <div class="col-md-4"><img src="img/logoSuperintendenci.png" alt=""></div>
            <div class="col-md-4"><img class="bancoRepImg" src="img/BancoRepublica.png" alt=""></div>
            <div class="col-md-4">
                <h4>SQL Soluciones Informaticas</h4>
            </div>
        </div><!--PARTNERS ENDS-->
    </div>
    <!--MAIN CONTENT ENDS-->

   <footer style="text-align: center; padding:15px;border-top:1px solid #ccc;width:50%;margin:auto;">
        <img style="width:150px;" src="img/watermark.png" alt="">
        <p style="color: #C0C5CB">&copy;2017. Todos los derechos reservados.</p>
    </footer>

   

<?php include 'includes/footer.inc.php';?>

 <script>//CUSTOM SCRIPT
    $(".regSubBtn").on('click', function(){
        var valid = $('#regFormMainPage').parsley().validate();
        if(valid)
        {
             var data = $("#regFormMainPage").serialize();
            $.ajax({
                data: data,
                async: true,
                type: "post",
                url: "src/controler.php?req=regi",
                success: function(res) {
                    if(res == 1)
                    {
                        $('.mess').html('Registro exitoso! Porfavor reviza tu email para activar tu cuenta, o si no lo has recibido has click <a href="#">aqui<a/>').css('color','green');
                    }else{
                        $('.mess').html("Al parecer su email ya esta en uso. Porfavor proceda a iniciar sesion, o si olvido su contrasena recuperela <a href=''>aqui.</a>").css('color','red');
                        console.log(res);
                    }
                }
            });
            
        }
       
       });

       
    </script>
<?php include 'includes/header.inc.php';?>
    
    
    <style>
        body {
            background-color: #eee;
        }
        
        .mainCtn {
            background-image: url('img/bgCont.jpg');
            background-size: cover;
            width: 100%;
            padding: 20px 0px;
            background-attachment: fixed;
        }
        
        #contact_form {
            width: 500px;
            margin: auto;
            position: relative;
            padding: 20px 0px;
            border-radius: 3px;
            font-size: 10pt;
            box-shadow: 0px 1px 2px #aaa;
            background-color: rgba(255, 255, 255, .9);
            
        }
        
        #contact_form form p {
            margin-bottom: 0px !important;
            width: 100%;
        }
        
        #contact_form form {
            width: 85%;
            margin: auto;
        }
        
        #contact_form .intro,
        #contact_form h3 {
            width: 85%;
            margin: auto;
            margin-bottom: 10px;
        }
        
        #contact_form .intro {
            line-height: 1.2;
        }
        
        #contact_form input[type="text"],
        #contact_form input[type="email"],
        #contact_form textarea {
            width: 100%;
            padding-left: 7px;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }
        
        #contact_form input[type="text"]:focus,
        #contact_form input[type="email"]:focus,
        #contact_form textarea:focus {
            outline: none;
            border: 1px solid darkred;
        }
        
        #contact_form .sendBtn {
            color: white;
            background-color: darkred;
            border: none;
            border-radius: 3px;
            padding: 7px;
            outline: none;
        }
        
        #contact_form textarea {
            min-height: 100px;
        }
        #dialog-message .dialog_mess {
            font-size: 10pt;
            padding-top: 10px !important;
            padding-right: 0px !important;
            line-height: 1;
            /* width: 240px; */
            display: block;
            margin: auto;
            margin-left: 35;
        }
        
        .headerCtn {
            padding: 10px;
            background-color: #FFCC66;
            border-bottom: solid 1px darkred;
            text-align: center;
        }
        
        .headerCtn p {
            width: 800px;
            margin: auto;
            text-align: center;
            margin-bottom: 7px;
        }
        
        .headerCtn p {
            font-size: 10pt;
            line-height: 1.2;
        }
        
        .arrow-down {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 15px solid #F6F3F6;
            right: 50%;
            top: 146px;
            z-index: 20;
        }
        
        .headerCtn img {
            width: 180px;
        }
        
        .logoTitulo {
            width: 50%;
            margin: auto;
        }
    </style>
</head>

<body>
<div id="dialog-message" > 
    </div>
    <div class="header">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-2"><img src="img/logo_ppal.png" alt="">
                        <p style="font-size: 6pt;text-align: center;margin-left: 18px;margin-top: -6;width: 160;padding: 0px !important;">Un Producto SQL SOLUCIONES INFORMATICAS SAS</p>
                    </div>
                    <div class="col-md-10">
                        <p style="text-align:center;width: 280px;margin: auto;margin-top: 10px;font-size:8pt;color:black;">
                            SQL SOLUCIONES INFORMATICAS SAS<br/> Tel: (572) 5242436<br/>
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
    <div class="mainCtn">
        <div id="contact_form"></div>
    </div>

    <footer style="text-align: center;padding: 13px;border-top: 1px solid darkred;width:50%;margin:auto;">
        <p style="color: black;font-size:10pt;">&copy;2017 Prometeo. Todos los derechos reservados.</p>
    </footer>
    <?php include 'includes/footer.inc.php';?>
   
<script>
    formulario('contact_form');
    $('#contact_form').on('click','.sendBtn', function(){
        console.log('click');
        var data = $('#contact_form form').serialize();
       
        messageEmail(data);
        
    });

    function messageEmail(data) {
        console.log(data);
        var valid = $('#contact_form').find('form').parsley().validate();
        if(valid){
            $.ajax({
                data: data,
                async: true,
                type: 'post',
                url: 'src/controler.php?req=contactEmail',
                success: function(res) {
                    console.log(res);
                    if(res == 1){
                        var iconStyle = 'font-size:25pt;color:darkgreen;float:left;';
                        $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-check" aria-hidden="true"></spam><p class="dialog_mess">Su mensaje se ah enviado exitosamente. Estaremos en contacto con usted lo mas pronto posible.</p>');
                        $("#dialog-message").dialog({
                            modal: true,
                            title: 'Gracias por su interes!',
                            buttons: {
                                Ok: function() {
                                    $('#contact_form form')[0].reset();
                                    $(this).dialog("close");
                                }
                            }
                        });
                    }else if(res == 2){
                        var iconStyle = 'font-size:25pt;color:darkred;float:left;';
                        $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-android" aria-hidden="true"></spam><p class="dialog_mess">Porfavor compruebe que no es un robot</p>');
                        $("#dialog-message").dialog({
                            modal: true,
                            title: 'BOT!',
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
        
    }

    function formulario(formId) {
        var html = '<h3>Contactenos<b style="color:darkred;">.</b></h3><p class="intro">Gracias por su interes en Prometeo. Porfavor use este formulario si tiene alguna pregunta acerca de nuestro producto y nos comunicaremos de vuelta lo mas pronto posible</p>';
        html = html + '<form>' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<p><b style="color:darkred;">*</b>Correo Electronico:</p>' +
            '<input required data-parsley-required-message="Su email es requerido" type="email" name="email">' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-6">' +
            '<p><b style="color:darkred;">*</b>Nombre:</p>' +
            '<input required data-parsley-required-message="Su nombre es requerido" type="text" name="name">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<p><b style="color:darkred;">*</b>Apellido:</p>' +
            '<input required data-parsley-required-message="Su apellido es requerido" type="text" name="lastname">' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<p>Telefono Fijo:</p>' +
            '<input type="text" name="tel">' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<p>Telefono Movil:</p>' +
            '<input type="text" name="mobile">' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<p><b style="color:darkred;">*</b>Comentario o Inquietud:</p>' +
            '<textarea required data-parsley-required-message="Sus comentarios son requeridos" name="message"></textarea>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<div class="g-recaptcha" data-sitekey="6LdEcTEUAAAAAJUyuhazGxJP0vrX04kt7ozbJADI" data-callback="captchaCallback"></div>' +
            '</div>' +
            '</div><br/>' +
            '<div class="row">' +

            '<div class="col-md-12">' +

            '<button type="button" class="sendBtn">Enviar</button>  ' +
            '<input type="checkbox" name="copyEmail"> <spam>Enviar copia a mi correo</spam>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +

            '<div class="col-md-12">' +

            '<p style="text-align:center;margin-top:10px;color:#888;">Los campos marcados con <b style="color:darkred;">*</b> son mandatorios.'
        '</div>' +
        '</div>' +
        '</form>';

        var contact_form = document.getElementById(formId);
        contact_form.innerHTML = html;
    }

    

    
</script>

</body>


</html>
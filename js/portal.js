/*!
 * portal.js
 * Version BETA 
 * Hans Christian Aranzalez - <haranzalez@gmail.com>
 */
init();
client_info()
folder_setup();
//info_y_contacto_de_empresa();
//FUNCIONES CORRELATIVAS
//JQUERY UI
//toggle function on click jQuery plug in
(function($) {
    $.fn.clickToggle = function(func1, func2) {
        var funcs = [func1, func2];
        this.data('toggleclicked', 0);
        this.click(function() {
            var data = $(this).data();
            var tc = data.toggleclicked;
            $.proxy(funcs[tc], this)();
            data.toggleclicked = (tc + 1) % 2;
        });
        return this;
    };
}(jQuery));
//toggle function on click jQuery plug in
var siteURI = "http://www.sqlprometeo.com/";
//FUNCIONES UI

//NAVEGACION

$('.portalNavEmpBtn').button().on('click', function(e) {
    e.preventDefault();
    var dpb = $(this).attr('data-empresa');
    if (dpb = 'empVinculadas') {
        document.body.style.backgroundColor = '#FFCC66';
        empresas_vinculadas('cert');

        $('.slogan').fadeIn();
        $('.logoPortal').fadeIn();
    }
});
$('.fileContainer').button().on('click', '.portalNavEmpBtn', function(e) {
    e.preventDefault();
    var dpb = $(this).attr('data-empresa');
    if (dpb = 'empVinculadas') {
        document.body.style.backgroundColor = '#FFCC66';
        empresas_vinculadas('cert');

        $('.slogan').fadeIn();
        $('.logoPortal').fadeIn();
    }
});

$('.portalNavDocBtn').button().on('click', function(e) {
    e.preventDefault();
    var dpb = $(this).attr('data-empresa');
    if (dpb = 'documents') {
        document.body.style.backgroundColor = '#FFCC66';
        open_folder('Bandeja de entrada');

        $('.slogan').fadeIn();
        $('.logoPortal').fadeIn();
    }
});
$('.folderList').button().on('click', '.portalNavDocBtn', function(e) {
    e.preventDefault();
    var dpb = $(this).attr('data-empresa');
    if (dpb = 'documents') {
        document.body.style.backgroundColor = '#FFCC66';
        open_folder('Bandeja de entrada');

        $('.slogan').fadeIn();
        $('.logoPortal').fadeIn();
    }
});

$('.portalNavCambiarDatosBtn').button().on('click', function(e) {
    e.preventDefault();
    clearAll();
    datos_usuario();
    $('.slogan').fadeIn();
    $('.logoPortal').fadeIn();
});
$('.portalNavEmpInfoBtn').button().on('click', function(e) {
    e.preventDefault();
    clearAll();
    empresas_vinculadas('infoEmp');
    $('.slogan').fadeIn();
    $('.logoPortal').fadeIn();
});

$('.fileContainer').button().on('click', '.newDocumBtn', function(e) {
    e.preventDefault();
    document.body.style.backgroundColor = '#FFCC66';
    empresas_vinculadas('cert');
});
//NAVEGACION END

//DASH FUNCTIONS
$('.dash').button().on('click', '.perCtner .period', function(e) {
    e.preventDefault();
    $('.period i').hide();
    $(this).focus();
    $(this).find('i').show();
    var mesini = $(this).find('.mes_inicial').text();
    var mesfin = $(this).find('.mes_final').text();
    $('.generar_certificado_boton .imprimirBtn').attr('data-mesini', mesini);
    $('.generar_certificado_boton .imprimirBtn').attr('data-mesfin', mesfin);
    $('.generar_certificado_boton .guardarBtn').attr('data-mesini', mesini);
    $('.generar_certificado_boton .guardarBtn').attr('data-mesfin', mesfin);
    $('.selPerMess').hide();
    $('.generar_certificado_boton .imprimirBtn').show();
    $('.generar_certificado_boton .pdfBtn').show();
    $('.generar_certificado_boton .guardarBtn').show();
});

$('.dash').button().on('click', '.formatoCtner .formato', function(e) {
    e.preventDefault();
    $('.formato i').hide();
    $(this).focus();
    $(this).find('i').show();
    var id_emp = $(this).attr('data-idemp');
    var codigo_formato = $(this).attr('data-codigoFormato');
    periodos(id_emp, codigo_formato);
    $('.generar_certificado_boton .imprimirBtn').attr('data-codform', $(this).attr('data-codigoFormato'));
    $('.generar_certificado_boton .guardarBtn').attr('data-codform', $(this).attr('data-codigoFormato'));
});

$('.dash').button().on('click', '.empBox', function(e) {
    e.preventDefault();
    $('.empresas_contenedor').hide();
    generar_datos_de_empresa($(this), 'infoEmp');
    // $('.headerPortal').find('.logoPortal').hide();
    // $('.headerPortal').find('.slogan').hide();

});


//GENERAR CERTIFICADO BTN
$(".dash").button().on('click', '.datos_de_empresa .generar_certificado_boton .imprimirBtn', function(e) {
    e.preventDefault();
    $('.generar_certificado_boton .imprimirBtn').html('<i style="font-size:18pt !important;" class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');
    var formato = $(this).attr('data-codform');
    var mesini = $(this).attr('data-mesini');
    var mesfin = $(this).attr('data-mesfin');
    var nit_empresa = $(this).attr('data-nitempresa');
    generar_certificado(formato, mesini, mesfin, nit_empresa);

});

$('.pdfBtn').button().on('click', function(e) {
    e.preventDefault();
    var html = document.getElementsByClassName('certificado')[0];

});
//GUARDAR CERTIFICADO
$('.dash').button().on('click', '.datos_de_empresa .generar_certificado_boton .guardarBtn', function(e) {
    e.preventDefault();
    guardar_certificado();
});

//FUNCIONES MANEJO DE DOCUMENTOS
$('.folderlist').button().on("click", '.mainFolderFileList .newFolderBtn', function(e) {
    e.preventDefault();
    $('#formDialog form fieldset').html('<p>Escriba nombre para nueva carpeta</p><input required data-parsley-required-message="Se nescesita un nombre." type="text" name="folderName" id="folderName" class="text ui-widget-content ui-corner-all"><input type="submit" tabindex="-1" style="position:absolute; top:-1000px">');
    dialog = $("#formDialog").dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        title: 'Nuevo Folder',
        modal: true,
        buttons: {
            "Crear Folder": crearFolder,
            "Cancelar": function() {
                dialog.dialog("close");
            }
        },
        close: function() {
            form[0].reset();
        }
    });
    form = dialog.find("form").on("submit", function(event) {
        event.preventDefault();
        crearFolder();
        dialog.dialog("close");
    });
    dialog.dialog("open");

    function crearFolder() {
        var valid = dialog.find('form').parsley().validate();
        if (valid) {
            var data = dialog.find("form").serialize();
            var iconStyle = 'font-size:25pt;color:darkred;float:left;';
            console.log(data);
            $.ajax({
                async: true,
                type: 'get',
                url: 'src/controler.php?req=newFold&' + data,
                success: function(res) {
                    if (res == 1) {
                        dialog.dialog("close");
                        renderFiles('cp');
                        open_folder('Bandeja de entrada');
                    } else {
                        $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-times-circle-o" aria-hidden="true"></spam><p class="dialog_mess">Folder ya existe.</p>');
                        $("#dialog-message").dialog({
                            modal: true,
                            title: 'Atencion',
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
});

$('.folderlist').button().on('click', '.folderBtn', function(e) {
    e.preventDefault();
    var data = $(this).attr('data-folder');
    open_folder(data);
});

$('.fileContainer').button().on('click', '.folderBtn', function(e) {
    e.preventDefault();
    var data = $(this).attr('data-folder');

    open_folder(data);
});

$('.fileContainer').button().on('click', '.delfile', function(e) {
    e.preventDefault();
    var fname = $(this).attr('data-fname');
    var fnum = $(this).attr('data-fnum');
    var docid = $(this).attr('data-docid');

    del_file(fnum, fname, docid);
});

$('.folderList').button().on('click', '.toggleFolderListBtn', function(e) {
    e.preventDefault();
    $('.folderList').find('.mainFolderFileList').show();
});

$('.cambiarDatosFormCtnr').button().on('click', '.edit', function(e) {
    e.preventDefault();
    var field = $(this).attr('data-field');
    var col = $(this).attr('data-col');
    var id = $(this).attr('data-cid');
    var mess = "<p>Entre su nuevo " + field + ".</p>";
    var dialHeight = 160;
    $('.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset').css('margin-top', '.7em');

    $('#formDialog form fieldset').html(mess + '<input required data-parsley-required-message="Se requiere su nuevo ' + field + '." type="text" name="' + col + '" class="text ui-widget-content ui-corner-all"><input type="submit" tabindex="-1" style="position:absolute; top:-1000px">');
    dialog = $("#formDialog").dialog({
        autoOpen: false,
        height: dialHeight,
        width: 350,
        title: 'Editando ' + field,
        modal: true,
        buttons: {
            "Cambiar": function() {
                var newd = $("#formDialog form").serialize();
                console.log(newd);
                editar_dato_usuario(newd, id);

            },
            "Cancelar": function() {
                dialog.dialog("close");
            }
        },
        close: function() {
            form = dialog.find('form');
            form[0].reset();
        }
    });
    dialog.dialog("open");

    function editar_dato_usuario(data, id) {
        var valid = dialog.find('form').parsley().validate();
        if (valid) {
            dialog.dialog("close");
            $('.loadingCtn').show();
            var newd = data.split('=');
            var s = newd[0] + "='" + newd[1] + "'";

            var obj = { key: newd[0], d: newd[1], field: s };
            $.ajax({
                async: true,
                type: 'post',
                data: { obj: JSON.stringify(obj) },
                url: 'src/controler.php?req=edituser',
                success: function(res) {
                    console.log(res);
                    if (res == 1) {
                        if (obj.key == 'client_name' || obj.key == 'client_lastname' || obj.key == 'client_email') {
                            client_info();
                        }
                        $('.loadingCtn').fadeOut();
                        var iconStyle = 'font-size:18pt;color:green;float:left;';
                        $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess"> Su información Ha sido Actualizada exitosamente!</p>');
                        $("#dialog-message").dialog({
                            modal: true,
                            title: 'Exito!',
                            buttons: {
                                Ok: function() {
                                    // if (obj.key == 'client_cedula' || obj.key == 'client_email') {
                                    //     $(this).dialog("close");
                                    //     $('.loadingCtn p').text('Cerrando sesión');
                                    //     $('.loadingCtn').show();
                                    //     setTimeout(function() {
                                    //         var url = window.location.href;
                                    //         console.log(url);
                                    //         if (url.indexOf('?') > -1) {
                                    //             url += '&param=1'
                                    //         } else {
                                    //             if (url.charAt[-1] == '#') {
                                    //                 url.substring(0, url.length - 1);
                                    //             }
                                    //             url += '?logout=true'
                                    //         }
                                    //         window.location.href = url;
                                    //     }, 3000);

                                    // } else {

                                    client_info()
                                    datos_usuario();
                                    location.reload();

                                    $(this).dialog("close");
                                    //}

                                }
                            }
                        });

                    }


                }
            });
        }



    }


});

$('.cambiarDatosFormCtnr').on('click', '.ctn .cambiarClaveBtn', function() {
    var inputStyle = "";
    $('#formDialog form fieldset').html('<p>Porfavor llene los siguientes campos</p>' +
        '<input required data-parsley-required-message="Su clave reciente es nescesaria." style="' + inputStyle + '" placeholder="Su clave reciente" type="password" name="oldpass" class="text ui-widget-content ui-corner-all">' +
        '<input id="editDatosPass" required data-parsley-required-message="Su nueva clave es nescesaria." style="' + inputStyle + '" type="password" placeholder="Su NUEVA clave" name="newpass" class="text ui-widget-content ui-corner-all">' +
        '<input required data-parsley-required-message="Confirme su nueva contraseña." data-parsley-equalto="#editDatosPass"	 style="' + inputStyle + '" type="password" placeholder="Reingresar NUEVA clave" name="newpassconfi" class="text ui-widget-content ui-corner-all">' +
        '<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">');
    dialog = $("#formDialog").dialog({
        autoOpen: false,
        height: 260,
        width: 350,
        title: 'Cambio de contraseña',
        modal: true,
        buttons: {
            "Cambiar": function() {
                var valid = dialog.find('form').parsley().validate();
                if (valid) {
                    cambiar_clave();
                    dialog.dialog("close");
                }
                console.log(valid);


            },
            Cancel: function() {
                dialog.dialog("close");
            }
        },
        close: function() {
            form = dialog.find('form');
            form[0].reset();
        }
    });
    dialog.dialog("open");

    function cambiar_clave() {
        var newpassdata = dialog.find('form').serialize();
        console.log(newpassdata);
        $('.loadingCtn').show();
        $.ajax({
            async: true,
            type: 'post',
            data: newpassdata,
            url: 'src/controler.php?req=changepass',
            success: function(res) {
                console.log(res);
                if (res == true) {
                    $('.loadingCtn').fadeOut();
                    var iconStyle = 'font-size:18pt;color:green;float:left;';
                    $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess"> Su clave se ah actualizado exitosamente! Un mensaje se ah enviado a su correo electronico confirmando sus cambios.</p>');
                    $("#dialog-message").dialog({
                        modal: true,
                        title: 'Exito!',
                        buttons: {
                            Ok: function() {
                                datos_usuario()
                                $(this).dialog("close");
                            }
                        }
                    });

                } else {
                    $('.loadingCtn').fadeOut();
                    var iconStyle = 'font-size:18pt;color:darkred;float:left;';
                    $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-times" aria-hidden="true"></spam><p class="dialog_mess"> Su clave reciente no es correcta. Porfavor trate de nuevo.</p>');
                    $("#dialog-message").dialog({
                        modal: true,
                        title: 'Atencion!',
                        buttons: {
                            Ok: function() {
                                datos_usuario()
                                $(this).dialog("close");
                            }
                        }
                    });
                }
            }
        });


    }
});




/*************** FUNCIONES **********************/
//FUNCIONES COMPLEMENTARIAS
function init() {

}

function hexToBase64(rstr) {

    if (rstr != false) {
        var str = escape(rstr);
        return btoa(String.fromCharCode.apply(null, str.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" ")));
    } else {
        return 'http://placehold.it/50x50';
    }

}


function tdate() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var today = dd + '/' + mm + '/' + yyyy;
    return today;
}

function PrintElem() {
    var elem = document.getElementsByClassName('modal-body')[0];
    dimsW = 900;
    dimsH = 665;
    var x = screen.width / 2 - dimsW / 2;
    var y = screen.height / 2 - dimsH / 2;
    var mywindow = window.open('', 'PRINT', 'height=' + dimsH + ',width=' + dimsW + ',left=' + x + ',top=' + y);

    mywindow.document.write('<html><head><title>PROMETEO - CERTIFICADO</title>');
    mywindow.document.write('<link rel="stylesheet" href="' + siteURI + 'css/certificado.css"><link rel="stylesheet" href="' + siteURI + 'css/bootstrap.css"><link rel="stylesheet" href="' + siteURI + '/promTest/css/font-awesome.css">');
    mywindow.document.write('</head><body>');
    mywindow.document.write(elem.innerHTML);
    mywindow.document.write('<script src="' + siteURI + 'js/jquery-3.2.1.js"><\/script>' +
        '<script src="' + siteURI + 'js/bootstrap.js"><\/script>' +
        '<script src="' + siteURI + 'js/jspdf.js"><\/script>' +
        '<script src="' + siteURI + 'js/html2canvas.js"><\/script>' +
        '<script src="' + siteURI + 'js/main.js?newversion"><\/script>');
    mywindow.document.write('</body></html>');


    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;

}

function clearAll() {
    $('.empresas_vinculadas_ctnr').remove();
    $('.empresas_contenedor .row').remove();
    $('.fileContainer').hide();
    $('.fileContainer div').remove();
    $('.fileContainer h4').remove();
    $('.fileContainer .filesBtnContainer').remove();
    $('.empresas_contenedor').hide();
    $('.cambiarDatosFormCtnr').hide();


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

//FUNCIONES AJAX
function empresas_vinculadas(type) {

    if (type == 'cert') {
        $('.dash .empresas_contenedor .secTitle').text('Seleccione una empresa para empezar');
    } else if (type == 'infoEmp') {
        $('.dash .empresas_contenedor .secTitle').text('Empresas vinculadas');
    }
    $('.loadingCtn').show();
    clearAll();
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=empvin",
        success: function(res) {
            $(".portalNavBtn[data-nav=1]").focus();
            console.log(res);
            var d = JSON.parse(res);
            console.log(d);
            if (d.length > 0) {
                for (var i = 0; i < d.length; i++) {
                    console.log(d[i].nmbre_dpto);
                    var img = 'data:image/jpeg;base64,' + hexToBase64(d[i].lgtpo_emprsa);

                    var html = '<div class="row">' +
                        '<div class="col-md-12 empBox " data-infoType="' + type + '"><div class="row">' +
                        '<div class="col-md-1"><div class="emVincImg" style="background-image:url(' + img + ')"></div></div><div class="col-md-11"><p class="nitEmp" data-razonSocial="' + d[i].nmbre_rzon_scial + '" data-nit="' + d[i].id_emprsa + '" data-color="' + d[i].cdgo_color + '"><b>' + d[i].nmbre_rzon_scial + '</b>' +
                        ' | NIT: ' + d[i].id_emprsa.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' | ' + d[i].drccion + ', ' + d[i].nmbre_mncpio + ', ' + d[i].nmbre_pais + ' | ' + d[i].web_site + '</p></div>' +

                        '</div>' +
                        '<input type="hidden" class="nit_empresa" value="' + d[i].id_emprsa + '">' +
                        '<input type="hidden" class="dirEmpresa" value="' + d[i].drccion + '">' +
                        '<input type="hidden" class="paisEmpresa" value="' + d[i].nmbre_pais + '">' +
                        '<input type="hidden" class="depEmpresa" value="' + d[i].nmbre_dpto + '">' +
                        '<input type="hidden" class="municipioEmpresa" value="' + d[i].nmbre_mncpio + '">' +
                        '<input type="hidden" class="contEmpresa" value="' + d[i].nmbre_cntcto + '">' +
                        '<input type="hidden" class="telEmpresa" value="' + d[i].tlfno_fjo + '">' +
                        '<input type="hidden" class="mobilEmpresa" value="' + d[i].tlfno_mvil + '">' +
                        '<input type="hidden" class="webEmpresa" value="' + d[i].web_site + '">' +
                        '<input type="hidden" class="logo_empresa" value="' + d[i].lgtpo_emprsa + '">' +
                        '<input type="hidden" class="emContEmpresa" value="' + d[i].email_cntcto + '">' +

                        '</div>' +
                        '</div>';



                    $('.logoPortal').attr('src', 'img/logo_ppal.png');
                    $('.empresas_contenedor .empRowCtnr').append(html);

                }
                $('.empresas_contenedor').fadeIn();
                $('.loadingCtn').fadeOut();
            } else {
                var html = '<div class="row">' +
                    '<div class="col-md-12 empBox "><p style="font-size:15;text-align:center;"><i class="fa fa-times" aria-hidden="true"></i>  No hay empresas vinculadas.</p></div></div>';
                $('.logoPortal').attr('src', 'img/logo_ppal.png');
                $('.empresas_contenedor .empRowCtnr').append(html);
                $('.empresas_contenedor').fadeIn();
                $('.loadingCtn').fadeOut();
            }
        }
    });

}

function generar_datos_de_empresa(el) {
    $('.empresas_contenedor').fadeOut();

    $('.datos_empresa_contenedor').remove();
    var color = $(el).find('p').attr('data-color');
    var colorFinal = color.slice(0, -3);
    var imgData = $(el).find('.logo_empresa').val();
    var img = 'data:image/jpeg;base64,' + hexToBase64(imgData);
    var type = $(el).attr('data-infoType');
    document.body.style.backgroundColor = colorFinal;
    console.log(el);
    if (type == 'cert') {

        var html = '<div style="padding-top:20px !important;width:95%;margin:auto !important;" class="row empresas_vinculadas_ctnr"><div class="col-md-6">' +
            '<div class="logoEmpCtnr">' +
            '<span style="display: inline-block;height: 100%;vertical-align: middle;"></span><img style="width:100px;" src="' + img + '">' +
            '</div>' +
            '</div>' +

            '<div class="col-md-6">' +
            '<div class="datos_empresa_contenedor">' +

            '<div class="datos_de_empresa">' +

            '<div class="datosEmpresa">' +
            '<h4 class="secH4">Datos de empresa</h4>' +
            '<div class="row secTbl">' +
            '<div class="col-md-12">' +
            '<div class="row">' +
            '<div class="col-md-6"><strong>Razón Social:</strong></div>' +
            '<div class="col-md-6 nombre_empresa"> ' + $(el).find('.nitEmp').attr('data-razonSocial') + '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-6"><strong>NIT:</strong></div>' +
            '<div class="col-md-6 nit_empresa">' + $(el).find('.nitEmp').attr('data-nit').toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-6"><strong>Dirección:</strong></div>' +
            '<div class="col-md-6 direccion_empresa">' + $(el).find('.dirEmpresa').val() + '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-6"><strong>Sition Web:</strong></div>' +
            '<div class="col-md-6 web_site"><a href="http://' + $(el).find('.webEmpresa').val() + '">' + $(el).find('.webEmpresa').val() + '</a></div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="row formato_periodo_empresa">' +
            '<div class="col-md-12 ">' +
            '<div class="formatoPerTbl">' +
            '<h4 class="secH4">Ceritificados disponibles<br/><small>Seleccione el formato</small></h4>' +
            '<div class="formatoCtner"></div>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-12">' +
            '<div class="formatoPerTbl">' +
            '<h4 class="secH4">Períodos disponibles<br/><small>Seleccione un periodo</small></h4>' +
            '<div class="perCtner"><div class="selFormatoMess"><i class="fa fa-warning" aria-hidden="true"></i> Seleccione formato</div></div>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<div class="generar_certificado_boton">' +
            '<h4 style="color:black;text-align:center;">Generar Certificado</h4>' +
            '<div class="selPerMess"><i class="fa fa-warning" aria-hidden="true"></i> Seleccione periodo</div>' +
            '<div class="row" style="width:60%;margin:auto !important;">' +

            '<div class="col-md-6" >' +
            '<div style="text-align:right;">' +
            '<form id="pdfFrm" target="_blank" action="PDF/pdfout.php" method="post">' +
            '<button type="submit" title="PDF" class="pdfBtn">Ver Certificado <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>' +
            '<input type="hidden" name="img" value="' + hexToBase64(imgData) + '">' +
            '<input type="hidden" name="formato" value="">' +
            '<input type="hidden" name="mesini" value="">' +
            '<input type="hidden" name="mesfin" value="">' +
            '<input type="hidden" name="nit_empresa" value="' + $(el).find('.nit_empresa').val() + '">' +
            '</form>' +
            '</div>' +
            '</div>' +

            '<div class="col-md-6">' +
            '<div style="text-align:center;">' +
            '<form id="saveFrm" method="post">' +
            '<button type="button" title="Guardar" class="guardarBtn">Guardar Certificado <i class="glyphicon glyphicon-floppy-disk"></i></button>' +
            '<input type="hidden" name="img" value="' + hexToBase64(imgData) + '">' +
            '<input type="hidden" name="formato" value="">' +
            '<input type="hidden" name="mesini" value="">' +
            '<input type="hidden" name="mesfin" value="">' +
            '<input type="hidden" name="nit_empresa" value="' + $(el).find('.nit_empresa').val() + '">' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '</div>' +
            '</div>' +
            '</div>' +
            '</div></div>';
    } else if (type == 'infoEmp') {
        var html = '<div style="padding-top:20px !important;width:95%;margin:auto !important;" class="row empresas_vinculadas_ctnr">' +
            '<div class="row">' +

            '<div class="col-md-6">' +
            '<div class="logoEmpCtnr">' +
            '<span style="display: inline-block;height: 100%;vertical-align: middle;"></span><img style="width:100px;" src="' + img + '">' +
            '</div>' +
            '</div>' +

            '<div class="col-md-6">' +
            '<div class="datos_empresa_contenedor">' +
            '<div class="datosEmpresa">' +
            '<h4 class="secH4">Datos Empresa</h4>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Nombre razón social</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.nitEmp').attr('data-razonSocial') + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>NIT</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.nitEmp').attr('data-nit').toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Dirección</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.dirEmpresa').val() + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Ciudad</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.municipioEmpresa').val() + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Departamento</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.depEmpresa').val() + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>País</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.paisEmpresa').val() + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Web Site</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p><a href="http://' + $(el).find('.webEmpresa').val() + '" target="blank">' + $(el).find('.webEmpresa').val() + '</a></p>' +
            '</div>' +
            '</div>' +

            '</div>' +

            '</div>' +

            '<div class="datos_empresa_contenedor">' +
            '<div class="datosEmpresa">' +
            '<h4 class="secH4">Contacto</h4>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Nombre Contacto</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.contEmpresa').val().replace(/\w\S*/g, function(txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); }) + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Teléfono Fijo</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.telEmpresa').val().replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3') + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Teléfono Móvil</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p>' + $(el).find('.mobilEmpresa').val().replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3') + '</p>' +
            '</div>' +
            '</div>' +

            '<div class="row">' +
            '<div class="col-md-4">' +
            '<p><b>Email</b></p>' +
            '</div>' +
            '<div class="col-md-8">' +
            '<p><a href="mailto:' + $(el).find('.emContEmpresa').val() + '">' + $(el).find('.emContEmpresa').val() + '</a></p>' +
            '</div>' +
            '</div>' +

            '</div>' +

            '</div>' +

            '</div>' +



            '</div></div>';
    }



    $('.dash').append(html);
    formatos($(el).find('.nitEmp').attr('data-nit'));

}

function periodos(id_emp, codigo_formato) {
    $('.loadingCtn').show();
    $('.perCtner .row').remove();
    $('.selFormatoMess').hide();

    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=periodos&idemp=" + id_emp + "&codform=" + codigo_formato,
        success: function(res) {
            var d = JSON.parse(res);

            for (var i = 0; i < d.length; i++) {
                $('.generar_certificado_boton #pdfFrm input[name=mesini]').val(d[i].ano_mes_incial);
                $('.generar_certificado_boton #pdfFrm input[name=mesfin]').val(d[i].ano_mes_fnal);
                $('.generar_certificado_boton #saveFrm input[name=mesini]').val(d[i].ano_mes_incial);
                $('.generar_certificado_boton #saveFrm input[name=mesfin]').val(d[i].ano_mes_fnal);
                var htmlPeriodos = '<a href="#" class="row period">' +
                    '<div class="col-md-5 mes_inicial">' + d[i].ano_mes_incial + '</div>' +
                    '<div class="col-md-5 mes_final">' + d[i].ano_mes_fnal + '</div>' +
                    '<div class="col-md-2"><i style="float:right;display:none;" class="formIcon glyphicon glyphicon-ok"></i></div>' +
                    '</a>';
                $('.perCtner').append(htmlPeriodos);
                $('.loadingCtn').fadeOut();
            }

        }
    });
}

function formatos(id_emp) {
    $('.loadingCtn').show();
    $('.formatoCtner a').remove();
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=formatos&idemp=" + id_emp,
        success: function(res) {
            var d = JSON.parse(res);
            for (var i = 0; i < d.length; i++) {
                var html = '<a href="#" class="formato" data-codigoFormato="' + d[i].cdgo_frmto + '" data-idemp="' + d[i].id_emprsa + '">' + d[i].nmbre_frmto + ' <i style="float:right;display:none;" class="formIcon glyphicon glyphicon-ok"></i></a>';
                $('.formatoCtner').append(html);
                $('.generar_certificado_boton #pdfFrm input[name=formato]').val(d[i].cdgo_frmto);
                $('.generar_certificado_boton #saveFrm input[name=formato]').val(d[i].cdgo_frmto);
                $('.loadingCtn').fadeOut();

            }
        }
    });
}

function generar_certificado(formato, mesini, mesfin, nit_empresa) {
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=cert&codform=" + formato + "&mesini=" + mesini + "&mesfin=" + mesfin + "&idemp=" + nit_empresa,
        success: function(res) {

            if (res != 'false') {
                var d = JSON.parse(res);


                if (d[0].lgtpo_emprsa != false) {
                    var imgData = d[0].lgtpo_emprsa;
                    var img = 'data:image/jpeg;base64,' + hexToBase64(imgData);
                } else {
                    var img = 'http://placehold.it/50x50';
                }

                $('.logo_certificado').attr('src', img);
                $('.certificado_nombre_empresa').text(d[0].nmbre_trcro);
                $('.certificado_nit_empresa').text(d[0].id_emprsa.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $('.certificado_direccion_empresa').text(d[0].drccion);
                $('.certificado_ciudad_empresa').text(d[0].nmbre_mncpio + ', ' + d[0].nmbre_pais);
                $('.certificado_formato').html('<h3>CERTIFICADO DE ' + d[0].nmbre_frmto + '<br/>AÑO GRAVABLE ' + d[0].ano_mes_fnal.substr(0, 4) + '</h3>');
                $('.certificado_fecha_emicion').html('<p style="text-align:center;">Fecha Emisión: ' + tdate() + '</p>');
                var m = d[0].pie_frmto.match(/(\d{2})\/(\d{2})\/(\d{4})/).toString().substring(0, 10);
                $('.certificado_footer').text(d[0].pie_frmto.replace(m, tdate()));

                var total_base = [];
                var total_retencion = [];
                $(".concepto").remove();
                for (var i = 0; i < d.length; i++) {
                    var base = (d[i].vlor_grvble * d[i].prcntje_aplccion) / 100;
                    total_base.push(base);
                    total_retencion.push(Math.round(d[i].vlor_grvble));
                    var html = '<div class="row concepto" style="padding:0px 10px !important;">' +
                        '<div class="col-md-6 certificado_nombre_concepto">' + d[i].nmbre_cncpto.replace(/\w\S*/g, function(txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase() }) + '</div>' +
                        '<div class="col-md-2 certificado_taza" style="text-align:right;">' + d[i].prcntje_aplccion + '%</div>' +
                        '<div class="col-md-2 certificado_base" style="text-align:right;">' + base.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</div>' +
                        '<div class="col-md-2 certificado_retencion" style="text-align:right;">' + Math.round(d[i].vlor_grvble).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</div>' +
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
            } else {
                console.log('resultado falso');
            }
        }
    });
}

function guardar_certificado() {
    var fname = '';
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=files",
        success: function(res) {

            var d = JSON.parse(res);
            console.log(d);
            var html = '<p>Porfavor seleccione un folder para guardar certificado.</p><select name="folderList" form="carform">';
            $('.file').remove();
            for (var key in d) {

                var last4 = key.substr(key.length - 4);

                if (last4.charAt(0) != '.') {
                    html = html + '<option value="' + d[key]['folder_number'] + '"><i class="fa fa-folder"></i>' + key + '</option>';
                } else {
                    console.log(key);
                }

            }
            html = html + '</select><input type="submit" tabindex="-1" style="position:absolute; top:-1000px">';
            $('#formDialog form fieldset').html(html);

            dialog = $("#formDialog").dialog({
                autoOpen: false,
                height: 190,
                width: 350,
                title: 'Folder',
                modal: true,
                buttons: {
                    "Guardar Documento": savecer,
                    Cancel: function() {
                        dialog.dialog("close");
                    }
                },
                close: function() {
                    form[0].reset();
                }
            });
            form = dialog.find("form").on("submit", function(event) {
                event.preventDefault();
                savecer();

                dialog.dialog("close");
            });
            dialog.dialog("open");

        }
    });

    function savecer() {
        var data = $('#saveFrm').serialize();
        var iconStyle = 'font-size:18pt;color:green;float:left;';
        var f = dialog.find('form').find('select').val();

        $.ajax({
            async: true,
            type: "post",
            data: data + "&folder=" + f,
            url: "src/controler.php?req=guardarcert",
            success: function(res) {
                open_folder('Bandeja de entrada');
                dialog.dialog("close");
                $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess"> Su certificado: ' + res +
                    ' se ah guardado exitosamente!</p>');
                $("#dialog-message").dialog({
                    modal: true,
                    title: 'Documento guardado!',
                    buttons: {
                        Ok: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            }
        });
    }
}

//FUNCIONES MANEJO DE DOCUMENTOS
var doc_data = '';


$('.folderList').on('blur', '.mainFolderFileList input[type="text"]', function() {
    console.log('out');
    $(this).attr('readOnly', 'true');
    $(this).addClass('folderNameImput');
});

function renderFiles(elm) {
    if (elm == 'cp') {
        $('.loadingCtn').show();
        clearAll();
        $('.folderList li').remove();
        $.ajax({
            async: true,
            type: "get",
            url: "src/controler.php?req=files",
            success: function(res) {
                var d = JSON.parse(res);
                console.log(d);
                //doc_data = d;
                var styleDocTile = 'border-radius:3px;background-color:rgba(3,3,3,.5);padding:20px;font-size:8pt;height:130px;box-shadow:0px 0px 5px #ccc;';
                var styleDocCols = 'color:white;text-align:center;padding:6px !important;position:relative !important;';

                var html2 = '<li class="mainFolderFileList"><ul>';
                var flistStyle = '';
                var folder = '';
                if (d['nofiles']) {
                    html2 = html2 + '<li>' + d['nofiles'] + '</li>';
                } else {
                    var linksUrl = siteURI + 'PDF/pdfout.php';
                    //html = html+'<ul class="fileList">';

                    for (var key in d) {

                        html2 = html2 + '<li class="dragLi" draggable="true">' +

                            '<i style="font-size:9pt;" class="fa fa-folder-o" aria-hidden="true">' +
                            '</i>   <a class="folderBtn" href="#" data-folder="' + key + '" style="' + flistStyle + '" readonly="true" ondblclick="this.readOnly="";" type="text">' + key + '</a>';
                        if (key == 'Bandeja de entrada') {
                            html2 = html2 + '';
                        } else {
                            html2 = html2 + '<i class="fa fa-times delFolderBtn" data-fname="' + key + '" data-fnumber="' + d[key]['folder_number'] + '" aria-hidden="true"></i>';
                        }

                        html2 = html2 + '</li>';
                    }
                    html2 = html2 + '</ul><button class="newFolderBtn">Crear Folder</button></li>';
                }
                $('.folderList').append(html2);
                $('.loadingCtn').fadeOut();
            }
        });
    }

}

function folder_setup() {
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=files",
        success: function(res) {
            var d = JSON.parse(res);
            var objSize = Object.keys(d).length;
            var objKeys = Object.keys(d);
            console.log(objSize);
            if (objSize > 0 && objKeys[0] == 'Bandeja de entrada') {
                renderFiles('cp');
                open_folder(objKeys[0]);
            } else {
                $.ajax({
                    async: true,
                    type: 'get',
                    url: 'src/controler.php?req=newFold&folderName=Bandeja de entrada',
                    success: function(res) {
                        console.log(res);
                        if (res == true) {
                            renderFiles('cp');
                            open_folder('Bandeja de entrada');
                        } else {
                            console.log('FALSE');
                        }
                    }
                });
            }
        }
    });
}



$('.fileContainer').on('click', '.editFolderNameBtn', function() {
    var fname = $(this).attr('data-fname');
    var fnum = $(this).attr('data-fnum');
    editFoldername(fnum, fname);
})

function editFoldername(fnum, fname) {
    var mess = "<p>Entre nuevo nombre</p>";
    $('#formDialog form fieldset').html(mess + '<input required data-parsley-required-message="Se nescesita un nombre." type="text" name="folderName" class="text ui-widget-content ui-corner-all"><input type="submit" tabindex="-1" style="position:absolute; top:-1000px">');
    dialog = $("#formDialog").dialog({
        autoOpen: false,
        height: 160,
        width: 350,
        title: 'Editando ' + fname,
        modal: true,
        buttons: {
            "Cambiar": function() {

                cambiar();

            },
            "Cancelar": function() {
                dialog.dialog("close");
            }
        },
        close: function() {
            form = dialog.find('form');
            form[0].reset();
        }
    });
    dialog.dialog("open");

    function cambiar() {

        var fname = $("#formDialog form").find('input[type="text"]').val();
        var valid = dialog.find('form').parsley().validate();
        console.log(valid);
        if (valid) {
            dialog.dialog("close");
            console.log(fname);
            $.ajax({
                async: true,
                type: "get",
                url: "src/controler.php?req=editfol&fnum=" + fnum + "&folderName=" + fname,
                success: function(res) {
                    if (res == 1) {
                        var iconStyle = 'font-size:25pt;color:darkgreen;float:left;';
                        $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-check" aria-hidden="true"></spam><p class="dialog_mess">Su folder se a renombrado: <b>' + fname + '</b></p>');
                        $("#dialog-message").dialog({
                            modal: true,
                            title: 'Folder Actualizado!',
                            buttons: {
                                Ok: function() {
                                    renderFiles('cp');
                                    open_folder(fname);
                                    $(this).dialog("close");
                                }
                            }
                        });

                    } else {
                        console.log(res);
                    }


                }
            });
        }


    }

}

function open_folder(folder) {
    $('.loadingCtn').show();
    clearAll();
    var linksUrl = siteURI + 'PDF/pdfout.php';
    var styleDocTile = 'border-radius:3px;background-color:rgba(3,3,3,.5);padding:20px;font-size:8pt;height:130px;box-shadow:0px 0px 5px #000;';
    var styleDocCols = 'color:white;text-align:center;padding:6px !important;position:relative !important;';

    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=files",
        success: function(res) {

            var d = JSON.parse(res);
            var doc_data = d;
            var fnum = doc_data[folder]['folder_number'];

            delete doc_data[folder]['folder_number'];
            var html = '<div class="row"><div class="col-md-10"><h4><i class="fa fa-folder-open" aria-hidden="true"></i>   ' + folder + '</h4></div><div class="col-md-2">';
            if (folder == 'Bandeja de entrada') {
                html = html + '';
            } else {
                html = html + '<div style="margin-top: 15;"><spam style="padding-right:7px;"><b>Renombrar Carpeta</b></spam><button data-fname="' + folder + '" data-fnum="' + fnum + '" class="editFolderNameBtn"><i class="fa fa-pencil" aria-hidden="true"></i></button></div>';
            }
            html = html + '</div></div><div class="row">';
            html = html + '<div class="row docRowHeaders">' +
                '<div class="col-md-1"><p><b>Doc ID</b></p></div>' +

                '<div class="col-md-8 ">' +
                '<div>' +
                '<p><b>Asunto</b></p>' +
                '</div>' +
                '</div>' +

                '<div class="col-md-1"><p><b>Fecha</b></p></div>' +

                '<div class="col-md-1"><p style="text-align: right;"><b>Borrar</b></p></div>' +
                '<div class="col-md-1"><p style="padding-left: 7;"><b>Mover</b></p></div>' +
                '</div>';

            var arr = [];

            console.log(Object.keys(doc_data[folder]).length);

            console.log(doc_data[folder]);
            if (Object.keys(doc_data[folder]).length > 0) {
                for (var key in doc_data[folder]) {


                    var linkText = key;
                    var idf = doc_data[folder][key].split('_');
                    html = html + '<div class="row docRow">' +
                        '<div class="col-md-1"><p>' + idf[0] + '</p></div>' +

                        '<div class="col-md-8 ">' +
                        '<p>' +
                        '<a style="color:#333;" target="blank" href="' + linksUrl + '?docid=' + idf[0] + '">' +
                        '<i style="font-size:10pt;color:darkred;" class="fa fa-file-pdf-o" aria-hidden="true"></i>        ' + linkText + '</a>' +
                        '</p>' +
                        '</div>' +

                        '<div class="col-md-1"><p>' + idf[1] + '</p></div>' +
                        '<div style="text-align:right;" class="col-md-1"><i title="Borrar Documento" class="fa fa-trash delfile" data-fnum="' + fnum + '" data-fname="' + folder + '" data-docid="' + idf[0] + '" aria-hidden="true" ></i></div>' +
                        '<div style="text-align:left;" class="col-md-1"><i title="Mover Documento" class="fa fa-arrow-right movefile" data-fnum="' + fnum + '" data-fname="' + folder + '" data-docid="' + idf[0] + '" aria-hidden="true" ></i></div>' +
                        '</div>';




                }
            } else if (Object.keys(doc_data[folder]).length == 0) {

                html = html + '<div class="row docRow"><div class="col-md-12 docRow" style="background-color:white;color:#333;"><div class="docRowInnerCtnr"><p style="font-size:15;text-align:center;"><i class="fa fa-times" aria-hidden="true"></i>  No hay documentos.</div></div></div>';
            }
            html = html + '</div>';

            $('.fileContainer').append(html);
            $('.fileContainer').fadeIn();
            $('.loadingCtn').fadeOut();
        }




    });
}
$('.folderlist').on('click', '.mainFolderFileList ul li .delFolderBtn', function() {
    var fnum = $(this).attr('data-fnumber');
    var fname = $(this).attr('data-fname');
    del_file(fnum, fname, null);
});

function del_file(fnum, fname, file) {

    var fileUrl = '';

    //Para borrar folder
    if (file == null && fnum != '' && fname != '') {
        var mes = 'El folder <b>' + fname + '</b> y todo su contenido sera permanente borrado. Esta operacion NO es reverzible. Desea continuar?';
        $('#dialogo_confirmacion .confirmacion_mensaje').html(mes);

        $("#dialogo_confirmacion").dialog({
            resizable: false,
            height: "auto",
            width: 350,
            modal: true,
            title: 'Esta seguro?',
            buttons: {
                "Borrar folder": function() {
                    var iconStyle = 'font-size:18pt;color:green;float:left;';

                    $.ajax({
                        async: true,
                        type: 'get',
                        url: 'src/controler.php?req=deldir&folderName=' + fnum,
                        success: function(res) {
                            if (res == 1) {
                                renderFiles('cp');
                                open_folder('Bandeja de entrada');
                                $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess">Folder borrado exitosamente!</p>');
                                $("#dialog-message").dialog({
                                    modal: true,
                                    title: 'Borrado!',
                                    buttons: {
                                        Ok: function() {
                                            $(this).dialog("close");
                                        }
                                    }
                                });

                            }
                        }
                    });
                    $(this).dialog("close");
                },
                "Cancelar": function() {
                    $(this).dialog("close");
                }
            }
        });
        //Para borrar documento
    } else {
        var mes = 'El documento <b style="font-size:8pt !important;">' + file + '</b> sera permanente borrado de la carpeta ' + fname + '. Esta operacion NO es reverzible. Desea continuar?';
        $('#dialogo_confirmacion .confirmacion_mensaje').html(mes);

        $("#dialogo_confirmacion").dialog({
            resizable: false,
            height: "auto",
            width: 350,
            modal: true,
            title: 'Esta seguro?',
            buttons: {
                "Borrar documento": function() {
                    var iconStyle = 'font-size:20pt;color:green;float:left;';
                    $('.loadingCtn').show();
                    $.ajax({
                        async: true,
                        type: 'get',
                        url: 'src/controler.php?req=delfile&docid=' + file,
                        success: function(res) {

                            if (res == 1 && fnum == 1) {
                                open_folder('Bandeja de entrada');
                                $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess">Documento borrado exitosamente!</p>');
                                $("#dialog-message").dialog({
                                    modal: true,
                                    title: 'Borrado!',
                                    buttons: {
                                        Ok: function() {
                                            $(this).dialog("close");
                                        }
                                    }
                                });
                                $('.loadingCtn').fadeOut();
                            } else {
                                open_folder(fname);
                                $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess">Documento borrado exitosamente!</p>');
                                $("#dialog-message").dialog({
                                    modal: true,
                                    title: 'Borrado!',
                                    buttons: {
                                        Ok: function() {
                                            $(this).dialog("close");
                                        }
                                    }
                                });
                                $('.loadingCtn').fadeOut();
                            }
                        }
                    });
                    $(this).dialog("close");
                },
                "Cancelar": function() {
                    $(this).dialog("close");
                }
            }
        });
    }





}

$('.fileContainer').on('click', '.docRow .movefile', function() {
    var docid = $(this).attr('data-docid');
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=files",
        success: function(res) {

            var d = JSON.parse(res);
            console.log(d);
            var html = '<p>Porfavor seleccione un folder de destino.</p><select name="folderList" form="carform">';
            $('.file').remove();
            for (var key in d) {

                var last4 = key.substr(key.length - 4);

                if (last4.charAt(0) != '.') {
                    html = html + '<option value="' + key + '_' + d[key]['folder_number'] + '"><i class="fa fa-folder"></i>' + key + '</option>';
                } else {
                    console.log(key);
                }

            }
            html = html + '</select><input type="submit" tabindex="-1" style="position:absolute; top:-1000px">';
            $('#formDialog form fieldset').html(html);

            dialog = $("#formDialog").dialog({
                autoOpen: false,
                height: 190,
                width: 350,
                title: 'Cambio de folder',
                modal: true,
                buttons: {
                    "Mover Documento": move_file,
                    Cancel: function() {
                        dialog.dialog("close");
                    }
                },
                close: function() {
                    form[0].reset();
                }
            });
            form = dialog.find("form").on("submit", function(event) {
                event.preventDefault();
                move_file();

                dialog.dialog("close");
            });
            dialog.dialog("open");

            function move_file() {
                dialog.dialog("close");
                var data = dialog.find('form').find('select').val();
                var split = data.split('_');
                var fname = split[0];
                var fnum = split[1];

                console.log(fnum, fname);
                var mes = 'El documento <b>' + docid + '</b> sera movido a la carpeta <b>' + fname + '</b>. Desea continuar?';
                $('#dialogo_confirmacion .confirmacion_mensaje').html(mes);

                $("#dialogo_confirmacion").dialog({
                    resizable: false,
                    height: "auto",
                    width: 350,
                    modal: true,
                    title: 'Esta seguro?',
                    buttons: {
                        "OK": function() {
                            var iconStyle = 'font-size:18pt;color:green;float:left;';

                            $.ajax({
                                async: true,
                                type: 'get',
                                url: 'src/controler.php?req=movef&folderName=' + fnum + '&docid=' + docid,
                                success: function(res) {
                                    console.log(res);
                                    if (res == 1) {
                                        open_folder(fname);
                                        $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess">Documento movido exitosamente!</p>');
                                        $("#dialog-message").dialog({
                                            modal: true,
                                            title: 'Exito!',
                                            buttons: {
                                                Ok: function() {
                                                    $(this).dialog("close");
                                                }
                                            }
                                        });

                                    }
                                }
                            });
                            $(this).dialog("close");
                        },
                        "Cancelar": function() {
                            $(this).dialog("close");
                        }
                    }
                });
            }

        }
    });


});

//FUNCIONES DATOS DE USUARIO
function datos_usuario() {
    $('.loadingCtn').show();
    $('.cambiarDatosFormCtnr .row').remove();

    $.ajax({
        async: true,
        type: 'get',
        url: 'src/controler.php?req=infouser',
        success: function(res) {
            var d = JSON.parse(res);
            var istyle = "float:right;";
            var html = '<h4 style="text-align:center;">Información de Registro</h4><div class="ctn"><div class="row">' +
                '<div class="col-md-6"><div>Nombre</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_name'] + '</p></div><div class="col-md-3"><b style="padding-rigth:5;">Modificar</b> <i data-field="Nombre" data-col="client_name" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Apellido</div> </div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_lastname'] + '</p></div><div class="col-md-3"><b style="padding-rigth:5;">Modificar</b> <i data-field="Apellido" data-col="client_lastname" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Teléfono Fijo</div> </div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_phone'].replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3') + '</p></div><div class="col-md-3"><b style="padding-rigth:5;">Modificar</b> <i data-field="Telefono Fijo" data-col="client_phone" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Teléfono Móvil</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_mobil'].replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3') + '</p></div><div class="col-md-3"><b style="padding-rigth:5;">Modificar</b> <i data-field="Telefono Movil" data-col="client_mobil" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +

                '<div class="row">' +
                '<div class="col-md-6"><div>Nit ó Cédula Tercero Asociado</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_cedula'] + '</p></div><div class="col-md-3"><b style="padding-rigth:5;">Modificar</b> <i data-field="NIT" data-col="client_cedula" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Contraseña</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p type="password">***********</p></div><div class="col-md-3"><b style="padding-rigth:5;">Modificar</b> <i class="fa fa-lock cambiarClaveBtn" aria-hidden="true"></i></div></div></div>' +
                '</div></div>';

            $('.cambiarDatosFormCtnr').html(html);
            $('.cambiarDatosFormCtnr').fadeIn();
            $('.loadingCtn').fadeOut();


        }
    });
}





function info_y_contacto_de_empresa() {
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=empvin",
        success: function(res) {
            console.log(res);
            var d = JSON.parse(res);
            console.log(d);
            var imgData = d.lgtpo_emprsa;
            var img = 'data:image/jpeg;base64,' + hexToBase64(imgData);
            var html = '<div class="row">' +

                '<div class="col-md-6">' +
                '<div class="logoEmpCtnr">' +
                '<span style="display: inline-block;height: 100%;vertical-align: middle;"></span><img style="width:100px;" src="' + img + '">' +
                '</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<div class="info_empresa_ctnr">' +

                '<div class="row">' +
                '<div class="col-md-4">' +
                '<p><b>Nombre</b></p>' +
                '</div>' +
                '<div class="col-md-8">' +
                '<p>' + d[0].nmbre_rzon_scial + '</p>' +
                '</div>' +
                '</div>' +

                '<div class="row">' +
                '<div class="col-md-4">' +
                '<p><b>NIT</b></p>' +
                '</div>' +
                '<div class="col-md-8">' +
                '<p>' + d[0].id_emprsa + '</p>' +
                '</div>' +
                '</div>' +

                '<div class="row">' +
                '<div class="col-md-4">' +
                '<p><b>Direccion</b></p>' +
                '</div>' +
                '<div class="col-md-8">' +
                '<p>' + d[0].drccion + '</p>' +
                '</div>' +
                '</div>' +

                '<div class="row">' +
                '<div class="col-md-4">' +
                '<p><b>Ciudad</b></p>' +
                '</div>' +
                '<div class="col-md-8">' +
                '<p>' + d[0].nmbre_mncpio + '</p>' +
                '</div>' +
                '</div>' +

                '<div class="row">' +
                '<div class="col-md-4">' +
                '<p><b>Depto</b></p>' +
                '</div>' +
                '<div class="col-md-8">' +
                '<p>' + d[0].nmbre_dpto + '</p>' +
                '</div>' +
                '</div>' +

                '<div class="row">' +
                '<div class="col-md-4">' +
                '<p><b>Pais</b></p>' +
                '</div>' +
                '<div class="col-md-8">' +
                '<p>' + d[0].nmbre_pais + '</p>' +
                '</div>' +
                '</div>' +

                '</div>' +
                '</div>' +

                '</div>';


            $('.dash').append(html);

        }
    });
}

function client_info() {
    $.ajax({
        async: true,
        type: 'get',
        url: 'src/controler.php?req=infouser',
        success: function(res) {
            var d = JSON.parse(res);
            $('.client_info_name').text(d['client_name']);
            $('.client_info_last_name').text(d['client_lastname']);
            $('.client_info_email').text(d['client_email']);
            $('.client_info_nit').text(d['client_cedula'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
    });
}
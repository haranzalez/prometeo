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

//FUNCIONES UI




//NAVEGACION
$('.portalNavEmpBtn').on('click', function() {
    var dpb = $(this).attr('data-empresa');
    if (dpb = 'empVinculadas') {
        document.body.style.backgroundColor = '#FFCC66';
        empresas_vinculadas();
        $('.logo_corporativo').hide();
        $('.slogan').fadeIn();
        $('.logoPortal').fadeIn();
    }
});

$('.portalNavDocBtn').on('click', function() {
    var dpb = $(this).attr('data-empresa');
    if (dpb = 'documents') {
        document.body.style.backgroundColor = '#FFCC66';
        renderFiles('both');
        $('.logo_corporativo').hide();
        $('.slogan').fadeIn();
        $('.logoPortal').fadeIn();
    }
});
$('.folderList').on('click', '.portalNavDocBtn', function() {
    var dpb = $(this).attr('data-empresa');
    if (dpb = 'documents') {
        document.body.style.backgroundColor = '#FFCC66';
        renderFiles('dash');
        $('.logo_corporativo').hide();
        $('.slogan').fadeIn();
        $('.logoPortal').fadeIn();
    }
});

$('.portalNavCambiarDatosBtn').on('click', function() {
    clearAll();
    datos_usuario();
    $('.logo_corporativo').hide();
    $('.slogan').fadeIn();
    $('.logoPortal').fadeIn();
});

$('.fileContainer').on('click', '.newDocumBtn', function() {
    document.body.style.backgroundColor = '#FFCC66';
    empresas_vinculadas();
});
//NAVEGACION END

//DASH FUNCTIONS
$('.dash').on('click', '.perCtner .period', function() {
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

$('.dash').on('click', '.formatoCtner .formato', function() {
    $('.formato i').hide();
    $(this).focus();
    $(this).find('i').show();
    var id_emp = $(this).attr('data-idemp');
    var codigo_formato = $(this).attr('data-codigoFormato');
    periodos(id_emp, codigo_formato);
    $('.generar_certificado_boton .imprimirBtn').attr('data-codform', $(this).attr('data-codigoFormato'));
    $('.generar_certificado_boton .guardarBtn').attr('data-codform', $(this).attr('data-codigoFormato'));
});

$('.dash').on('click', '.empBox', function() {
    $('.empresas_contenedor').hide();
    generar_datos_de_empresa($(this));
    $('.headerPortal').find('.logoPortal').hide();
    $('.headerPortal').find('.slogan').hide();

});


//GENERAR CERTIFICADO BTN
$(".dash").on('click', '.datos_de_empresa .generar_certificado_boton .imprimirBtn', function() {
    $('.generar_certificado_boton .imprimirBtn').html('<i style="font-size:18pt !important;" class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');
    var formato = $(this).attr('data-codform');
    var mesini = $(this).attr('data-mesini');
    var mesfin = $(this).attr('data-mesfin');
    generar_certificado(formato, mesini, mesfin);

});

$('.pdfBtn').on('click', function() {
    var html = document.getElementsByClassName('certificado')[0];

});
//GUARDAR CERTIFICADO
$('.dash').on('click', '.datos_de_empresa .generar_certificado_boton .guardarBtn', function() {
    guardar_certificado();
});

//FUNCIONES MANEJO DE DOCUMENTOS
$('.fileContainer').button().on("click", '.newFolderBtn', function() {

    $('#formDialog form fieldset').html('<p>Porfavor escriba un nombre para su nuevo folder.</p><input type="text" placeholder="Nombre" name="folderName" id="folderName" class="text ui-widget-content ui-corner-all"><input type="submit" tabindex="-1" style="position:absolute; top:-1000px">');
    dialog = $("#formDialog").dialog({
        autoOpen: false,
        height: 180,
        width: 350,
        title: 'Nuevo Folder',
        modal: true,
        buttons: {
            "Crear Folder": crearFolder,
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
        crearFolder();
        dialog.dialog("close");
    });
    dialog.dialog("open");
});

$('.folderlist').on('click', '.folderBtn', function() {
    var data = $(this).attr('data-folder');
    open_folder(data);
});

$('.fileContainer').on('click', '.folderBtn', function() {
    var data = $(this).attr('data-folder');

    open_folder(data);
});

$('.fileContainer').on('click', '.delfile', function() {
    var folder = $(this).attr('data-folder');

    var docid = $(this).attr('data-docid');
    del_file(folder, docid);
});
$('.folderList').on('click', '.toggleFolderListBtn', function() {
    $('.folderList').find('.mainFolderFileList').show();
});

$('.cambiarDatosFormCtnr').on('click', '.edit', function(e) {
    e.preventDefault();
    var field = $(this).attr('data-field');
    var col = $(this).attr('data-col');
    var id = $(this).attr('data-cid');

    $('#formDialog form fieldset').html('<p>Cambiar ' + field + '.</p><input type="text" name="' + col + '" class="text ui-widget-content ui-corner-all"><input type="submit" tabindex="-1" style="position:absolute; top:-1000px">');
    dialog = $("#formDialog").dialog({
        autoOpen: false,
        height: 180,
        width: 350,
        title: 'Editar',
        modal: true,
        buttons: {
            "Cambiar": function() {
                var newd = $("#formDialog form").serialize();
                console.log(newd);
                editar_dato_usuario(newd, id);
                dialog.dialog("close");
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


});

$('.cambiarDatosFormCtnr').on('click', '.ctn .cambiarClaveBtn', function() {
    var inputStyle = "margin-bottom:5px;display:block;width:100%;padding:7px;";
    $('#formDialog form fieldset').html('<p>Para cambiar su clave, porfavor llene los siguientes campos.</p>' +
        '<input style="' + inputStyle + '" placeholder="Su clave reciente" type="password" name="oldpass" class="text ui-widget-content ui-corner-all">' +
        '<input style="' + inputStyle + '" type="password" placeholder="Su NUEVA clave" name="newpass" class="text ui-widget-content ui-corner-all">' +
        '<input style="' + inputStyle + '" type="password" placeholder="Reingresar NUEVA clave" name="newpassconfi" class="text ui-widget-content ui-corner-all">' +
        '<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">');
    dialog = $("#formDialog").dialog({
        autoOpen: false,
        height: 240,
        width: 350,
        title: 'Cambio de clave',
        modal: true,
        buttons: {
            "Cambiar": function() {
                var newd = $("#formDialog form").serialize();
                console.log(newd);
                cambiar_clave(newd);
                dialog.dialog("close");
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
});




/*************** FUNCIONES **********************/
//FUNCIONES COMPLEMENTARIAS
function hexToBase64(str) {

    if (str != false) {
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
    mywindow.document.write('<link rel="stylesheet" href="http://70.35.196.223/promTest/css/certificado.css"><link rel="stylesheet" href="http://70.35.196.223/promTest/css/bootstrap.css"><link rel="stylesheet" href="http://70.35.196.223/promTest/css/font-awesome.css">');
    mywindow.document.write('</head><body>');
    mywindow.document.write(elem.innerHTML);
    mywindow.document.write('<script src="http://70.35.196.223/promTest/js/jquery-3.2.1.js"><\/script>' +
        '<script src="http://70.35.196.223/promTest/js/bootstrap.js"><\/script>' +
        '<script src="http://70.35.196.223/promTest/js/jspdf.js"><\/script>' +
        '<script src="http://70.35.196.223/promTest/js/html2canvas.js"><\/script>' +
        '<script src="http://70.35.196.223/promTest/js/main.js?newversion"><\/script>');
    mywindow.document.write('</body></html>');


    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;

}

function clearAll() {
    $('.datos_empresa_contenedor').remove();
    $('.empresas_contenedor .row').remove();
    $('.fileContainer div').remove();
    $('.fileContainer h4').remove();
    $('.fileContainer .filesBtnContainer').remove();
    $('.empresas_contenedor').hide();
    $('.cambiarDatosFormCtnr').hide();


}

//FUNCIONES AJAX
function empresas_vinculadas() {
    $('.loadingCtn').show();
    clearAll();
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=empvin",
        success: function(res) {
            $(".portalNavBtn[data-nav=1]").focus();

            var d = JSON.parse(res);

            if (d.length > 0) {
                for (var i = 0; i < d.length; i++) {

                    var img = 'data:image/jpeg;base64,' + hexToBase64(d[i].lgtpo_emprsa);
                    var html = '<div class="row">' +
                        '<div class="col-md-12 empBox borde_radio_3px"><div class="row">' +
                        '<div class="col-md-1"><img src="' + img + '"></div><div class="col-md-11"><p class="nitEmp" data-razonSocial="' + d[i].nmbre_rzon_scial + '" data-nit="' + d[i].id_emprsa + '" data-color="' + d[i].cdgo_color + '"><b>' + d[i].nmbre_rzon_scial + '</b>' +
                        ' | NIT: ' + d[i].id_emprsa.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' | ' + d[i].drccion + ', ' + d[i].nmbre_mncpio + ', ' + d[i].nmbre_pais + ' | ' + d[i].web_site + '</p></div>' +

                        '</div>' +
                        '<input type="hidden" class="dirEmpresa" value="' + d[i].drccion + '">' +
                        '<input type="hidden" class="paisEmpresa" value="' + d[i].nmbre_pais + '">' +
                        '<input type="hidden" class="municipioEmpresa" value="' + d[i].nmbre_mncpio + '">' +
                        '<input type="hidden" class="webEmpresa" value="' + d[i].web_site + '">' +
                        '<input type="hidden" class="logo_empresa" value="' + d[i].lgtpo_emprsa + '">' +
                        '</div>' +
                        '</div>';



                    $('.logoPortal').attr('src', 'img/logo_ppal.png');
                    $('.empresas_contenedor .empRowCtnr').append(html);

                }
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
    document.body.style.backgroundColor = colorFinal;
    $('.logo_corporativo').html('<img style="width:100px;" src="' + img + '"></div>');
    console.log($(el).find('.nitEmp').attr('data-razonSocial'));
    var html = '<div class="datos_empresa_contenedor">' +
        '<h4 style="color:#ccc;">Datos de empresa</h4>' +
        '<div class="datos_de_empresa">' +
        '<div class="datosEmpresa borde_radio_3px" style="padding:5px 5px !important;">' +
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<div class="row">' +
        '<div class="col-md-3"><strong>Razon Social:</strong></div>' +
        '<div class="col-md-9 nombre_empresa"> ' + $(el).find('.nitEmp').attr('data-razonSocial').replace(/\w\S*/g, function(txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); }) + '</div>' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-md-3"><strong>NIT:</strong></div>' +
        '<div class="col-md-9 nit_empresa">' + $(el).find('.nitEmp').attr('data-nit').toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<div class="row">' +
        '<div class="col-md-3"><strong>Direccion:</strong></div>' +
        '<div class="col-md-9 direccion_empresa">' + $(el).find('.dirEmpresa').val() + '</div>' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-md-3"><strong>Sition Web:</strong></div>' +
        '<div class="col-md-9 web_site"><a href="http://' + $(el).find('.webEmpresa').val() + '">' + $(el).find('.webEmpresa').val() + '</a></div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="row formato_periodo_empresa">' +
        '<div class="col-md-6">' +
        '<h4 style="color:#ccc;">Formatos</h4>' +
        '<div class="formatoCtner borde_radio_3px"></div>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<h4 style="color:#ccc;">Periodos</h4>' +
        '<div class="perCtner borde_radio_3px"></div>' +
        '</div>' +
        '</div>' +
        '<div class="generar_certificado_boton">' +
        '<h4 style="color:#ccc;text-align:center;">Generar Certificado</h4>' +
        '<div class="row" style="width:25%;margin:auto !important;">' +
        '<div class="col-md-4" >' +
        '<div style="text-align:center;width:95%;">' +
        '<button type="button" class="imprimirBtn borde_radio_3px"><i class="glyphicon glyphicon-print"></i></button>' +
        '</div>' +

        '</div>' +
        '<div class="col-md-4" >' +
        '<div style="text-align:center;">' +
        '<form id="pdfFrm" target="_blank" action="PDF/pdfout.php" method="post">' +
        '<button type="submit" title="PDF" class="pdfBtn borde_radio_3px"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>' +
        '<input type="hidden" name="img" value="' + hexToBase64(imgData) + '">' +
        '<input type="hidden" name="formato" value="">' +
        '<input type="hidden" name="mesini" value="">' +
        '<input type="hidden" name="mesfin" value="">' +
        '</form>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4">' +
        '<div style="text-align:center;width:95%;">' +
        '<form id="saveFrm" method="post">' +
        '<button type="button" title="Guardar" class="guardarBtn borde_radio_3px"><i class="glyphicon glyphicon-floppy-disk"></i></button>' +
        '<input type="hidden" name="img" value="' + hexToBase64(imgData) + '">' +
        '<input type="hidden" name="formato" value="">' +
        '<input type="hidden" name="mesini" value="">' +
        '<input type="hidden" name="mesfin" value="">' +
        '</form>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    $('.dash').append(html);
    $('.logo_corporativo').fadeIn();
    formatos($(el).find('.nitEmp').attr('data-nit'));

}

function periodos(id_emp, codigo_formato) {
    $('.loadingCtn').show();
    $('.perCtner .row').remove();
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
                var htmlPeriodos = '<a href="#" style="display:block;padding:5px !important;font-size:8pt !important;width:100%;" class="row period">' +
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
                var html = '<a href="#" style="display:block;padding:5px !important;font-size:8pt !important;width:100%;" class="formato" data-codigoFormato="' + d[i].cdgo_frmto + '" data-idemp="' + d[i].id_emprsa + '">' + d[i].nmbre_frmto + ' <i style="float:right;display:none;" class="formIcon glyphicon glyphicon-ok"></i></a>';
                $('.formatoCtner').append(html);
                $('.generar_certificado_boton #pdfFrm input[name=formato]').val(d[i].cdgo_frmto);
                $('.generar_certificado_boton #saveFrm input[name=formato]').val(d[i].cdgo_frmto);
                $('.loadingCtn').fadeOut();

            }
        }
    });
}

function generar_certificado(formato, mesini, mesfin) {
    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=cert&codform=" + formato + "&mesini=" + mesini + "&mesfin=" + mesfin,
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
                $('.certificado_nombre_empresa').text(d[0].nmbre_rzon_scial);
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

    $.ajax({
        async: true,
        type: "get",
        url: "src/controler.php?req=files",
        success: function(res) {
            console.log(res);
            var d = JSON.parse(res);
            console.log(d);
            var html = '<p>Porfavor seleccione un folder para guardar certificado.</p><select name="folderList" form="carform"><option value="Bandeja de entrada">Bandeja de entrada</option>';
            $('.file').remove();
            for (var key in d['Bandeja de entrada']) {
                var last4 = key.substr(key.length - 4);
                console.log(key);
                if (last4.charAt(0) != '.') {
                    html = html + '<option value="' + key + '"><i class="fa fa-folder"></i>' + key + '</option>';
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
                renderFiles('cp');
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

function renderFiles(elm) {
    if (elm == 'both') {
        $('.loadingCtn').show();
        clearAll();
        $('.folderList li').remove();
        $.ajax({
            async: true,
            type: "get",
            url: "src/controler.php?req=files",
            success: function(res) {
                var d = JSON.parse(res);
                doc_data = d;
                var styleDocTile = 'border-radius:3px;background-color:rgba(3,3,3,.5);padding:20px;font-size:8pt;height:130px;box-shadow:0px 0px 5px #ccc;';
                var html = '<h4>Bandeja de entrada</h4><div class="row">';
                var html2 = '<li style="color:#ccc;"><a href="#" class="portalNavDocBtn toggleFolderListBtn" data-empresa="documents"><i style="font-size:12pt;" class="fa fa-folder"  aria-hidden="true"></i>  Bandeja de entrada</a></li><li class="mainFolderFileList"><ul>';
                var flistStyle = '';
                var folder = '';
                if (d['nofiles']) {
                    html = html + '<p>' + d['nofiles'] + '</p>';
                } else {
                    var linksUrl = 'http://70.35.196.223/promTest/PDF/pdfout.php';
                    //html = html+'<ul class="fileList">';

                    for (var key in d['Bandeja de entrada']) {

                        var last4 = key.substr(key.length - 4);
                        if (last4.charAt(0) == '.') {

                            //Manipulando texto
                            var dot = key.split('.');
                            var final = dot[0].split('_');
                            var linkText = final[0] + '_' + final[1] + '.pdf';

                            //Agregando elemento
                            html = html + '<div class="col-md-12 docRow"><div  class="docRowInnerCtnr"><i title="Borrar Documento" class="fa fa-trash delfile" data-docid="' + d['Bandeja de entrada'][key] + '" aria-hidden="true" ></i><a style="color:#333;font-size:7pt !important;" target="blank" href="' + linksUrl + '?docid=' + d['Bandeja de entrada'][key] + '"><i style="font-size:15pt;color:darkred;" class="fa fa-file-pdf-o" aria-hidden="true"></i>       ' + linkText + '</a></div></div>';

                        } else {

                            html = html + '<div class="col-md-12 docRow"><div  class="docRowInnerCtnr"><i title="Borrar Documento" class="fa fa-trash delfile" data-folder="' + key + '" aria-hidden="true" ></i><a class="folderBtn" href="#" data-folder="' + key + '" style="' + flistStyle + '"><i style="font-size:15pt;color:#FDB813;" class="fa fa-folder" aria-hidden="true"></i>       ' + key + '</a></div></div>'
                            html2 = html2 + '<li><a class="folderBtn" href="#" data-folder="' + key + '" style="' + flistStyle + '"><i style="font-size:9pt;" class="fa fa-folder-o" aria-hidden="true"></i>  ' + key + '</a></li>';

                        }

                    }

                    html = html + '</div>';
                    html2 = html2 + '</ul></li>';
                }
                $('.fileContainer').append('<div class="fileContrBtns"><button type="button" class="newFolderBtn"><i style="position:absolute;top:3;right:2;" class="fa fa-plus" aria-hidden="true"></i><i style="font-size:10px;" class="fa fa-folder" aria-hidden="true"></i></button>' +
                    '<button type="button" class="newDocumBtn"><i style="position:absolute;top:3;right:2;" class="fa fa-plus" aria-hidden="true"></i><i style="font-size:10px;" class="fa fa-file" aria-hidden="true"></i></button></div>');
                $('.fileContainer').append(html);
                $('.folderList').append(html2);
                $('.fileContainer').fadeIn();
                $('.loadingCtn').fadeOut();
            }
        });
    } else if (elm == 'cp') {
        $('.loadingCtn').show();
        clearAll();
        $('.folderList li').remove();
        $.ajax({
            async: true,
            type: "get",
            url: "src/controler.php?req=files",
            success: function(res) {
                var d = JSON.parse(res);
                doc_data = d;
                var styleDocTile = 'border-radius:3px;background-color:rgba(3,3,3,.5);padding:20px;font-size:8pt;height:130px;box-shadow:0px 0px 5px #ccc;';
                var styleDocCols = 'color:white;text-align:center;padding:6px !important;position:relative !important;';

                var html2 = '<li style="color:#ccc;"><a href="#" class="portalNavDocBtn toggleFolderListBtn" data-empresa="documents"><i style="font-size:12pt;" class="fa fa-folder"  aria-hidden="true"></i>  Bandeja de entrada</a></li><li class="mainFolderFileList"><ul>';
                var flistStyle = '';
                var folder = '';
                if (d['nofiles']) {
                    html2 = html2 + '<li>' + d['nofiles'] + '</li>';
                } else {
                    var linksUrl = 'http://70.35.196.223/promTest/PDF/pdfout.php';
                    //html = html+'<ul class="fileList">';

                    for (var key in d['Bandeja de entrada']) {

                        var last4 = key.substr(key.length - 4);
                        if (last4.charAt(0) == '.') {
                            continue;
                        } else {

                            html2 = html2 + '<li><a class="folderBtn" href="#" data-folder="' + key + '" style="' + flistStyle + '"><i style="font-size:9pt;" class="fa fa-folder-o" aria-hidden="true"></i>  ' + key + '</a></li>';

                        }

                    }
                    html2 = html2 + '</ul></li>';
                }
                $('.folderList').append(html2);
                $('.loadingCtn').fadeOut();
            }
        });
    } else if ((elm == 'dash')) {
        $('.loadingCtn').show();
        clearAll();
        $.ajax({
            async: true,
            type: "get",
            url: "src/controler.php?req=files",
            success: function(res) {
                var d = JSON.parse(res);
                doc_data = d;

                var html = '<h4>Bandeja de entrada</h4><div class="row">';

                var flistStyle = '';
                var folder = '';
                if (d['nofiles']) {
                    html = html + '<p>' + d['nofiles'] + '</p>';
                } else {
                    var linksUrl = 'http://70.35.196.223/promTest/PDF/pdfout.php';
                    //html = html+'<ul class="fileList">';

                    for (var key in d['Bandeja de entrada']) {

                        var last4 = key.substr(key.length - 4);
                        if (last4.charAt(0) == '.') {

                            //Manipulando texto
                            var dot = key.split('.');
                            var final = dot[0].split('_');
                            var linkText = final[0] + '_' + final[1] + '.pdf';

                            //Agregando elemento
                            html = html + '<div class="col-md-12 docRow"><div class="docRowInnerCtnr"><i title="Borrar Documento" class="fa fa-trash delfile" data-docid="' + d['Bandeja de entrada'][key] + '" aria-hidden="true" ></i><a target="blank" href="' + linksUrl + '?docid=' + d['Bandeja de entrada'][key] + '"><i style="font-size:15pt;color:darkred;" class="fa fa-file-pdf-o" aria-hidden="true"></i>        ' + linkText + '</a></div></div>';

                        } else {

                            html = html + '<div class="col-md-12 docRow" ><div  class="docRowInnerCtnr"><i title="Borrar Documento" class="fa fa-trash delfile" data-folder="' + key + '" aria-hidden="true" ></i><a class="folderBtn" href="#" data-folder="' + key + '" style="' + flistStyle + '"><i style="font-size:15pt;color:#FDB813;" class="fa fa-folder" aria-hidden="true"></i>        ' + key + '</a></div></div>'


                        }

                    }

                    html = html + '</div>';

                }
                $('.fileContainer').append('<div class="fileContrBtns"><button type="button" class="newFolderBtn"><i style="position:absolute;top:3;right:2;" class="fa fa-plus" aria-hidden="true"></i><i  class="fa fa-folder" aria-hidden="true"></i></button>' +
                    '<button type="button" class="newDocumBtn"><i style="position:absolute;top:3;right:2;" class="fa fa-plus" aria-hidden="true"></i><i class="fa fa-file" aria-hidden="true"></i></button></div>');
                $('.fileContainer').append(html);

                $('.fileContainer').fadeIn();
                $('.loadingCtn').fadeOut();
            }
        });

    }

}

function crearFolder() {
    var data = dialog.find("form").serialize();
    $.ajax({
        async: true,
        type: 'get',
        url: 'src/controler.php?req=newFold&' + data,
        success: function(res) {
            if (res == 1) {
                dialog.dialog("close");
                renderFiles('both');
            } else {
                console.log('folder ya existe');
            }
        }
    });
}

function open_folder(folder) {

    clearAll();
    var linksUrl = 'http://70.35.196.223/promTest/PDF/pdfout.php';
    var styleDocTile = 'border-radius:3px;background-color:rgba(3,3,3,.5);padding:20px;font-size:8pt;height:130px;box-shadow:0px 0px 5px #000;';
    var styleDocCols = 'color:white;text-align:center;padding:6px !important;position:relative !important;';
    var html = '<div class="row"><h2 style="color:#ccc;">' + folder + '</h2>';
    var arr = [];
    for (var key in doc_data['Bandeja de entrada'][folder]) {

        //Manipulando texto
        var newstr = doc_data['Bandeja de entrada'][folder][key].split('-');
        var dot = newstr[0].split('.');
        var final = dot[0].split('_');
        var linkText = final[0] + '_' + final[1] + '.pdf';

        //Agregando Elemento
        html = html + '<div class="col-md-2" style="' + styleDocCols + '"><div style="position:relative;padding:20px 0px !important;"><i title="Borrar Documento" class="fa fa-trash delfile"  data-docid="' + newstr[1] + '" aria-hidden="true" ></i><a style="color:#333;font-size:7pt !important;" target="blank" href="' + linksUrl + '?docid=' + newstr[1] + '"><i style="font-size:15pt;color:darkred;" class="fa fa-file-pdf-o" aria-hidden="true"></i><br/>' + linkText + '</a></div></div>';

    }
    html = html + '</div>';
    $('.fileContainer').append(html);
    $('.fileContainer').fadeIn();



}

function del_file(folder, file) {

    var fileUrl = '';
    if (file == undefined && folder != '') {
        var mes = 'El folder <b>' + folder + '</b> y todo su contenido sera permanente borrado. Esta operacion NO es reverzible. Desea continuar?';
        $('#dialogo_confirmacion .confirmacion_mensaje').html(mes);
        console.log(folder);
        $("#dialogo_confirmacion").dialog({
            resizable: false,
            height: "auto",
            width: 350,
            modal: true,
            title: 'Esta seguro?',
            buttons: {
                "Borrar documento": function() {
                    var iconStyle = 'font-size:18pt;color:green;float:left;';

                    $.ajax({
                        async: true,
                        type: 'get',
                        url: 'src/controler.php?req=deldir&folderName=' + folder,
                        success: function(res) {
                            console.log(res)
                            if (res == 1) {
                                renderFiles('both');
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
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });

    } else {
        var mes = 'El documento <b style="font-size:8pt !important;">' + file + '</b> sera permanente borrado. Esta operacion NO es reverzible. Desea continuar?';
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
                            if (res == 1 && folder == '') {
                                renderFiles('both');
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
                                console.log(folder);
                                open_folder(folder);
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
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
    }





}

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
            var html = '<h4>Cambio de datos</h4><div class="ctn"><div class="row">' +
                '<div class="col-md-6"><div>Nombre</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_name'] + '</p></div><div class="col-md-3"><i data-field="Nombre" data-col="client_name" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Apellido</div> </div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_lastname'] + '</p></div><div class="col-md-3"><i data-field="Apellido" data-col="client_lastname" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Telefono Fijo</div> </div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_phone'] + '</p></div><div class="col-md-3"><i data-field="Telefono Fijo" data-col="client_phone" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Telefono Movil</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_mobil'] + '</p></div><div class="col-md-3"><i data-field="Telefono Movil" data-col="client_mobil" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Correo Electronico</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_email'] + '</p></div><div class="col-md-3"><i data-field="Correo Electronico" data-col="client_email" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>NIT</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_cedula'] + '</p></div><div class="col-md-3"><i data-field="NIT" data-col="client_cedula" data-cid="' + d['client_id'] + '" class="fa fa-pencil edit" aria-hidden="true"></i></div></div></div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6"><div>Clave de Acceso</div></div>' +
                '<div class="col-md-6"><div class="row"><div class="col-md-9"><p>' + d['client_password'] + '</p></div><div class="col-md-3"><i class="fa fa-lock cambiarClaveBtn" aria-hidden="true"></i></div></div></div>' +
                '</div></div>';

            $('.cambiarDatosFormCtnr').html(html);
            $('.cambiarDatosFormCtnr').fadeIn();
            $('.loadingCtn').fadeOut();

            console.log(d);
        }
    });
}

function cambiar_clave(newpassdata) {
    console.log(newpassdata);
    $.ajax({
        async: true,
        type: 'post',
        data: newpassdata,
        url: 'src/controler.php?req=changepass',
        success: function(res) {
            console.log(res);
        }
    });
}

function editar_dato_usuario(data, id) {

    var newd = data.split('=');
    var s = newd[0] + "='" + newd[1] + "'";
    var obj = { key: newd[0], d: newd[1], field: s, cid: id };
    $.ajax({
        async: true,
        type: 'post',
        data: { obj: JSON.stringify(obj) },
        url: 'src/controler.php?req=edituser',
        success: function(res) {
            console.log(res);
            if (res == 1) {
                var iconStyle = 'font-size:18pt;color:green;float:left;';
                $('#dialog-message').html('<spam style="' + iconStyle + '" class="fa fa-thumbs-up" aria-hidden="true"></spam><p class="dialog_mess"> Su informacion ah sido actializada exitosamente!</p>');
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

            }


        }
    });


}
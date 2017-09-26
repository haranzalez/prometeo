class Contacto {

    constructor(formId) {
        this.formulario(formId);
        this.contactEmail = 'haranzalez@gmail.com';
    }

    formulario(formId) {
        var html = '<h3>Contactenos<b style="color:darkred;">.</b></h3><p class="intro">Gracias por su interes en Prometeo. Porfavor use este formulario si tiene alguna pregunta acerca de nuestro producto y nos comunicaremos de vuelta lo mas pronto posible</p>';
        html = html + '<form>' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<p><b style="color:darkred;">*</b>Correo Electronico:</p>' +
            '<input type="email" name="email">' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-6">' +
            '<p><b style="color:darkred;">*</b>Nombre:</p>' +
            '<input type="text" name="name">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<p><b style="color:darkred;">*</b>Apellido:</p>' +
            '<input type="text" name="lastname">' +
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
            '<textarea name="message"></textarea>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<div class="g-recaptcha" data-sitekey="6LdEcTEUAAAAAJUyuhazGxJP0vrX04kt7ozbJADI"></div>' +
            '</div>' +
            '</div><br/>' +
            '<div class="row">' +

            '<div class="col-md-12">' +

            '<button type="button" class="sendBtn">Enviar</button>  ' +
            '  <input type="checkbox" name="copyEmail"> <spam>Enviar copia a mi correo</spam>' +
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

    messageEmail(data) {

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'src/controler.php?req=contactEmail');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else if (xhr.status !== 200) {
                console.log(xhr.status);
            }
        };
        xhr.send(data);


    }



}
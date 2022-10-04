/*=============================================
REGISTRO
=============================================*/
$(document).ready(function() {

    $("#pass01 a").on('click', function(event) {
        event.preventDefault();
        if($('#pass01 input').attr("type") == "text"){
            $('#pass01 input').attr('type', 'password');
            $('#pass01 i').addClass( "fa-eye-slash" );
            $('#pass01 i').removeClass( "fa-eye" );
        }else if($('#pass01 input').attr("type") == "password"){
            $('#pass01 input').attr('type', 'text');
            $('#pass01 i').removeClass( "fa-eye-slash" );
            $('#pass01 i').addClass( "fa-eye" );
        }
    });
    
    $("#pass02 a").on('click', function(event) {
        event.preventDefault();
        if($('#pass02 input').attr("type") == "text"){
            $('#pass02 input').attr('type', 'password');
            $('#pass02 i').addClass( "fa-eye-slash" );
            $('#pass02 i').removeClass( "fa-eye" );
        }else if($('#pass02 input').attr("type") == "password"){
            $('#pass02 input').attr('type', 'text');
            $('#pass02 i').removeClass( "fa-eye-slash" );
            $('#pass02 i').addClass( "fa-eye" );
        }
    });

}); //FIN DOCUMENT

var app = new Vue({
    el: '#login',
    data: {
        btnLogin: {
            txt: '<i class="fas fa-sync-alt"></i> INGRESAR',
            disabled: true
        },
        btnContacto: {
            txt: '<i class="fas fa-sync-alt"></i> ENVIAR',
            disabled: true
        },
        btnRecuperar: {
            txt: '<i class="fas fa-sync-alt"></i> ENVIAR',
            disabled: true
        },
        btnPass: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR',
            disabled: true
        },
        login: {},
        contacto: {},
        contactoBool: {},
        contactoError: {},
        recuperar: {},
        recuperarBool: {},
        recuperarError: {},
        pass:{},
        passError:{},
        passBool:{},
    },
    methods: {
        sendLogin(){
            const self          = this;
            const titleAccion   = 'LOGIN';
            this.btnLoginLoad(true, true);
            Swal.showLoading();
            
            const dataString = { login: this.login };
            this.$http.post(base_url + 'login/login', dataString).then(function(res) {

                if( !res.data.existe ){
                    self.swalErrorText(titleAccion, 'USUARIO/CONTRASEÑA NO COINCIDEN, FAVOR VOLVER A INTENTAR');
                    self.btnLoginLoad(false, false);
                }

                if( res.data.existe && !res.data.permiso ){
                    self.swalErrorText(titleAccion, 'NO TIENES PERMISOS PARA INGRESAR, FAVOR CONTÁCTATE CON NOSOTROS, GRACIAS');
                    self.btnLoginLoad(false, true);
                }
                
                if( res.data.existe && res.data.permiso ){
                    window.location.href = res.data.URL;
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnLoginLoad(false, false);
                console.log('Error sendLogin');
            })

        },
        validateLogin(){
            if( this.login.user && this.login.pass ){
                this.btnLogin.disabled = false;
            }else{
                this.btnLogin.disabled = true;
            }
        },
        sendContacto(){
            const self          = this;
            const titleAccion   = 'CONTACTO';
            const textAccion    = 'TU MENSAJE HA SIDO ENVIADO CON ÉXITO, PRONTO NOS CONTACTAREMOS CONTIGO, GRACIAS!!!';
            this.btnContactoLoad(true, true);
            Swal.showLoading();
            
            var dataString = { contacto: this.contacto };
            this.$http.post(base_url + 'login/contacto', dataString ).then(function(res) {

                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.contacto = {};
                    self.btnContactoLoad(false, true);
                }else{
                    self.swalError(titleAccion);
                    self.btnContactoLoad(false, false);
                }

            }, function() {
                self.swalLog(titleAccion);
                self.btnContactoLoad(false, false);
                console.log('Error sendContacto');
            });
        },
        validarContacto(){
            if( this.contactoBool.nombre && 
                this.contactoBool.email && 
                this.contactoBool.mensaje ){
                this.btnContacto.disabled = false;
            }else{
                this.btnContacto.disabled = true;
                this.btnContacto.txt = '<i class="fas fa-sync-alt"></i> ENVIAR';
            }
        },
        validarContactoNombre(){
            if( !this.contacto.nombre ){
                this.contactoError.nombre = '*Nombre obligatorio';
                this.contactoBool.nombre = false;
            }
            else{
                this.contactoError.nombre = '';
                this.contactoBool.nombre = true;
            } 
            this.validarContacto();
        },
        validarContactoEmail(){
            if ( validateEmail(this.contacto.email) ) {
                this.contactoError.email = '';
                this.contactoBool.email = true;
            }else{
                this.contactoError.email = '*Correo electrónico no válido';
                this.contactoBool.email = false;
            }
            this.validarContacto();
        },
        validarContactoMensaje(){
            if( !this.contacto.mensaje ){
                this.contactoError.mensaje = '*Mensaje obligatorio';
                this.contactoBool.mensaje = false;
            }
            else{
                this.contactoError.mensaje = '';
                this.contactoBool.mensaje = true;
            } 
            this.validarContacto();
        },
        recuperarPass(){
            const self          = this;
            const titleAccion   = 'RECUPERAR CONTRASEÑA';
            const textAccion    = 'HEMOS ENVIADO UN ENLACE A TU CORREO PARA QUE PUEDAS RECUPERAR TU CONTRASEÑA, GRACIAS!!!';
            this.btnRecuperarLoad(true, true);
            Swal.showLoading();
            
            var dataString = { recuperar: this.recuperar };
            this.$http.post(base_url + 'login/recuperarpass', dataString ).then(function(res) {

                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.recuperar = {};
                    self.btnRecuperarLoad(false, true);
                }else if( res.data.existe ){
                    self.swalErrorText(titleAccion, 'EMAIL NO REGISTRADO, FAVOR INGRESAR UN EMAIL EXISTENTE EN NUESTRA BASE DE DATOS');
                    self.btnRecuperarLoad(false, false);
                }else{
                    self.swalErrorText(titleAccion, 'SE HA PRODUCIDO UN ERROR , FAVOR VOLVER A INTENTAR');
                    self.btnRecuperarLoad(false, false);
                }

            }, function() {
                self.swalLog(titleAccion);
                self.btnRecuperarLoad(false, false);
                console.log('Error recuperarPass');
            });
        },
        validarRecuperar(){
            if( this.recuperarBool.email ){
                this.btnRecuperar.disabled = false;
            }else{
                this.btnRecuperar.disabled = true;
                this.btnRecuperar.txt = '<i class="fas fa-sync-alt"></i> ENVIAR';
            }
        },
        validarRecuperarEmail(){
            if ( validateEmail(this.recuperar.email) ) {
                this.recuperarError.email = '';
                this.recuperarBool.email = true;
            }else{
                this.recuperarError.email = '*Correo electrónico no válido';
                this.recuperarBool.email = false;
            }
            this.validarRecuperar();
        },
        sendNewPass(){
            const self          = this;
            const titleAccion   = 'NUEVA CONTRASEÑA';
            const textAccion    = 'CONTRASEÑA EDITADA EXITOSAMENTE, TE REDIRECCIONAREMOS AL LOGIN';
            this.btnPassLoad(true, true);
            Swal.showLoading();
            
            var dataString = { pass: this.pass };
            this.$http.post(base_url + 'login/changepass', dataString ).then(function(res) {

                self.btnPassLoad(false, false);
                if( res.data.ok ){
                    self.pass = {};
                    Swal.fire({
                        title: titleAccion,
                        text: textAccion,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#5cb85c',
                        allowOutsideClick: false
                    }).then((result) => {
                        self.btnPassLoad(true, true);
                        if( result.isConfirmed ){
                            Swal.fire({
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })
                            window.location.href = base_url;
                        }
                    });
                }else if( !res.data.valido ){
                    self.swalErrorText(titleAccion, 'TUS PERMISOS PARA CAMBIAR LA CONTRASEÑA SON INCORRECTOS, FAVOR VOLVER A GENERAR EL ENLACE');
                }else{
                    self.swalError(titleAccion);
                }

            }, function() {
                self.swalLog(titleAccion);
                self.btnPassLoad(false, false);
                console.log('Error sendNewPass');
            });
        },
        validarPassBool(){
            if( this.passBool.pass01 ){
                this.btnPass.disabled = false;
                let urlParams = new URLSearchParams(window.location.search);
                this.pass.u = urlParams.get('u');
                this.pass.h = urlParams.get('h');
            }else{
                this.btnPass.disabled = true;
                this.btnPass.txt = '<i class="fas fa-sync-alt"></i> EDITAR';
            }
        },
        validarPass(){

            if( this.pass.pass01.length < 7 ){
                this.passError.pass = 'Contraseña, mínimo 7 carácteres';
                this.passBool.pass01 = false;
                this.validarPassBool();
                return
            }else{
                this.passError.pass = '';
                this.passBool.pass01 = true;
            }

            if ( (this.pass.pass01.length >= 7) && (this.pass.pass01 != this.pass.pass02) ) {
                this.passError.pass = 'Contraseñas no coinciden';
                this.passBool.pass01 = false;
                this.validarPassBool();
                return
            }else{
                this.passError.pass = '';
                this.passBool.pass01 = true;
            }

            this.validarPassBool();

        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANDO...';
        },
        btnLoginLoad(load, dis){
            this.btnLogin.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> INGRESAR'
            this.btnLogin.disabled = dis;
        },
        btnContactoLoad(load, dis){
            this.btnContacto.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> ENVIAR'
            this.btnContacto.disabled = dis;
        },
        btnRecuperarLoad(load, dis){
            this.btnRecuperar.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> ENVIAR'
            this.btnRecuperar.disabled = dis;
        },
        btnPassLoad(load, dis){
            this.btnPass.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> ENVIAR'
            this.btnPass.disabled = dis;
        },
        swalSuccess(titleAccion, textAccion){
            Swal.fire({
                title: titleAccion,
                text: textAccion,
                icon: 'success',
                confirmButtonColor: '#0275d8',
                allowOutsideClick: false
            });
        },
        swalError(titleAccion){
            Swal.fire({
                title: titleAccion,
                text: 'UN ERROR INESPERADO SE HA PRODUCIDO, FAVOR VOLVER A INTENTAR.',
                icon: 'error',
                confirmButtonColor: '#0275d8',
                allowOutsideClick: false
            });
        },
        swalErrorText(titleAccion, textoAccion){
            Swal.fire({
                title: titleAccion,
                text: textoAccion,
                icon: 'error',
                confirmButtonColor: '#0275d8',
                allowOutsideClick: false
            });
        },
        swalLog(titleAccion){
            Swal.fire({
                title: titleAccion,
                text: '* UN ERROR INESPERADO SE HA PRODUCIDO, FAVOR VOLVER A INTENTAR.',
                icon: 'error',
                confirmButtonColor: '#0275d8',
                allowOutsideClick: false
            });
        },
    }
  })
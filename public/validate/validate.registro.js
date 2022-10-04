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
    el: '#app',
    data: {
        btnRegistro: {
            txt: '<i class="fas fa-sync-alt"></i> REGISTRARME',
            disabled: true
        },
        registro: {
            fono: '+569',
            direccion: '',
            ciudad: ''
        },
        ciudades: '',
        dsbCiudad: true,
        region: '',
        boolEmail: false,
        error:{},
        boolRegistro:{},
        loadingMail: '',
        loadingCity: '',
        referidos: '',
        referido: '',
    },
    created() {
        this.instanciar();
    },
    methods: {
        instanciar() {
            const self = this;
            this.$http.post(base_url + 'login/referido').then(function(res) {

                self.referidos =  res.data.referidos;
                                
            }, function() {
                console.log('Error instanciar');
            });
        },
        sendRegistro(){
            const self          = this;
            const titleAccion   = 'REGISTRO';
            const textAccion    = 'REGISTRO REALIZADO EXITOSAMENTE. TE HEMOS ENVIADO UN EMAIL PARA VALIDAR TU INSCRIPCIÓN';
            this.btnRegistroLoad(true, true);
            Swal.showLoading();
            
            const dataString = { registro: this.registro };
            this.$http.post(base_url + 'registro/ingreso', dataString).then(function(res) {
                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.resetRegistro();
                    self.btnRegistroLoad(false, true);
                }else if( res.data.errormail ){
                    self.swalErrorText(titleAccion, 'CORREO ELECTRÓNICO EXISTENTE, INGRESAR OTRO.');
                    self.btnRegistroLoad(false, false);
                }else{
                    self.swalError(titleAccion);
                    self.btnRegistroLoad(false, false);
                }

            },
            function() {
                self.swalError(titleAccion);
                self.btnRegistroLoad(false, false);
                console.log('Error sendRegistro');
            })

        },
        validar(){
            if( this.boolRegistro.nombre &&
                this.boolRegistro.ciudad &&
                this.boolRegistro.fono &&
                this.boolRegistro.email &&
                this.boolRegistro.pass01 &&
                this.boolRegistro.referido &&
                this.boolRegistro.responsable ){
                this.btnRegistroLoad(false, false);
            }else{
                this.btnRegistroLoad(false, true);
            }
        },
        validarNombre(){
            if( !this.registro.nombre ){
                this.error.nombre = '*Nombre empresa obligatorio';
                this.boolRegistro.nombre = false;
            }
            else{
                this.error.nombre = '';
                this.boolRegistro.nombre = true;
            } 
            this.validar();
        },
        validarResponsable(){
            if( !this.registro.responsable ){
                this.boolRegistro.responsable = false;
            }
            else{
                this.registro.responsable       = this.registro.responsable.toUpperCase();
                this.boolRegistro.responsable   = true;
            } 
            this.validar();            
        },
        validarDireccion(){
            // if( !this.registro.direccion ){
            //     this.error.direccion = '*Dirección empresa obligatorio';
            //     this.boolRegistro.direccion = false;
            // }
            // else{
            //     this.error.direccion        = '';
            //     this.boolRegistro.direccion = true;
            // }
            this.registro.direccion     = this.registro.direccion.toUpperCase();
            this.validar();
        },
        validarFono(){
            if (this.registro.fono.match(/^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/)) {
                this.error.fono = '';
                this.boolRegistro.fono = true;
            }else{
                this.error.fono = 'N° Celular no válido';
                this.boolRegistro.fono = false;
            }
            this.validar();
        },
        validarEmail(){
            this.loadingMail = '';
            const match = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

            if ( this.registro.email.match(match) ) {
                this.error.email = '';
            }else{
                this.error.email = 'Correo electrónico no válido';
                this.boolRegistro.email = false;
                this.validar();
            }

            if(this.error.email == ''){
                this.existeEmail();
            }            
        },
        validarCiudad(){
            if( !this.registro.ciudad ){
                this.error.ciudad = '*Ciudad empresa obligatorio';
                this.boolRegistro.ciudad = false;
            }
            else{
                this.error.ciudad = ''; 
                this.boolRegistro.ciudad = true;
            } 
            this.validar();
        },
        validarPass(){

            if( this.registro.pass01.length < 7 ){
                this.error.pass = 'Contraseña, mínimo 7 carácteres';
                this.boolRegistro.pass01 = false;
                this.validar();
                return
            }else{
                this.error.pass = '';
                this.boolRegistro.pass01 = true;
            }

            if ( (this.registro.pass01.length >= 7) && (this.registro.pass01 != this.registro.pass02) ) {
                this.error.pass = 'Contraseñas no coinciden';
                this.boolRegistro.pass01 = false;
                this.validar();
                return
            }else{
                this.error.pass = '';
                this.boolRegistro.pass01 = true;
            }

            this.validar();

        },
        validarReferido(){

            if( this.referido.bool ){
                if( this.referido.nombre ){
                    this.error.referido         = '';
                    this.referido.nombre        = this.referido.nombre.toUpperCase();
                    this.registro.referido      = this.referido.nombre;
                    this.boolRegistro.referido  = true;
                }else{
                    this.error.referido         = 'Ingresar nombre de quién te invitó';
                    this.boolRegistro.referido  = false;
                }
            }else{
                this.error.referido = '';
                if( this.referido ){
                    this.registro.referido      = this.referido.value;
                    this.boolRegistro.referido  = true;
                }else{
                    this.referido.nombre        = '';
                    this.boolRegistro.referido  = false;
                }
            }

            this.validar();

        },
        getCiudad(){

            const self          = this;
            this.dsbCiudad      = true;
            this.error.ciudad   = '';
            this.loadingCity    = '<i class="fas fa-spinner fa-spin"></i>';

            const dataString = { region: this.region };
            this.$http.post(base_url + 'geo/ciudadPorRegion', dataString).then(function(res) {

                self.ciudades = res.data.ciudades;
                self.dsbCiudad = self.region != '' ? false : true;
                self.registro.ciudad = '';
                self.loadingCity = '';
                self.validarCiudad();

            },
            function() {
                console.log('Error getCiudad');
            })
        },
        async existeEmail(){

            const self = this;
            this.loadingMail = '<i class="fas fa-spinner fa-spin"></i>';

            const dataString = { email: this.registro.email };
            await this.$http.post(base_url + 'registro/existeEmail', dataString).then(function(res) {

                self.loadingMail = '';
                
                self.boolEmail = res.data.existe;
                if( res.data.existe ){
                    self.error.email = 'Correo electrónico existente, ingresar otro';
                    self.boolRegistro.email = false;
                    self.validar();
                }else{
                    self.error.email = '';
                    self.boolRegistro.email = true;
                    self.validar();                    
                }

            },
            function() {
                console.log('Error existeEmail');
            })
        },
        resetRegistro(){
            this.registro = {};
            this.registro.fono = '+569';
            this.registro.ciudad = '';
            this.ciudades = '',
            this.dsbCiudad = true,
            this.region = '',
            this.boolEmail = false,
            this.error = {},
            this.boolRegistro = {},
            this.loadingMail = '';
            this.btnRegistroLoad(false, true);
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANDO...';
        },
        btnRegistroLoad(load, dis){
            this.btnRegistro.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> REGISTRARME'
            this.btnRegistro.disabled = dis;
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
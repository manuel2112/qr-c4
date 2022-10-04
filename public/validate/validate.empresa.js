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
    
    $("#pass03 a").on('click', function(event) {
        event.preventDefault();
        if($('#pass03 input').attr("type") == "text"){
            $('#pass03 input').attr('type', 'password');
            $('#pass03 i').addClass( "fa-eye-slash" );
            $('#pass03 i').removeClass( "fa-eye" );
        }else if($('#pass03 input').attr("type") == "password"){
            $('#pass03 input').attr('type', 'text');
            $('#pass03 i').removeClass( "fa-eye-slash" );
            $('#pass03 i').addClass( "fa-eye" );
        }
    });

}); //FIN DOCUMENT

new Vue({
    el: '#app',
    data: {
        loadInit: true,
        cutBool: true,
        jcrop: '',
        coords: null,
        widthResize: 360,
        imgTemp: '',
        imgTempSrc: '',
        empresa:{},
        membresia:{},
        membresiasContratadas: {},
        vistas: {},
        resVistas: {},
        permiso: false,
        region: '',
        ciudad: '',
        ciudades: '',
        slugURL: '',
        imgProps:{},
        dsbCiudad: true,
        boolEditarCiudad: false,
        classEditarCiudad: 'hide-ciudad',
        error:{},
        txtIngresarEditarLogo: '',
        editEmpresa:{},
        editPass:{},
        boolValidar:{
            fono: true,
            direccion: true
        },
        btnDatos: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR DATOS',
            disabled: false
        },
        btnRRSS: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR REDES SOCIALES',
            disabled: true
        },
        btnPass: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR CONTRASEÑA',
            disabled: true
        },
    },
    created() {
        this.instanciar();
        this.jQueryIntance();
        this.imgProps = imgProps();
    },
    methods: {
        instanciar() {
            this.loadInit ? Swal.showLoading() : '' ;
            const self = this;
            this.$http.post(base_url + 'empresa/instanciar').then(function(res) {
                
                self.empresa                = res.data.empresa;
                self.txtIngresarEditarLogo  = self.empresa.EMPRESA_LOGOTIPO ? 'EDITAR' : 'INGRESAR' ;
                self.membresiasContratadas  = res.data.membresias;
                self.permiso                = res.data.permiso;
                self.slugURL                = res.data.slugURL;
                self.vistas                 = res.data.vistas;
                
                self.instanciarRedes( res.data.edit );
                self.loadInit ? Swal.close() : '' ;
                self.loadInit = false;
                                
            }, function() {
                console.log('Error instanciar');
            });
        },
        jQueryIntance(){
            $(".img-logo").filestyle({
                btnClass: "btn-danger",
                text: "<i class='fas fa-folder-open'></i>  Buscar imagen para logotipo",
                placeholder: "OPCIONAL"
            });
        },
        cutImgTemp(e,element){
            this.cutBool ? this.instJcrop(element) : this.destroyJcrop() ;
            this.cutBool = !this.cutBool;
        },
        instJcrop(element){
            const self  = this;
            this.jcrop = $.Jcrop(element, {
                onChange: showCoords,
                onSelect: showCoords,
                bgColor: 'black',
                bgOpacity: .3,
                setSelect: [ 0, 0, 100, 100 ],
                aspectRatio: 1 / 1
            });
            function showCoords(c)
            {
                self.coords = c; 
            };
        },
        destroyJcrop(){
            this.jcrop.destroy();
            this.coords = null;
        },
        loadImg( event ) {
            const titleAlert = "IMAGEN";
            const file = event.target.files[0];
            this.imgTemp = event.target.files[0];
            const type = file.type;
            const size = file.size;
            
            if ( imgTypes(type) ) {
                this.swalErrorText(titleAlert, this.imgProps.avisoTypes);
                return;
            }
            if( imgSize(size) ){
                this.swalErrorText(titleAlert, this.imgProps.avisoSizeSuperado);
                return;
            }
            
            const reader = new FileReader()
            const self = this
            reader.onload = function (e) {
                self.imgTempSrc = e.target.result;
            }
            reader.readAsDataURL(file);
            $('#insert-logo').val('');
        },
        deleteImgTemp(){
            this.imgTemp    = '';
            this.imgTempSrc = '';
            this.coords     = null;
            this.cutBool    = true;
        },
        instanciarRedes( value ){
            this.editEmpresa    = value;
            this.editEmpresa.EMPRESA_WHATSAPP =  this.editEmpresa.EMPRESA_WHATSAPP ? this.editEmpresa.EMPRESA_WHATSAPP : '+56' ;
        },
        resetMdl(){
            this.instanciar();
            this.error = {};            
        },
        getCiudad(){
            const self = this;
            this.dsbCiudad = true;

            const dataString = { region: this.region };
            this.$http.post(base_url + 'geo/ciudadPorRegion', dataString).then(function(res) {

                self.ciudades = res.data.ciudades;
                self.dsbCiudad = self.region != '' ? false : true;
                self.ciudad = '';

            },
            function() {
                console.log('Error getCiudad');
            })
        },
        btnEditarCiudad(){
            this.classEditarCiudad = this.boolEditarCiudad ? 'hide-ciudad' : 'show-ciudad';
            this.boolEditarCiudad = !this.boolEditarCiudad;
        },
        editDatos(){
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'EDITAR DATOS EMPRESA';
            const textAccion    = 'LOS DATOS DE TU EMPRESA SE HAN EDITADO EXITOSAMENTE';
            this.btnDatosLoad(true, true);
            
            const dataString = { nombre: this.empresa.EMPRESA_NOMBRE,
                                 fono: this.empresa.EMPRESA_FONO, 
                                 direccion: this.empresa.EMPRESA_DIRECCION, 
                                 comuna: this.empresa.CIUDAD_ID, 
                                 nuevaCiudad: this.ciudad,
                                 descripcion: this.empresa.EMPRESA_DESCRIPCION };
            this.$http.post(base_url + 'empresa/editDatos', dataString).then(function(res) {

                self.btnDatosLoad(false, false);                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
                    $('#modalEditarDatos').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnDatosLoad(false, false); 
                console.log('Error editDatos');
            })
        },
        validarNombre(){
            if( !this.empresa.EMPRESA_NOMBRE ){
                this.error.nombre = '*Nombre empresa obligatorio';
                this.boolValidar.nombre = false;
            }
            else{
                this.error.nombre = '';
                this.boolValidar.nombre = true;
            } 
            this.validarDatos();
        },
        validarFono(){
            if (this.empresa.EMPRESA_FONO.match(/^(\+?56)?(\s?)(0?9)(\s?)[98765432]\d{7}$/)) {
                this.error.fono = '';
                this.boolValidar.fono = true;
            }else{
                this.error.fono = 'N° Celular no válido';
                this.boolValidar.fono = false;
            }
            this.validarDatos();
        },
        validarDatos(){
            
            if( this.boolValidar.fono &&
                this.boolValidar.nombre  ){
                this.btnDatos.disabled = false;
            }else{
                this.btnDatos.disabled = true;
            }
        },
        resetCiudad(){
            this.region = '';
            this.ciudad = '';
            this.getCiudad();
        },
        cleanEditar(){
            this.validarNombre();
            this.validarFono();
            this.boolEditarCiudad = true;
            this.resetCiudad();
            this.btnEditarCiudad();
        },
        uploadLogo(){
            const self          = this;
            const titleAccion   = 'LOGO';
            const textAccion    = 'LOGO INGRESADO EXITOSAMENTE';
            Swal.showLoading();

            const formData = new FormData();
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );
            this.$http.post(base_url + 'empresa/uploadLogo', formData ).then(function(res) {
                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
                    self.deleteImgTemp();
                    $('#modalLogo').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            }, function() {
                self.swalLog(titleAccion);
                console.log('Error uploadLogo');
            });
        },
        instanciarMdlLogo(){
            Swal.showLoading();
            Swal.close();
        },
        mdlRRSS(){
            this.error.whatsapp = '';
            this.btnRRSS.disabled = true;            
        },
        editRedes(){
            const self          = this;
            const titleAccion   = 'REDES SOCIALES';
            const textAccion    = 'LAS REDES SOCIALES DE TU EMPRESA SE HAN EDITADO EXITOSAMENTE';
            this.btnRRSSLoad(true, true);
            Swal.showLoading();

            let insertWhatsapp = this.editEmpresa.EMPRESA_WHATSAPP;
            if( insertWhatsapp == '+56' || insertWhatsapp == ''){ insertWhatsapp = null; }
            
            const dataString = { whatsapp: insertWhatsapp,
                                 web: this.editEmpresa.EMPRESA_WEB,
                                 facebook: this.editEmpresa.EMPRESA_FACEBOOK,
                                 instagram: this.editEmpresa.EMPRESA_INSTAGRAM };
            this.$http.post(base_url + 'empresa/editRedes', dataString).then(function(res) {

                self.btnRRSSLoad(false, false);                
                if( res.data.ok ){
                    self.instanciar();
                    self.swalSuccess(titleAccion, textAccion);
                    $('#modalEditarRedes').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnRRSSLoad(false, false);
                console.log('Error editRedes');
            })
        },
        validarRedes(){
            if( this.boolValidar.whatsapp ||
                this.boolValidar.web ||
                this.boolValidar.facebook ||
                this.boolValidar.instagram ){
                this.btnRRSS.disabled = false;
            }else{
                this.btnRRSS.disabled = true;
            }
        },
        validarWhatsapp(){
            if ( this.editEmpresa.EMPRESA_WHATSAPP.match(/^(\+?56)?(\s?)(0?9)(\s?)[98765432]\d{7}$/) ) {
                this.error.whatsapp = '';
                this.boolValidar.whatsapp = true;
            }else{
                this.error.whatsapp = 'N° Whatsapp no válido';
                this.boolValidar.whatsapp = false;
            }
            this.validarRedes();
        },
        validarWeb(){
            if ( this.editEmpresa.EMPRESA_WEB ) {
                this.boolValidar.web = true;
            }else{
                this.boolValidar.web = false;
            }
            this.validarRedes();
        },
        validarFacebook(){
            if ( this.editEmpresa.EMPRESA_FACEBOOK ) {
                this.boolValidar.facebook = true;
            }else{
                this.boolValidar.facebook = false;
            }
            this.validarRedes();
        },
        validarInstagram(){
            if ( this.editEmpresa.EMPRESA_INSTAGRAM ) {
                this.boolValidar.instagram = true;
            }else{
                this.boolValidar.instagram = false;
            }
            this.validarRedes();
        },
        cleanPass(){
            this.editPass ={};            
        },
        validarPass(){
            if( this.editPass.actual && this.editPass.nueva && this.editPass.repetir ){
                this.btnPass.disabled = false;
            }else{
                this.btnPass.disabled = true;
            }
        },
        updatePass(){
            const self          = this;
            const titleAccion   = 'CONTRASEÑA';
            const textAccion    = 'LA CONTRASEÑA HA SIDO EDITADA EXITOSAMENTE';
            this.btnPassLoad(true, true);
            Swal.showLoading();
            
            const dataString = { pass: this.empresa.EMPRESA_PASS,
                                 actual: this.editPass.actual,
                                 nueva: this.editPass.nueva,
                                 repetir: this.editPass.repetir};
            this.$http.post(base_url + 'empresa/editPass', dataString).then(function(res) {

                self.btnPassLoad(false, false);                
                if( res.data.error != '' ){
                    self.swalErrorText(titleAccion, res.data.error);
                }else if( res.data.error == '' ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
                    $('#modalEditarPassword').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnPassLoad(false, false);
                console.log('Error editPass');
            })
        },
        deleteLogotipo(){
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = 'SE ELIMINARÁ EL LOGOTIPO';
            const buttonText    = 'SI, ELIMINAR LOGOTIPO';
            const buttonColor   = "#d9534f";
            const apiRest       = base_url + 'empresa/deleteLogo';
            const dataString    = { idEmpresa: this.empresa.EMPRESA_ID };
            const titleAccion   = 'LOGOTIPO';
            const textAccion    = 'EL LOGOTIPO HA SIDO ELIMINADO EXITOSAMENTE';
            const errorAccion   = 'Error deleteLogotipo';

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion);
        },
        getVistas(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'VISTAS MENSUALES';

            this.$http.post(base_url + 'empresa/getVistas').then(function(res) {
                
                if( res.data.ok ){
                    self.resVistas = res.data.vistas;
                    Swal.close();
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error getVistas');
            })
        },
        downPlan(idMembresia){
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = 'SE DARÁ DE BAJA ESTE PLAN';
            const buttonText    = 'SI, ELIMINAR PLAN';
            const buttonColor   = "#d9534f";
            const apiRest       = base_url + 'empresa/downPlan';
            const dataString    = { idMembresia: idMembresia };
            const titleAccion   = 'PLAN';
            const textAccion    = 'EL PLAN HA SIDO ELIMINADO EXITOSAMENTE';
            const errorAccion   = 'Error downPlan';

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion);
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANSO...';
        },
        btnDatosLoad(load, dis){
            this.btnDatos.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> EDITAR DATOS'
            this.btnDatos.disabled = dis;
        },
        btnRRSSLoad(load, dis){
            this.btnRRSS.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> EDITAR REDES SOCIALES'
            this.btnRRSS.disabled = dis;
        },
        btnPassLoad(load, dis){
            this.btnPass.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> EDITAR CONTRASEÑA'
            this.btnPass.disabled = dis;
        },
        swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion){
            const self = this;
            Swal.fire({
                title: title,
                text: txtText,
                showCancelButton: true,
                confirmButtonText: buttonText,
                confirmButtonColor: buttonColor,
                cancelButtonText: 'CANCELAR',
                cancelButtonColor: '#6c757d',
                allowOutsideClick: false
            }).then((result) => {
                if( result.isConfirmed ){
                    Swal.fire({
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    self.$http.post(apiRest, dataString).then(function(res) {
                        
                        if ( res.data.ok ) {
                            Swal.fire({
                                title: titleAccion,
                                text: textAccion,
                                icon: 'success',
                                confirmButtonColor: '#0275d8',
                                allowOutsideClick: false
                            });
                            self.instanciar();
                        }else{
                            Swal.fire( titleAccion, "UN ERROR INESPERADO SE HA PRODUCIDO, FAVOR VOLVER A INTENTAR.", 'error');
                        }
                    },
                    function() {
                        Swal.fire( titleAccion, "* UN ERROR INESPERADO SE HA PRODUCIDO, FAVOR VOLVER A INTENTAR.", 'error'); 
                        console.log(errorAccion);
                    })
                }
            });
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
});
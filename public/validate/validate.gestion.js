
new Vue({
    el: '#app',
    data: {
        parametros: {},
        editParam: {},
        btnEditar: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR PARAMETROS',
            disabled: true
        },
    },
    created() {
        this.instanciar();
    },
    methods: {
        instanciar() {
            Swal.showLoading();
            const self = this;
            this.$http.post(base_url + 'gestion/instanciar').then(function(res) {
                
                self.parametros         = res.data.parametros;
                self.editParam          = res.data.editParametros;
                Swal.close();
                                
            }, function() {
                console.log('Error instanciar');
            });
        },
        mdlReset(){
            this.instanciar();
        },
        editParametros(){
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = "SE EDITARÁN LOS PARAMETROS DEL SISTEMA";
            const buttonText    = "SI, EDITAR PARAMETROS!";
            const buttonColor   = "#5cb85c";
            const apiRest       = base_url + 'gestion/editParametros';
            const dataString    = { parametros: this.editParam };
            const titleAccion   = 'PARAMETROS';
            const textAccion    = "PARAMETROS EDITADOS";
            const errorAccion   = 'Error instanciar';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        ejecutarCron(){
            Swal.showLoading();
            const self = this;
            this.$http.post(base_url + 'cron/index').then(function(res) {
                
                self.swalSuccess('CRON', 'CRON EJECUTADO CON ÉXITO');
                                
            }, function() {
                console.log('Error ejecutarCron');
            });
        },
        validarIva(){
            if( this.editParam.PARAMETRO_IVA > 0 ){
                this.btnEditarLoad(false, false);
            }else{
                this.btnEditarLoad(false, true);              
            }
        },
        validarZona(value){
            this.editParam.PARAMETRO_ZONA_HORARIA = value;
            $(".reset").removeClass("active");  
            this.btnEditarLoad(false, false);          
        },
        validarTransbank(value){
            this.editParam.PARAMETRO_TRANSBANK = value;
            $(".reset").removeClass("active");
            this.btnEditarLoad(false, false);
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANSO...';
        },
        btnEditarLoad(load, dis){
            this.btnEditar.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> EDITAR PARAMETROS'
            this.btnEditar.disabled = dis;
        },
        swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar){
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
                            if( instanciar ){
                                self.instanciar();
                                $('#modalEditarParametros').modal('hide');
                            }
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
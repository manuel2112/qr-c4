
new Vue({
    el: '#app',
    data: {
        loadInit: true,
        empresaPago: false,
        tiposEntrega: {},
        tiposPago: {},
        info: {
            id: '',
            nombre: '',
            desc: '',
            info: '',
            tipo: ''
        },
        btnInfo: {
            txt: '<i class="fas fa-sync-alt"></i> INGRESAR',
            disabled: true
        },
    },
    created() {
        this.instanciar();
    },
    methods: {
        instanciar() {
            this.loadInit ? Swal.showLoading() : '' ;
            const self = this;
            this.$http.post(base_url + 'tipospago/instanciar').then(function(res) {

                // console.log(res.data)
                
                self.empresaPago    = res.data.empresaPago;
                self.tiposEntrega   = res.data.tiposEntrega;
                self.tiposPago      = res.data.tiposPago;

                self.loadInit ? Swal.close() : '' ;
                self.loadInit = false;
                                
            }, function() {
                console.log('Error instanciar');
            });
        },
        accionPago(value){
            const title         = 'ESTÁS SEGURO?';
            const txtText       = value ? 'SE ACTIVARÁ LA PLATAFORMA DE PAGOS' : 'SE DESACTIVARÁ LA PLATAFORMA DE PAGOS';
            const buttonText    = value ? 'SI, ACTIVAR PAGO' : 'SI, DESACTIVAR PAGO';
            const buttonColor   = value ? '#5cb85c' : '#d9534f';
            const apiRest       = base_url + 'tipospago/accionPago';
            const dataString    = { pago: value };
            const titleAccion   = 'PLATAFORMA DE PAGO';
            const textAccion    = value ? 'LA PLATAFORMA DE PAGOS SE HA ACTIVADO EXITOSAMENTE' : 'LA PLATAFORMA DE PAGOS SE HA DESACTIVADO EXITOSAMENTE';
            const errorAccion   = 'Error accionPago';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        accionTipo(id,bool,nmb,tipo){
            const title         = 'ESTÁS SEGURO?';
            const txtText       = bool == 0 ? `SE ACTIVARÁ ${nmb} EN LA PLATAFORMA DE PAGO` : `SE DESACTIVARÁ ${nmb} EN LA PLATAFORMA DE PAGO`;
            const buttonText    = bool == 0 ? 'ACTIVAR' : 'DESACTIVAR';
            const buttonColor   = bool == 0 ? '#5cb85c' : '#d9534f';
            const apiRest       = base_url + 'tipospago/accionTipo';
            const dataString    = { id, bool, tipo };
            const titleAccion   = 'PLATAFORMA DE PAGO';
            const textAccion    = bool == 0 ? `${nmb} SE HA ACTIVADO EXITOSAMENTE` : `${nmb} SE HA DESACTIVADO EXITOSAMENTE`;
            const errorAccion   = 'Error accionTipo';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        infoReset(){
            this.info = {
                id: '',
                nombre: '',
                desc: '',
                info:'',
                tipo: ''
            }
        },
        instanciarModalInfo(id,nombre,desc,info,tipo){
            this.info.id        = id;
            this.info.nombre    = nombre;
            this.info.desc      = desc;
            this.info.info      = info;
            this.info.tipo      = tipo;
            $('#modalInfo').modal('show');
        },
        validateInfo(){
            this.info.info = this.info.info.toUpperCase() 
            this.btnInfoLoad(false, false);
        },
        accionInfo(){
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'INFORMACIÓN';
            const textAccion    = `LA INFORMACIÓN DE ${this.info.nombre} HA SIDO AGREGADA EXITOSAMENTE`;
            this.btnInfoLoad(true, true);
            
            const dataString = { info: this.info };
            this.$http.post(base_url + 'tipospago/accionInfo', dataString).then(function(res) {

                self.btnInfoLoad(false, false);                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
                    $('#modalInfo').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnInfoLoad(false, false); 
                console.log('Error accionInfo');
            })
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANSO...';
        },
        btnInfoLoad(load, dis){
            this.btnInfo.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> INGRESAR'
            this.btnInfo.disabled = dis;
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
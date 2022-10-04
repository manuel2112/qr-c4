
new Vue({
    el: '#app',
    data: {
        mensaje: '',
        btnMsn: {
            txt: '<i class="fas fa-sync-alt"></i> ENVIAR',
            disabled: true
        },
        asuntos: null,
        asunto: '',
        detalle: '',
    },
    created() {
        this.instanciar();
    },
    methods: {
        instanciar() {
            Swal.showLoading();
            const self = this;
            this.$http.post(base_url + 'contacto/instanciar').then(function(res) {
                
                self.asuntos = res.data.asuntos;
                Swal.close();

            }, function() {
                console.log('Error instanciar');
            });
        },
        resetForm(){
            this.asunto     = '';
            this.detalle    = '';            
            this.mensaje    = '';            
        },
        sendForm(){
            const self          = this;
            const titleAccion   = 'CONTACTO';
            const textAccion    = 'MENSAJE ENVIADO, PRONTO NOS CONTACTAREMOS CONTIGO, GRACIAS!!!';
            this.btnMsnLoad(true, true);
            Swal.showLoading();
            
            var dataString = { asunto: this.asunto.value , mensaje: this.mensaje };
            this.$http.post(base_url + 'contacto/send', dataString ).then(function(res) {
                
                self.btnMsnLoad(true, false);
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.btnMsnLoad(false, true);
                    self.resetForm();
                }else{
                    self.swalError(titleAccion);
                    self.btnMsnLoad(false, false);
                }

            }, function() {
                self.swalLog(titleAccion);
                self.btnMsnLoad(false, false);
                console.log('Error sendForm');
            });
        },
        cmbAsunto(){
            this.detalle = this.asunto ? this.asunto.detalle : '' ;
            this.validateForm();
        },
        validateForm(){
            if( this.asunto && this.mensaje ){
                this.btnMsnLoad(false, false);
            }else{
                this.btnMsnLoad(false, true);
            }
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANDO...';
        },
        btnMsnLoad(load, dis){
            this.btnMsn.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> ENVIAR'
            this.btnMsn.disabled = dis;
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
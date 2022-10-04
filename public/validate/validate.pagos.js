
new Vue({
    el: '#index',
    data: {
        textos: {},
        cantMeses: 0,
        optItems: 24,
        htmlPorPagar: '',
        valorPagar: 0,
        membresia: {},
        msnMembresia: '',
        btnMembresia: {
            txt: '<i class="far fa-credit-card"></i> PAGAR',
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

            this.$http.post(base_url + 'pagos/instanciar').then(function(res) {

                self.msnMembresia   = res.data.msnMembresia;
                self.textos         = res.data.textos;
                Swal.close();

            }, function() {
                console.log('Error instanciar');
            });
        },
        calcMembresia(e){
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'MEMBRESÍA';
            this.cantMeses      = e.target.value;

            if( this.cantMeses > 0 ){

                let dataString = { cantMeses: this.cantMeses, valor: this.membresia.MEMBRESIA_VALOR };
                this.$http.post(base_url + 'pagos/calcMembresia', dataString).then(function(res) {

                    if( res.data.ok ){

                        self.htmlPorPagar = res.data.msn;
                        self.btnMembresia.disabled = false;
                        self.btnMembresiaLoad(false, false);
                        Swal.close();

                    }else{
                        self.swalError(titleAccion);
                    }
                    
                }, function() {
                    self.swalLog(titleAccion);
                    console.log('Error calcMembresia');
                });

            }else{
                this.htmlPorPagar = '';
                this.btnMembresiaLoad(false, true);
                Swal.close();
            }
        },
        resetMdlMembresia(){
            this.htmlPorPagar = '';
            this.cantMeses = 0;
            this.btnMembresiaLoad(false,true);
        },
        seleccionarMembresia(e){
            Swal.showLoading();
            const self = this;

            const dataString = { idMembresia: e };
            this.$http.post(base_url + 'pagos/seleccionarMembresia', dataString).then(function(res) {
                
                self.membresia = res.data.membresia;
                Swal.close();

            }, function() {
                console.log('Error seleccionarMembresia');
            });
        },
        loadBtn(){
            this.btnMembresiaLoad(true, true);
            $( "#form-pagos" ).submit();
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANDO...';
        },
        btnMembresiaLoad(load, dis){
            this.btnMembresia.txt = load ? this.txtBtnLoad() : '<i class="far fa-credit-card"></i> PAGAR'
            this.btnMembresia.disabled = dis;
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

new Vue({
    el: '#app',
    data: {
        initLoading: true,
        resumen: {
        },
        error:{},
        emailIns: '',
        grupoIns: '',
        searchResp:null,
        emailEdit: '',
        boolFlag: false,
        nmbGrupo: '',
        paquete: 200,
        totalGrupos: 0,
        captionGrupo: '',
        state: '',
        estados: {},
        bool: {},
        textoSearch: '',
        textRadio: '',
        msnAutomated:'',
        actionAutomated:'',
        btnEmail: {
            txt: '<i class="fas fa-sync-alt"></i> INGRESAR EMAIL',
            disabled: true
        },
        btnGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> INGRESAR GRUPO',
            disabled: true
        },
        btnSearchEmail: {
            txt: '<i class="fas fa-sync-alt"></i> BUSCAR EMAIL',
            disabled: true
        },
        btnSearchGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> BUSCAR GRUPO',
            disabled: true
        },
        btnChangeState: {
            txt: '<i class="fas fa-sync-alt"></i> CAMBIAR ESTADO',
            disabled: true
        },
        btnTextSearch: {
            txt: '<i class="fas fa-sync-alt"></i> BUSCAR POR TEXTO',
            disabled: true
        },
        btnExport: {
            txt: '<i class="fa fa-download"></i> EXPORTAR',
            disabled: true
        },
    },
    created() {
        this.instanciar();
    },
    methods: {
        instanciar() {
            this.initLoading ? Swal.showLoading() : '';
            const self = this;
            
            this.$http.post(base_url + 'mailing/instanciar').then(function(res) {
                
                self.estados                = res.data.estados;
                self.resumen.total          = res.data.total;
                self.resumen.activo         = res.data.activo;
                self.resumen.listaNegra     = res.data.listaNegra;
                self.resumen.rebotado       = res.data.rebotado;
                self.resumen.inactivo       = res.data.inactivo;
                self.resumen.spam           = res.data.spam;
                self.resumen.baja           = res.data.baja;
                self.resumen.mailrelaey     = res.data.mailrelaey;
                self.resumen.nomailrelaey   = res.data.nomailrelaey;

                self.totalGrupos = Math.ceil(self.resumen.nomailrelaey / self.paquete);

                self.initLoading ? Swal.close() : '';
                self.initLoading = false;
                                
            }, function() {
                console.log('Error instanciar');
            });
        },
        resetVariables(){
            this.emailIns       = '';
            this.grupoIns       = '';
            this.searchResp     = null;
            this.state          = '';
            this.bool           = {};
            this.captionGrupo   = '';
            this.textoSearch    = '';
            this.searchResp     = '';
            this.emailEdit      = '';
            this.boolFlag       = false;
            $(".reset").removeClass("active");

            this.btnEmailLoad(false, true);
            this.btnGrupoLoad(false, true);
            this.btnSearchEmailLoad(false, true);
            this.btnChangeStateLoad(false, true);
            this.btnTextSearchLoad(false, true);
            this.btnExportLoad(false, true);
        },
        async insertEmail(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'INGRESO EMAIL';
            const dataString = { email: this.emailIns };
            await this.$http.post(base_url + 'mailing/insertEmail', dataString).then(function(res) {

                if( res.data.ok ){
                    if( res.data.existe ){
                        self.swalErrorText(titleAccion, 'EMAIL EXISTE, INGRESAR OTRO')
                    }else{
                        self.swalSuccess(titleAccion, 'EMAIL INGRESADO EXITOSAMENTE');
                        $('#modalInsertEmail').modal('hide');
                        self.resetVariables();
                        self.instanciar();
                    }
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error insertEmail');
            })
        },
        async insertGrupo(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'INGRESO GRUPO';
            const dataString = { grupo: this.grupoIns };
            await this.$http.post(base_url + 'mailing/insertGrupo', dataString).then(function(res) {

                if( res.data.ok ){
                    self.swalSuccess(titleAccion, res.data.msn);
                    $('#mdlInsertGrupo').modal('hide');
                    self.resetVariables();
                    self.instanciar();
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error insertEmail');
            })
        },
        async searchEmail(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'BUSCAR EMAIL';
            const dataString = { email: this.emailIns };
            await this.$http.post(base_url + 'mailing/searchEmail', dataString).then(function(res) {
                
                if( res.data.ok ){
                    if( res.data.existe ){
                        self.searchResp = res.data.resp;
                        self.emailEdit  = res.data.edit;
                        self.emailIns   = '';
                        self.btnSearchEmailLoad(false, true);
                        Swal.close();
                    }else{
                        self.swalErrorText(titleAccion, 'BUSQUEDA NO EXITOSA');
                        self.searchResp = '';
                    }
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error searchEmail');
            })
        },
        async searchGrupo(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'BUSCAR EMAIL';
            const dataString = { grupo: this.nmbGrupo, paquete: this.paquete };
            await this.$http.post(base_url + 'mailing/searchGrupo', dataString).then(function(res) {

                if( res.data.ok ){
                    if( res.data.existe ){
                        self.searchResp   = res.data.correos;
                        self.captionGrupo = res.data.caption;
                        self.nmbGrupo = '';                        
                        self.btnExportLoad(false, false);
                        self.btnSearchGrupoLoad(false, true);
                    }else{
                        self.swalErrorText(titleAccion, 'BUSQUEDA NO EXITOSA');
                        self.searchResp = '';
                    }
                }else{
                    self.swalError(titleAccion);
                }
                Swal.close()

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error searchEmail');
            })
        },
        async changeState(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'CAMBIAR ESTADO';
            const dataString = { grupo: this.grupoIns, state: this.state };
            await this.$http.post(base_url + 'mailing/changeState', dataString).then(function(res) {

                if( res.data.ok ){
                    self.swalSuccess(titleAccion, res.data.msn);
                    $('#mdlEstado').modal('hide');
                    self.resetVariables();
                    self.instanciar();
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error insertEmail');
            })
        },
        async getGrupoStatus(value){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'BUSCAR GRUPO';
            const dataString = { idEstado: value };
            await this.$http.post(base_url + 'mailing/getGrupoStatus', dataString).then(function(res) {

                if( res.data.ok ){
                    if( res.data.existe ){
                        self.searchResp   = res.data.correos;
                        self.captionGrupo = res.data.caption;
                    }else{
                        self.swalErrorText(titleAccion, 'BUSQUEDA NO EXITOSA');
                    }
                }else{
                    self.swalError(titleAccion);
                }
                Swal.close()

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error searchGrupoStatus');
            })
        },
        async searchTexto(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'BUSCAR TEXTO';
            const dataString = { texto: this.textoSearch, radio: this.textRadio };
            await this.$http.post(base_url + 'mailing/searchTexto', dataString).then(function(res) {

                if( res.data.ok ){
                    if( res.data.existe ){
                        self.searchResp = res.data.correos;
                        self.textoSearch = '';
                        $(".reset").removeClass("active")
                        self.btnTextSearchLoad(false, true);
                        self.btnExportLoad(false, false);
                    }else{
                        self.swalErrorText(titleAccion, 'BUSQUEDA NO EXITOSA');
                    }
                }else{
                    self.swalError(titleAccion);
                }
                Swal.close();

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error searchTexto');
            })
        },
        async exportFile(){
            Swal.showLoading();
            this.btnExportLoad(true, true);
            const self = this;
            const titleAccion   = 'EXPORTAR ARCHIVO';
            const dataString = { texto: this.searchResp };
            await this.$http.post(base_url + 'recibo/exportFile', dataString).then(function(res) {

                if( res.data.ok ){
                    self.btnExportLoad(false, true);
                    self.swalLoadingExport(res.data.ruta);
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error exportFile');
            })
        },
        async editEmailProcess(){
            Swal.showLoading();
            const self = this;
            const titleAccion   = 'EDITAR EMAIL';
            const textAccion    = 'EMAIL EDITADO EXITOSAMENTE';
            const dataString = { email: this.emailEdit };
            await this.$http.post(base_url + 'mailing/editEmail', dataString).then(function(res) {

                if( res.data.ok ){
                    $('#modalSearchEmail').modal('hide');
                    self.resetVariables();
                    self.swalSuccess(titleAccion, textAccion);
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error editEmailProcess');
            })
        },
        executeAutomated(){
            this.actionAutomated = setInterval(this.automatedProcess, 120000);
            console.log('INICIALIZADO...');
        },
        stopExecuteAutomated(){
            clearInterval(this.actionAutomated);
            console.log('FINALIZADO...')
        },
        async automatedProcess(){
            
            let timer = 0;
            Swal.fire({
                title: 'EN PROCESO...',
                html: '<b></b> SEGUNDOS PROCESADOS.',
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    setInterval(() => {
                        b.textContent = timer++;
                    }, 1000)
                }
            })

            const self = this;
            await this.$http.post(base_url + 'mailing/automated').then(function(res) {
                self.msnAutomated = res.data.msn;
                self.instanciar();
                console.log(res.data.fin,res.data.time);
                console.log('ERROR',res.data.error);
                !res.data.fin ? self.stopExecuteAutomated() : '';
                Swal.close();
            },
            function() {
                self.swalLog('Automated Process');
                console.log('Error automatedProcess');
            })
        },
        async deleteEmailProcess(){
            const self = this;
            const dataString = { email: this.emailEdit };
            Swal.fire({
                title: 'ELIMINAR EMAIL',
                text: '¿ESTÀS SEGURO DE ELIMINAR ESTE EMAIL?',
                showCancelButton: true,
                confirmButtonText: 'SI, ELIMINAR',
                confirmButtonColor: "#d9534f",
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
                    self.$http.post(base_url + 'mailing/deleteEmail', dataString).then(function(res) {
                        
                        if ( res.data.ok ) {
                            $('#modalSearchEmail').modal('hide');
                            self.resetVariables();
                            self.swalSuccess('ELIMINAR EMAIL', 'EMAIL ELIMINADO EXITOSAMENTE');
                        }else{
                            Swal.fire( titleAccion, "UN ERROR INESPERADO SE HA PRODUCIDO, FAVOR VOLVER A INTENTAR.", 'error');
                        }
                    },
                    function() {
                        Swal.fire( titleAccion, "* UN ERROR INESPERADO SE HA PRODUCIDO, FAVOR VOLVER A INTENTAR.", 'error'); 
                        console.log('Error deleteEmailProcess');
                    })
                }
            });
        },
        validarSearchTexto(){
            if( this.bool.textRadio &&
                this.bool.text){
                this.btnTextSearchLoad(false, false);
            }else{
                this.btnTextSearchLoad(false, true);
            }
        },
        validarSearchTextRadio(value){
            this.textRadio = value;
            if( this.textRadio ){
                this.bool.textRadio = true;
            }else{
                this.bool.textRadio = false;
            }
            this.validarSearchTexto();
        },
        validarTexto(){
            if( this.textoSearch.length > 2 ){
                this.bool.text = true;
            }else{
                this.bool.text = false;
            }
            this.validarSearchTexto();
        },
        validarState(){
            if( this.bool.state && 
                this.bool.grupo ){                    
                this.btnChangeStateLoad(false, false);
            }else{
                this.btnChangeStateLoad(false, true);
            }
        },
        getState(){
            if( this.state ){
                this.bool.state = true;
            }else{
                this.bool.state = false;
            }
            this.validarState();
        },
        validateGrupoState(){
            if( this.grupoIns ){
                this.bool.grupo = true;
            }else{
                this.bool.grupo = false;
            }
            this.validarState();
        },
        validarEmail(){
            this.emailIns = this.emailIns.toLowerCase();
            if( this.emailIns ){
                if( !validateEmail(this.emailIns) ){
                    this.error.emailIns = 'EMAIL NO VÁLIDO';
                    this.btnEmailLoad(false, true);
                    this.btnSearchEmailLoad(false, true);
                }else{
                    this.error.emailIns = '';
                    this.btnEmailLoad(false, false);
                    this.btnSearchEmailLoad(false, false);
                }
            }else{
                this.btnEmailLoad(false, true);
                this.btnSearchEmailLoad(false, true);
            }
        },
        validateGrupo(){
            if( this.grupoIns ){
                this.btnGrupoLoad(false, false);
            }else{
                this.btnGrupoLoad(false, true);
            }
        },
        validateGrupoSearch(){
            if( (this.nmbGrupo > 0) && (this.nmbGrupo <= this.totalGrupos) ){
                this.error.grupo = '';
                this.btnSearchGrupoLoad(false, false);
            }else if( this.nmbGrupo > this.totalGrupos ){
                this.error.grupo = `EL GRUPO DEBE SER MENOR A ${this.totalGrupos}`;
                this.btnSearchGrupoLoad(false, true);
            }else{
                this.error.grupo = 'EL GRUPO DEBE SER MAYOR A CERO';
                this.btnSearchGrupoLoad(false, true);
            }
        },
        editEmail(){
            this.boolFlag = true;
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANSO...';
        },
        btnEmailLoad(load, dis){
            this.btnEmail.txt       = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> INGRESAR EMAIL'
            this.btnEmail.disabled  = dis;
        },
        btnGrupoLoad(load, dis){
            this.btnGrupo.txt       = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> INGRESAR GRUPO'
            this.btnGrupo.disabled  = dis;
        },
        btnSearchEmailLoad(load, dis){
            this.btnSearchEmail.txt       = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> BUSCAR EMAIL'
            this.btnSearchEmail.disabled  = dis;
        },
        btnSearchGrupoLoad(load, dis){
            this.btnSearchGrupo.txt       = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> BUSCAR GRUPO'
            this.btnSearchGrupo.disabled  = dis;
        },
        btnChangeStateLoad(load, dis){
            this.btnChangeState.txt       = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> CAMBIAR ESTADO'
            this.btnChangeState.disabled  = dis;
        },
        btnTextSearchLoad(load, dis){
            this.btnTextSearch.txt       = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i>  BUSCAR POR TEXTO'
            this.btnTextSearch.disabled  = dis;
        },
        btnExportLoad(load, dis){
            this.btnExport.txt       = load ? this.txtBtnLoad() : '<i class="fa fa-download"></i> EXPORTAR'
            this.btnExport.disabled  = dis;
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
        swalLoadingExport(file){
            const self = this;
            Swal.fire({
                title: 'EXPORTAR ERCHIVO',
                text: 'DESEAS DESCARGAR EL ARCHIVO',
                showCancelButton: true,
                confirmButtonText: 'DESCARGAR',
                confirmButtonColor: '#0275d8',
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
                    window.open(file);
                    Swal.close();
                }
            });
        },
        swalSuccess(titleAccion, textAccion){
            Swal.fire({
                title: titleAccion,
                html: textAccion,
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
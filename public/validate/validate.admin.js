
new Vue({
    el: '#app',
    data: {
        empresas: {},
        empresaCmb: '',
        empresa: null,
        datos: null,
        membresias: null,
        vistas: null,
        menu: null,
        acciones: null,
        planes: null,
        meses: 12,
        grupos: null,
        maxImgs: null,
        mdl: {
            MEMBRESIA_ID: '',
            PAGO_CANTIDAD: '',
            EMPRESA_ID: '',
            PAGO_ID: null,
            FREE: true
        },
        grupoInsert: '',
        gruposEdit: {},
        imgTempSrc: '',
        widthResize: 360,
        grupoTemp: {},
        productoInsert: {
            nombre: '',
            detalle: '',
            descripcion: ''
        },
        vpInsert: [
            { 
                nombre: '', 
                valor: '' 
            }
        ],
        productoRadio: {},        
        cutBool: true,
        grupoEdit: {},
        productosGrupoEdit: {},
        loadInit: true,
        productoGet: {},
        productoGetVPS: {},
        productoGetImgs: {},
        productosEdit: {
            PRODUCTO_ID: '',
            PRODUCTO_NOMBRE: '',
            PRODUCTO_DET: '',
            PRODUCTO_DESC: ''
        },
        productoTitle: '',
        productoEditVPS: {},
        productoEditImgs: {},
        maxImgsVar: 0,
        btnBuscarEmpresa: {
            txt: '<i class="fas fa-sync-alt"></i> SELECCIONAR',
            disabled: true
        },
        btnPlan: {
            txt: '<i class="fas fa-sync-alt"></i> INGRESAR',
            disabled: true
        },
        btnEditOrderGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> REORDENAR GRUPOS',
            disabled: true
        },
        btnInsertGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> AGREGAR GRUPO',
            disabled: true
        },
        btnInsertProductoPaso01: {
            txt: 'PASO 2 <i class="fas fa-arrow-right"></i>',
            disabled: true
        },
        btnInsertProductoPaso02: {
            txt: 'PASO 3 <i class="fas fa-arrow-right"></i>',
            disabled: true
        },
        btnInsertProductoPaso03: {
            txt: 'PASO 4 <i class="fas fa-arrow-right"></i>',
            disabled: true
        },
        btnInsertProductoPaso02Back: {
            txt: '<i class="fas fa-arrow-left"></i> PASO 1',
            disabled: false
        },
        btnInsertProductoPaso03Back: {
            txt: '<i class="fas fa-arrow-left"></i> PASO 2',
            disabled: false
        },
        btnInsertProductoPaso04Back: {
            txt: '<i class="fas fa-arrow-left"></i> PASO 3',
            disabled: false
        },
        btnInsertProductoPaso04: {
            txt: '<i class="fas fa-sync-alt"></i> INGRESAR PRODUCTO',
            disabled: true
        },
        btnEditGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR GRUPO',
            disabled: true
        },
        btnEditOrderProductos: {
            txt: '<i class="fas fa-sync-alt"></i> REORDENAR PRODUCTOS',
            disabled: true
        },
        btnEditProducto: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR PRODUCTO',
            disabled: true
        },
        btnEditVP: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR VARIACIÓN DE PRECIO',
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
            Swal.showLoading();
            const self = this;
            this.$http.post(base_url + 'admin/instanciar').then(function(res) {
                
                self.empresas = res.data.empresas;
                Swal.close();
                                
            }, function() {
                console.log('Error instanciar');
            });
        },
        validateCmbEmpresa(){
            if( this.empresaCmb ){
                this.btnBuscarEmpresaLoad(false, false);
            }else{
                this.btnBuscarEmpresaLoad(false, true);
            }
        },
        resetCmbEmpresa(){
            this.empresaCmb = '';
            this.btnBuscarEmpresaLoad(false, true);
        },
        getEmpresa(){
            Swal.showLoading();
            this.btnBuscarEmpresaLoad(true, true);
            const self          = this;
            const titleAccion   = 'SELECCIONAR EMPRESA';

            const dataString = { idEmpresa: this.empresaCmb };
            this.$http.post(base_url + 'admin/getEmpresa', dataString).then(function(res) {

                Swal.close();
                if ( res.data.ok ) {
                    self.empresa = res.data.empresa;
                    self.resetCmbEmpresa();
                    self.resetInfo();
                } else {
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error getEmpresa');
            })
        },
        resetInfo(){
            this.datos          = null;
            this.membresias     = null;
            this.vistas         = null;
            this.menu           = null;
            this.acciones       = null;
            this.planes         = null;
            this.grupos         = null;   
            this.maxImgs        = null;
            this.resetPlan();
        },
        resetPlan(){
            this.mdl = {
                MEMBRESIA_ID: '',
                PAGO_CANTIDAD: '',
                EMPRESA_ID: '',
                PAGO_ID: null,
                FREE: true
            };
            this.validateGiftPlan();
        },
        getDatos(){
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'SELECCIONAR DATOS';
            this.resetInfo();

            const dataString = { idEmpresa: this.empresa.EMPRESA_ID };
            this.$http.post(base_url + 'admin/getDatos', dataString).then(function(res) {

                Swal.close();
                if ( res.data.ok ) {
                    self.datos              = self.empresa;
                    self.datos.SLUG_URL     = res.data.slug;
                    self.datos.QR_URL       = res.data.qr;
                } else {
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error getDatos');
            })
        },
        getPlan(){
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'MEMBRESÍA';
            this.resetInfo();

            const dataString = { idEmpresa: this.empresa.EMPRESA_ID };
            this.$http.post(base_url + 'admin/getPlan', dataString).then(function(res) {

                Swal.close();
                if ( res.data.ok ) {
                    self.membresias    = res.data.membresias;
                    self.vistas        = res.data.vistas;
                } else {
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error getPlan');
            })
        },
        getMenu(){
            this.loadInit ? Swal.showLoading() : '' ;
            const self = this;
            this.resetInfo();

            const dataString = { idEmpresa: this.empresa.EMPRESA_ID };
            this.$http.post(base_url + 'admin/getMenu',dataString).then(function(res) {

                self.grupos = res.data.grupos;
                self.maxImgs = res.data.plan.MEMBRESIA_IMG;

                self.loadInit ? Swal.close() : '' ;
                self.loadInit = false;

            }, function() {
                console.log('Error getMenu');
            });
        },
        getAcciones(){
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'ACCIONES';
            this.resetInfo();

            const dataString = { idEmpresa: this.empresa.EMPRESA_ID };
            this.$http.post(base_url + 'admin/getAcciones', dataString).then(function(res) {

                Swal.close();
                if ( res.data.ok ) {
                    self.acciones  = res.data.acciones;
                } else {
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error getAcciones');
            })
        },
        getPlanes(){
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'ACCIONES';
            this.resetInfo();
            
            this.$http.post(base_url + 'admin/getPlanes').then(function(res) {
                
                if ( res.data.ok ) {
                    self.planes  = res.data.planes;
                } else {
                    self.swalError(titleAccion);
                }
                Swal.close();

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error getPlanes');
            })
        },
        validateGiftPlan(){
            if( this.mdl.MEMBRESIA_ID && this.mdl.PAGO_CANTIDAD ){
                this.mdl.EMPRESA_ID = this.empresa.EMPRESA_ID;
                this.btnPlanLoad(false,false);
            }else{
                this.btnPlanLoad(false,true);                
            }
        },
        insertGift(){
            const self = this;
            Swal.fire({
                title: 'INGRESAR PERMISO',
                input: 'text',
                inputAttributes: {
                  autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'INGRESAR',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                preConfirm: (password) => {

                    const dataString = { mdl: this.mdl, password: password };
                    return this.$http.post(base_url + 'admin/insertGift', dataString).then(res => {

                        if( res.data.ok ){
                            self.swalSuccess('MEMBRESÍA', 'MEMBRESÍA OTORGADA CON ÉXITO');
                        }else{
                            Swal.showValidationMessage(
                                'PASSWORD NO VÁLIDO'
                            )                            
                        }

                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `SE HA PRODUCIDO UN ERROR: ${error}`
                        )
                    })
                }
            });
        },
        resetMdlGrupoOrder(){ 
            this.btnEditOrderGrupoLoad(false, true);          
        },
        validateGrupoOrder(){
            this.btnEditOrderGrupoLoad(false, false);
        },
        instanciarGrupoOrder(){
            Swal.showLoading();
            this.gruposEdit = this.grupos;
            Swal.close();
        },
        insertGrupoOrder() {
            Swal.showLoading();
            const self          = this;
            const titleAccion   = 'GRUPOS';
            const textAccion    = 'LOS GRUPOS HAN SIDO REORDENADO EXITOSAMENTE';
            this.btnEditOrderGrupoLoad(true, true);

            const dataString    = { grupos: this.gruposEdit, idEmpresa: this.empresa.EMPRESA_ID };
            this.$http.post(base_url + 'admin/orderGrupo', dataString).then(function(res) {
                if ( res.data.ok ) {
                    self.swalSuccess(titleAccion, textAccion)
                    self.getMenu();
                    $('#mdlOrderGrupos').modal('hide');
                    self.btnEditOrderGrupoLoad(false, true);
                } else {
                    self.swalError(titleAccion);
                    self.btnEditOrderGrupoLoad(false, false);
                }
            },
            function() {
                self.swalLog(titleAccion);
                self.btnEditOrderGrupoLoad(false, false);
                console.log('Error insertGrupoOrder');
            })
        },
        jQueryIntance(){
            $(".img-grupo").filestyle({
                btnClass: "btn-danger",
                text: "<i class='fas fa-folder-open'></i> Buscar imagen para grupo",
                placeholder: "Opcional"
            });
            $(".img-producto").filestyle({
                btnClass: "btn-danger",
                text: "<i class='fas fa-folder-open'></i> Buscar imagen para producto",
                placeholder: "Opcional"
            });
        },
        validarGrupoInsert(){
            this.grupoInsert = HtmlSanitizer.SanitizeHtml(this.grupoInsert);
            this.grupoInsert ? this.btnInsertGrupoLoad(false, false) : this.btnInsertGrupoLoad(false, true) ;           
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
            event = null;
            this.openBtn();
        },
        resetMdlInsertGrupo(){
            Swal.showLoading();
            this.grupoInsert = '';
            this.deleteImgTemp();
            this.btnInsertGrupoLoad(false, true);
            Swal.close();
        },
        deleteImgTemp(){
            this.imgTemp    = '';
            this.imgTempSrc = '';
            this.coords     = null;
            this.cutBool    = true;
        },
        insertGrupo(){
            const self          = this;
            const titleAccion   = 'GRUPOS';
            const textAccion    = 'EL GRUPO HA SIDO INGRESADO EXITOSAMENTE';
            this.btnInsertGrupoLoad(true, true);
            Swal.showLoading();

            const formData = new FormData();
            formData.append('idEmpresa', this.empresa.EMPRESA_ID );
            formData.append('grupo', this.grupoInsert );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );
            
            this.$http.post(base_url + 'admin/insertGrupo', formData).then(function(res) {

                self.btnInsertGrupoLoad(false, false);
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.getMenu();
                    self.deleteImgTemp();
                    $('#mdlInsertGrupo').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }
            },
            function() {
                self.swalLog(titleAccion);
                self.btnInsertGrupoLoad(false, false);
                console.log('Error insertGrupo');
            })
        },
        openBtn(){
            $('#galeria-productos,#insert-grupo,#edit-grupo,#insert-producto').val('');
            this.grupoEdit ? this.btnEditGrupoLoad(false, false) : '';
        },
        cutImgTemp(e,element,bool){
            this.cutBool ? this.instJcrop(element,bool) : this.destroyJcrop() ;
            this.cutBool = !this.cutBool;
        },
        instJcrop(element,bool){
            const self  = this;
            const ratio = bool ? 1 / 1 : 9 / 5 ;
            this.jcrop = $.Jcrop(element, {
                onChange: showCoords,
                onSelect: showCoords,
                bgColor: 'black',
                bgOpacity: .3,
                setSelect: [ 0, 0, 100, 100 ],
                aspectRatio: ratio
            });
            function showCoords(c)
            {
                self.coords = c;
            };
        },
        resetMdlInsertProducto(){
            this.productoInsert = { nombre: null, detalle: null, descripcion: null };
            this.vpInsert = [ { nombre: '', valor: '' } ];
            $(".reset").removeClass("active")
            this.productoRadio = {};
            this.deleteImgTemp();           
            this.btnInsertProductoPaso01Load(true);
            this.btnInsertProductoPaso02Load(true);
            this.btnInsertProductoPaso03Load(true);
        },
        validarInsertProductoPaso01(){
            this.productoInsert.nombre = HtmlSanitizer.SanitizeHtml(this.productoInsert.nombre);
            if( this.productoInsert.nombre.length ){
                this.btnInsertProductoPaso01Load(false);
            }else{
                this.btnInsertProductoPaso01Load(true);
            }
        },
        validarInsertProductoPaso01Detalle(){
            this.productoInsert.detalle = HtmlSanitizer.SanitizeHtml(this.productoInsert.detalle);
        },
        validarInsertProductoPaso01Descripcion(){
            this.productoInsert.descripcion = HtmlSanitizer.SanitizeHtml(this.productoInsert.descripcion);
        },
        goStep02(){
            Swal.showLoading();
            $('#mdlProductoPaso01').modal('hide');
            $('#mdlProductoPaso02').modal('show');
            $('#mdlProductoPaso03').modal('hide');
            Swal.close();
        },
        instanciarInsertProducto(value){
            Swal.showLoading();
            this.grupoTemp = value;
            Swal.close();
        },
        addVV() {
            this.vpInsert.push({ nombre: '', valor: '' });
        },
        validarInsertProductoPaso02(){
            if( this.vpInsert[0].valor ){
                this.btnInsertProductoPaso02Load(false);
            }else{
                this.btnInsertProductoPaso02Load(true);
            }
        },
        goStep01(){
            Swal.showLoading();
            $('#mdlProductoPaso02').modal('hide');
            $('#mdlProductoPaso01').modal('show');
            Swal.close();
        },
        goStep03(){
            Swal.showLoading();
            this.btnInsertProductoPaso03Load(false);
            $('#mdlProductoPaso02').modal('hide');
            $('#mdlProductoPaso03').modal('show');
            $('#mdlProductoPaso04').modal('hide');
            Swal.close();
        },
        goStep04(){
            Swal.showLoading();
            $('#mdlProductoPaso03').modal('hide');
            $('#mdlProductoPaso04').modal('show');
            Swal.close();
        },
        insertProducto(){
            const self          = this;
            const titleAccion   = 'PRODUCTO';
            const textAccion    = 'EL PRODUCTO HA SIDO INGRESADO EXITOSAMENTE';
            this.btnInsertProductoPaso04Load(true, true);
            Swal.showLoading();

            const formData = new FormData();
            formData.append('idEmpresa', this.empresa.EMPRESA_ID );
            formData.append('idGrupo', this.grupoTemp.GRUPO_ID );
            formData.append('producto', JSON.stringify(this.productoInsert) );
            formData.append('vp', JSON.stringify(this.vpInsert) );
            formData.append('opt', JSON.stringify(this.productoRadio) );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );

            this.$http.post(base_url + 'admin/insertProducto', formData).then(function(res) {
                                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.getMenu();
                    self.resetMdlInsertProducto();
                    self.deleteImgTemp();
                    $('#mdlProductoPaso04').modal('hide');
                    self.btnInsertProductoPaso04Load(false, true);
                }else{
                    self.swalError(titleAccion);
                    self.btnInsertProductoPaso04Load(false, false);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error insertProductoPaso');
                self.btnInsertProductoPaso04Load(false, false);
            })

        },
        validarInsertProductoPaso02Nombre(value){
            this.vpInsert[value].nombre = HtmlSanitizer.SanitizeHtml(this.vpInsert[value].nombre);
        },
        validarInsertProductoPaso04Linked(value){
            this.productoRadio.linked = value;
            this.validarInsertProductoPaso04();
        },
        validarInsertProductoPaso04(){
            if( (this.productoRadio.linked !== undefined) && (this.productoRadio.show !== undefined) ){
                this.btnInsertProductoPaso04Load(false, false);
            }else{
                this.btnInsertProductoPaso04Load(false, true);
            }
        },
        validarInsertProductoPaso04Show(value){
            this.productoRadio.show = value;
            this.validarInsertProductoPaso04();
        },
        validarGrupoEdit(){
            this.grupoEdit.GRUPO_NOMBRE_EDIT = HtmlSanitizer.SanitizeHtml(this.grupoEdit.GRUPO_NOMBRE_EDIT);
            if ( this.grupoEdit.GRUPO_NOMBRE_EDIT ) {
                this.btnEditGrupo.disabled = false;
            }else{
                this.btnEditGrupo.disabled = true;
            }            
        },
        instanciarEditGrupo( e ){
            Swal.showLoading();
            this.grupoEdit  = e;
            this.grupoEdit.GRUPO_NOMBRE_EDIT = e.GRUPO_NOMBRE;
            this.grupoEdit.GRUPO_IMG_EDIT = e.GRUPO_IMG ? e.GRUPO_IMG : '' ;
            this.grupoEdit.GRUPO_IMG = e.GRUPO_IMG;
            this.deleteImgTemp();
            this.btnEditGrupoLoad(false, true);
            Swal.close();
        },
        deleteImgGrupo(){
            this.deleteImgTemp();
            this.grupoEdit.GRUPO_IMG_EDIT =  '' ;
            this.btnEditGrupoLoad(false, false);
        },
        resetMdlEditGrupo(){
            // $('#form-edit-grupo')[0].reset();
        },
        editGrupo(){
            const self          = this;
            const titleAccion   = 'GRUPOS';
            const textAccion    = 'EL GRUPO HA SIDO EDITADO EXITOSAMENTE';
            this.btnEditGrupoLoad(true, true);
            Swal.showLoading();

            const formData = new FormData();
            formData.append('idEmpresa', this.empresa.EMPRESA_ID );
            formData.append('grupo', JSON.stringify(this.grupoEdit) );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );
            
            this.$http.post(base_url + 'admin/editGrupo', formData).then(function(res) {
                
                self.btnEditGrupoLoad(false, false);                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.getMenu();
                    self.deleteImgTemp();
                    $('#mdlEditGrupo').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnEditGrupoLoad(false, false);
                console.log('Error editGrupo');
            })
        },
        asignarProductos( g,p ){
            Swal.showLoading();
            this.productosEdit = p;
            this.productosGrupoEdit = g;
            this.btnEditOrderProductosLoad(false, true);
            Swal.close();
        },
        validateProductoOrder(){
            this.btnEditOrderProductosLoad(false, false);
        },
        insertProductosOrder() {
            const self          = this;
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = 'LOS PRODUCTOS HAN SIDO REORDENADO EXITOSAMENTE';
            this.btnEditOrderProductosLoad(true, true);
            Swal.showLoading();

            const dataString = { idEmpresa: this.empresa.EMPRESA_ID, productos: this.productosEdit };
            this.$http.post(base_url + 'admin/orderProductos', dataString).then(function(res) {

                self.btnEditOrderProductosLoad(false, false);
                if ( res.data.ok ) {
                    self.getMenu();
                    self.resetProductosEdit();
                    $('#mdlOrderProductos').modal('hide');
                    self.swalSuccess(titleAccion, textAccion);
                } else {
                    self.swalError(titleAccion);
                }
            },
            function() {
                self.swalLog(titleAccion);
                self.btnEditOrderProductosLoad(false, false);
                console.log('Error insertProductosOrder');
            })
        },
        resetProductosEdit(){
            this.productosEdit = {
                                    PRODUCTO_ID: '',
                                    PRODUCTO_NOMBRE: '',
                                    PRODUCTO_DET: '',
                                    PRODUCTO_DESC: ''
                                }
        },
        hideGrupo(value) {
            const title         = "ESTÁS SEGURO?";
            const txtText       = value.GRUPO_SHOW == 1 ? `ESTA ACCIÓN OCULTARÁ EL GRUPO ${value.GRUPO_NOMBRE}.` : `ESTA ACCIÓN MOSTRARÁ EL GRUPO ${value.GRUPO_NOMBRE}.`;
            const buttonText    = value.GRUPO_SHOW == 1 ? "SI, OCULTAR GRUPO!" : "SI, ACTIVAR GRUPO!";
            const buttonColor   = value.GRUPO_SHOW == 1 ? "#d9534f" : "#5cb85c";
            const apiRest       = base_url + 'admin/grupoHidden';
            const dataString    = { idEmpresa: this.empresa.EMPRESA_ID, idGrupo: value.GRUPO_ID, value: value.GRUPO_SHOW };
            const titleAccion   = 'GRUPOS';
            const textAccion    = value.GRUPO_SHOW == 0 ? "EL GRUPO HA SIDO ACTIVADO" :  "EL GRUPO HA SIDO DESACTIVADO";
            const errorAccion   = 'Error hideGrupo';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        deleteGrupo(value) {
            const title         = 'ESTÁS SEGURO?';
            const txtText       = `ESTA ACCIÓN ELIMINARÁ EL GRUPO ${value.GRUPO_NOMBRE}, PRODUCTOS Y LOS VALORES ASOCIADOS`;
            const buttonText    = 'SI, ELIMINAR GRUPO';
            const buttonColor   = '#d9534f';
            const apiRest       = base_url + 'admin/grupoDelete';
            const dataString    = { idEmpresa: this.empresa.EMPRESA_ID, idGrupo: value.GRUPO_ID };
            const titleAccion   = 'GRUPOS';
            const textAccion    = 'EL GRUPO HA SIDO ELIMINADO EXITOSAMENTE';
            const errorAccion   = 'Error deleteGrupo';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        detalleProducto(p){
            const self          = this;
            this.productoGet    = p;
            Swal.showLoading();

            let dataString = { idProducto: p.PRODUCTO_ID, limit: this.maxImgs };
            this.$http.post( base_url + 'admin/getProducto', dataString ).then(function(res) {

                self.productoGetVPS     = res.data.vps;
                self.productoGetImgs    = res.data.imagenes;
                Swal.close();
                
            }, function() {
                console.log('Error detalleProducto');
            });
        },
        validarEditProducto(){
            this.productosEdit.PRODUCTO_NOMBRE = HtmlSanitizer.SanitizeHtml(this.productosEdit.PRODUCTO_NOMBRE);
            this.productosEdit.PRODUCTO_DET = HtmlSanitizer.SanitizeHtml(this.productosEdit.PRODUCTO_DET);
            this.productosEdit.PRODUCTO_DESC = HtmlSanitizer.SanitizeHtml(this.productosEdit.PRODUCTO_DESC);
            if( this.productosEdit.PRODUCTO_NOMBRE.length > 2 ){
                this.btnEditProductoLoad(false, false);
            }else{
                this.btnEditProductoLoad(false, true);
            }
        },
        instanciarEditProducto(p){
            Swal.showLoading();
            this.productosEdit.PRODUCTO_ID = p.PRODUCTO_ID;
            this.productosEdit.PRODUCTO_NOMBRE = p.PRODUCTO_NOMBRE;
            this.productosEdit.PRODUCTO_DET = p.PRODUCTO_DET === null ? '' : p.PRODUCTO_DET ;
            this.productosEdit.PRODUCTO_DESC = p.PRODUCTO_DESC === null ? '' : p.PRODUCTO_DESC ;
            this.productoTitle = p.PRODUCTO_NOMBRE;
            this.btnEditProductoLoad(false, true);
            Swal.close();
        },
        editProducto(){
            const self          = this;
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = 'EL PRODUCTO HA SIDO EDITADO EXITOSAMENTE';
            this.btnEditProductoLoad(true, true);
            Swal.showLoading();

            const formData = new FormData();
            formData.append('idEmpresa', this.empresa.EMPRESA_ID );
            formData.append('producto', JSON.stringify(this.productosEdit) );

            this.$http.post(base_url + 'admin/editProducto', formData).then(function(res) {
                
                self.btnEditProductoLoad(false, false);
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.getMenu();
                    self.resetEditProducto();
                    $('#mdlEditProducto').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnEditProductoLoad(false, false);
                console.log('Error editProducto');
            })

        },
        resetEditProducto(){
            this.productosEdit = { PRODUCTO_NOMBRE: '', PRODUCTO_DET: '', PRODUCTO_DESC: '' };
        },
        instanciarEditVP( p ){
            Swal.showLoading();
            const self              = this;
            this.productoGet        = p;
            this.productoEditVPS    = {};
            let array               = [];

            let dataString = { idProducto: p.PRODUCTO_ID, limit: this.maxImgs };
            this.$http.post( base_url + 'admin/getProducto', dataString ).then(function(res) {

                res.data.vps.forEach(element => {
                    array.push({ nombre: element.PROVAR_NOMBRE, valor: element.PROVAR_VALOR })
                });
                self.productoEditVPS = array;
                Swal.close();
                
            }, function() {
                console.log('Error instanciarEditVP');
            });
        },
        editVV() {
            this.productoEditVPS.push({ nombre: '', valor: '' });
        },
        validarEditVP(){
            this.productoEditVPS[0].valor ? this.btnEditVPLoad(false, false) : this.btnEditVPLoad(false, true) ;
        },
        validarEditVPNombre(value){
            this.productoEditVPS[value].nombre = HtmlSanitizer.SanitizeHtml(this.productoEditVPS[value].nombre);
        },
        editVP(){
            const self          = this;
            const titleAccion   = 'VARIACIÓN DE PRECIO';
            const textAccion    = 'LA VARIACIÓN DE PRECIO DEL PRODUCTO HA SIDO EDITADO EXITOSAMENTE';
            this.btnEditVPLoad(true, true);
            Swal.showLoading();

            const dataString = { idEmpresa: this.empresa.EMPRESA_ID, 
                                 idProducto: this.productoGet.PRODUCTO_ID, 
                                 vps: JSON.stringify(this.productoEditVPS) 
                               };
            this.$http.post(base_url + 'admin/editVP', dataString).then(function(res) {                
                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.getMenu();
                    $('#mdlEditVP').modal('hide');
                    self.btnEditVPLoad(false, true);
                }else{
                    self.swalError(titleAccion);
                    self.btnEditVPLoad(false, false);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnEditVPLoad(false, false);
                console.log('Error editVP')
            })

        },
        instanciarEditGaleria(p,load){
            load ? Swal.showLoading() : '';
            const self                      = this;
            this.productoGet                = p;
            this.productoEditImgs           = {};
            this.deleteImgTemp();

            let dataString = { idProducto: p.PRODUCTO_ID, limit: this.maxImgs };
            this.$http.post( base_url + 'admin/getProducto', dataString ).then(function(res) {

                self.productoEditImgs   = res.data.imagenes;
                self.maxImgsVar         = self.maxImgs - self.productoEditImgs.length;
                load ? Swal.close() : '';
                
            }, function() {
                console.log('Error instanciarEditGaleria');
            });
        },
        deleteImgProducto( img ){
            const title         = 'ESTÁS SEGURO?';
            const txtText       = 'SE ELIMINARÁ ESTA IMAGEN DE LA GALERÍA';
            const buttonText    = 'SI, ELIMINAR IMAGEN';
            const buttonColor   = "#d9534f";
            const apiRest       = base_url + 'admin/imagenDelete';
            const dataString    = { idEmpresa: this.empresa.EMPRESA_ID, img: img };
            const titleAccion   = 'GALERÍA DE IMÁGENES';
            const textAccion    = 'LA IMAGEN HA SIDO ELIMINADO EXITOSAMENTE';
            const errorAccion   = 'Error deleteImgProducto';
            const instanciar    = false;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        editGaleriaProductos(){
            const self          = this;
            const titleAccion   = 'GALERÍA DE IMÁGENES';
            const textAccion    = 'LA IMAGEN HA SIDO INGRESADA EXITOSAMENTE';
            Swal.showLoading();

            const formData = new FormData();
            formData.append('idEmpresa', this.empresa.EMPRESA_ID );
            formData.append('idProducto', this.productoGet.PRODUCTO_ID );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );

            this.$http.post(base_url + 'admin/editGaleriaProductos', formData).then(function(res) {
                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.deleteImgTemp();
                    self.instanciarEditGaleria( self.productoGet, false );
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                console.log('Error editGaleriaProductos');
            })
        },
        hideProductoLinked(value) {
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = value.PRODUCTO_LINKED == 1 ? `ESTA ACCIÓN OCULTARÁ EL DETALLE DEL PRODUCTO ${value.PRODUCTO_NOMBRE}` : `ESTA ACCIÓN MOSTRARÁ EL DETALLE DEL PRODUCTO ${value.PRODUCTO_NOMBRE}`;
            const buttonText    = value.PRODUCTO_LINKED == 1 ? "SI, OCULTAR DETALLE DEL PRODUCTO!" : "SI, ACTIVAR DETALLE DEL PRODUCTO!";
            const buttonColor   = value.PRODUCTO_LINKED == 1 ? "#d9534f" : "#5cb85c";
            const apiRest       = base_url + 'admin/productoLinkedHidden';
            const dataString    = { idEmpresa: this.empresa.EMPRESA_ID, idProducto: value.PRODUCTO_ID, value: value.PRODUCTO_LINKED };
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = value.PRODUCTO_LINKED == 0 ? "SE MOSTRARÁ DETALLE DEL PRODUCTO" :  "NO SE MOSTRARÁ DETALLE DEL PRODUCTO";
            const errorAccion   = 'Error hideProductoLinked';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        hideProducto(value) {
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = value.PRODUCTO_SHOW == 1 ? `ESTA ACCIÓN OCULTARÁ EL PRODUCTO ${value.PRODUCTO_NOMBRE}` : `ESTA ACCIÓN MOSTRARÁ EL PRODUCTO ${value.PRODUCTO_NOMBRE}`;
            const buttonText    = value.PRODUCTO_SHOW == 1 ? "SI, OCULTAR PRODUCTO!" : "SI, ACTIVAR PRODUCTO!";
            const buttonColor   = value.PRODUCTO_SHOW == 1 ? "#d9534f" : "#5cb85c";
            const apiRest       = base_url + 'admin/productoHidden';
            const dataString    = { idEmpresa: this.empresa.EMPRESA_ID, idProducto: value.PRODUCTO_ID, value: value.PRODUCTO_SHOW };
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = value.PRODUCTO_SHOW == 0 ? "EL PRODUCTO ESTÁ ACTIVO" :  "EL PRODUCTO YA NO ESTÁ ACTIVO";
            const errorAccion   = 'Error hideProducto';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        deleteProducto(value) {
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = `ESTA ACCIÓN ELIMINARÁ EL PRODUCTO ${value.PRODUCTO_NOMBRE}, Y LOS VALORES ASOCIADOS`;
            const buttonText    = 'SI, ELIMINAR PRODUCTO';
            const buttonColor   = "#d9534f";
            const apiRest       = base_url + 'admin/productoDelete';
            const dataString    = { idEmpresa: this.empresa.EMPRESA_ID, idProducto: value.PRODUCTO_ID };
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = 'EL PRODUCTO HA SIDO ELIMINADO EXITOSAMENTE';
            const errorAccion   = 'Error deleteProducto';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANSO...';
        },
        btnBuscarEmpresaLoad(load, dis){
            this.btnBuscarEmpresa.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> SELECCIONAR'
            this.btnBuscarEmpresa.disabled = dis;
        },
        btnPlanLoad(load, dis){
            this.btnPlan.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> INGRESAR'
            this.btnPlan.disabled = dis;
        },
        btnEditOrderGrupoLoad(load, dis){
            this.btnEditOrderGrupo.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> REORDENAR GRUPOS'
            this.btnEditOrderGrupo.disabled = dis;
        },
        btnInsertGrupoLoad(load, dis){
            this.btnInsertGrupo.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> AGREGAR GRUPO'
            this.btnInsertGrupo.disabled = dis;
        },
        btnInsertProductoPaso01Load(dis){
            this.btnInsertProductoPaso01.disabled = dis;
        },
        btnInsertProductoPaso02Load(dis){
            this.btnInsertProductoPaso02.disabled = dis;
        },
        btnInsertProductoPaso03Load(dis){
            this.btnInsertProductoPaso03.disabled = dis;
        },
        btnInsertProductoPaso04Load(load, dis){
            this.btnInsertProductoPaso04.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> INGRESAR PRODUCTO';
            this.btnInsertProductoPaso04.disabled = dis;
        },
        btnEditGrupoLoad(load, dis){
            this.btnEditGrupo.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> EDITAR GRUPO';
            this.btnEditGrupo.disabled = dis;
        },
        btnEditOrderProductosLoad(load, dis){
            this.btnEditOrderProductos.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> REORDENAR PRODUCTOS';
            this.btnEditOrderProductos.disabled = dis;
        },
        btnEditProductoLoad(load, dis){
            this.btnEditProducto.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> EDITAR PRODUCTO';
            this.btnEditProducto.disabled = dis;
        },
        btnEditVPLoad(load, dis){
            this.btnEditVP.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> EDITAR VARIACIÓN DE PRECIO';
            this.btnEditVP.disabled = dis;
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
                            instanciar ? self.getMenu() : self.instanciarEditGaleria( self.productoGet );
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
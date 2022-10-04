
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
        grupos: {},
        grupoInsert: '',
        grupoEdit: {},
        gruposEdit: {},
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
        grupoTemp: {},
        maxImgs: 0,
        maxImgsVar: 0,
        productoRadio: {},
        productoGet: {},
        productoGetVPS: {},
        productoEditVPS: {},
        productoGetImgs: {},
        productoEditImgs: {},
        productosEdit: {
            PRODUCTO_ID: '',
            PRODUCTO_NOMBRE: '',
            PRODUCTO_DET: '',
            PRODUCTO_DESC: ''
        },
        productoTitle: '',
        productosGrupoEdit: {},
        imgProps:{},
        btnInsertGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> AGREGAR GRUPO',
            disabled: true
        },
        btnEditGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> EDITAR GRUPO',
            disabled: true
        },
        btnEditOrderGrupo: {
            txt: '<i class="fas fa-sync-alt"></i> REORDENAR GRUPOS',
            disabled: true
        },
        btnInsertProductoPaso01: {
            txt: 'PASO 2 <i class="fas fa-arrow-right"></i>',
            disabled: true
        },
        btnInsertProductoPaso02Back: {
            txt: '<i class="fas fa-arrow-left"></i> PASO 1',
            disabled: false
        },
        btnInsertProductoPaso02: {
            txt: 'PASO 3 <i class="fas fa-arrow-right"></i>',
            disabled: true
        },
        btnInsertProductoPaso03Back: {
            txt: '<i class="fas fa-arrow-left"></i> PASO 2',
            disabled: false
        },
        btnInsertProductoPaso03: {
            txt: 'PASO 4 <i class="fas fa-arrow-right"></i>',
            disabled: true
        },
        btnInsertProductoPaso04Back: {
            txt: '<i class="fas fa-arrow-left"></i> PASO 3',
            disabled: false
        },
        btnInsertProductoPaso04: {
            txt: '<i class="fas fa-sync-alt"></i> INGRESAR PRODUCTO',
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
    mounted(){},
    methods: {
        instanciar() {
            this.loadInit ? Swal.showLoading() : '' ;
            const self = this;

            this.$http.get(base_url + 'menu/instanciar').then(function(res) {

                self.grupos = res.data.grupos;

                //INSTANCIAR NÚMERO DE IMÁGENES
                // self.maxImgs = 20;
                self.maxImgs = res.data.plan.MEMBRESIA_IMG;

                self.loadInit ? Swal.close() : '' ;
                self.loadInit = false;

            }, function() {
                console.log('Error instanciar');
            });

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
            event = null;
            this.openBtn();
        },
        validarGrupoInsert(){
            this.grupoInsert = HtmlSanitizer.SanitizeHtml(this.grupoInsert);
            this.grupoInsert ? this.btnInsertGrupoLoad(false, false) : this.btnInsertGrupoLoad(false, true) ;           
        },
        deleteImgTemp(){
            this.imgTemp    = '';
            this.imgTempSrc = '';
            this.coords     = null;
            this.cutBool    = true;
        },
        deleteImgGrupo(){
            this.deleteImgTemp();
            this.grupoEdit.GRUPO_IMG_EDIT =  '' ;
            this.btnEditGrupoLoad(false, false);
        },
        insertGrupo(){
            const self          = this;
            const titleAccion   = 'GRUPOS';
            const textAccion    = 'EL GRUPO HA SIDO INGRESADO EXITOSAMENTE';
            this.btnInsertGrupoLoad(true, true);
            Swal.showLoading();

            const formData = new FormData();
            formData.append('grupo', this.grupoInsert );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );
            
            this.$http.post(base_url + 'menu/insertGrupo', formData).then(function(res) {

                self.btnInsertGrupoLoad(false, false);
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
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
        resetMdlInsertGrupo(){
            Swal.showLoading();
            this.grupoInsert = '';
            this.deleteImgTemp();
            this.btnInsertGrupoLoad(false, true);
            Swal.close();
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
        validarGrupoEdit(){
            this.grupoEdit.GRUPO_NOMBRE_EDIT = HtmlSanitizer.SanitizeHtml(this.grupoEdit.GRUPO_NOMBRE_EDIT);
            if ( this.grupoEdit.GRUPO_NOMBRE ) {
                this.btnEditGrupo.disabled = false;
            }else{
                this.btnEditGrupo.disabled = true;
            }            
        },
        openBtn(){
            $('#galeria-productos,#insert-grupo,#edit-grupo,#insert-producto').val('');
            this.grupoEdit ? this.btnEditGrupoLoad(false, false) : '';
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
            formData.append('grupo', JSON.stringify(this.grupoEdit) );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );
            
            this.$http.post(base_url + 'menu/editGrupo', formData).then(function(res) {
                
                self.btnEditGrupoLoad(false, false);                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
                    self.deleteImgTemp();
                    $('#mdlEditGrupo').modal('hide');
                }else{
                    self.swalError(titleAccion);
                }

            },
            function() {
                self.swalLog(titleAccion);
                self.btnEditGrupoLoad(false, false);
                console.log('Error insertGrupo');
            })
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

            this.$http.post(base_url + 'menu/orderGrupo', { grupos: this.gruposEdit }).then(function(res) {
                if ( res.data.ok ) {
                    self.swalSuccess(titleAccion, textAccion)
                    self.instanciar();
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
        validateGrupoOrder(){
            this.btnEditOrderGrupoLoad(false, false);
        },
        resetMdlGrupoOrder(){ 
            this.btnEditOrderGrupoLoad(false, true);          
        },
        hideGrupo(value) {
            const title         = "ESTÁS SEGURO?";
            const txtText       = value.GRUPO_SHOW == 1 ? `ESTA ACCIÓN OCULTARÁ EL GRUPO ${value.GRUPO_NOMBRE}.` : `ESTA ACCIÓN MOSTRARÁ EL GRUPO ${value.GRUPO_NOMBRE}.`;
            const buttonText    = value.GRUPO_SHOW == 1 ? "SI, OCULTAR GRUPO!" : "SI, ACTIVAR GRUPO!";
            const buttonColor   = value.GRUPO_SHOW == 1 ? "#d9534f" : "#5cb85c";
            const apiRest       = base_url + 'menu/grupoHidden';
            const dataString    = { idGrupo: value.GRUPO_ID, value: value.GRUPO_SHOW };
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
            const apiRest       = base_url + 'menu/grupoDelete';
            const dataString    = { idGrupo: value.GRUPO_ID };
            const titleAccion   = 'GRUPOS';
            const textAccion    = 'EL GRUPO HA SIDO ELIMINADO EXITOSAMENTE';
            const errorAccion   = 'Error deleteGrupo';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        instanciarInsertProducto(value){
            Swal.showLoading();
            this.grupoTemp = value;
            Swal.close();
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
        validarInsertProductoPaso02(){
            if( this.vpInsert[0].valor ){
                this.btnInsertProductoPaso02Load(false);
            }else{
                this.btnInsertProductoPaso02Load(true);
            }
        },
        validarInsertProductoPaso02Nombre(value){
            this.vpInsert[value].nombre = HtmlSanitizer.SanitizeHtml(this.vpInsert[value].nombre);
        },
        validarInsertProductoPaso04(){
            if( (this.productoRadio.linked !== undefined) && (this.productoRadio.show !== undefined) ){
                this.btnInsertProductoPaso04Load(false, false);
            }else{
                this.btnInsertProductoPaso04Load(false, true);
            }
        },
        validarInsertProductoPaso04Linked(value){
            this.productoRadio.linked = value;
            this.validarInsertProductoPaso04();
        },
        validarInsertProductoPaso04Show(value){
            this.productoRadio.show = value;
            this.validarInsertProductoPaso04();
        },
        goStep01(){
            Swal.showLoading();
            $('#mdlProductoPaso02').modal('hide');
            $('#mdlProductoPaso01').modal('show');
            Swal.close();
        },
        goStep02(){
            Swal.showLoading();
            $('#mdlProductoPaso01').modal('hide');
            $('#mdlProductoPaso02').modal('show');
            $('#mdlProductoPaso03').modal('hide');
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
        addVV() {
            this.vpInsert.push({ nombre: '', valor: '' });
        },
        removeVV(index) {
            this.vpInsert.splice(index, 1)
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
        insertProducto(){
            const self          = this;
            const titleAccion   = 'PRODUCTO';
            const textAccion    = 'EL PRODUCTO HA SIDO INGRESADO EXITOSAMENTE';
            this.btnInsertProductoPaso04Load(true, true);
            Swal.showLoading();

            const formData = new FormData();
            formData.append('idGrupo', this.grupoTemp.GRUPO_ID );
            formData.append('producto', JSON.stringify(this.productoInsert) );
            formData.append('vp', JSON.stringify(this.vpInsert) );
            formData.append('opt', JSON.stringify(this.productoRadio) );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );

            this.$http.post(base_url + 'menu/insertProducto', formData).then(function(res) {
                                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
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
        resetProductosEdit(){
            this.productosEdit = {
                                    PRODUCTO_ID: '',
                                    PRODUCTO_NOMBRE: '',
                                    PRODUCTO_DET: '',
                                    PRODUCTO_DESC: ''
                                }
        },
        insertProductosOrder() {
            const self          = this;
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = 'LOS PRODUCTOS HAN SIDO REORDENADO EXITOSAMENTE';
            this.btnEditOrderProductosLoad(true, true);
            Swal.showLoading();

            this.$http.post(base_url + 'menu/orderProductos', { productos: this.productosEdit }).then(function(res) {

                self.btnEditOrderProductosLoad(false, false);
                if ( res.data.ok ) {
                    self.instanciar();
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
        detalleProducto(p){
            const self          = this;
            this.productoGet    = p;
            Swal.showLoading();

            let dataString = { idProducto: p.PRODUCTO_ID, limit: this.maxImgs };
            this.$http.post( base_url + 'menu/getProducto', dataString ).then(function(res) {

                self.productoGetVPS     = res.data.vps;
                self.productoGetImgs    = res.data.imagenes;
                Swal.close();
                
            }, function() {
                console.log('Error detalleProducto');
            });
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
        resetEditProducto(){
            this.productosEdit = { PRODUCTO_NOMBRE: '', PRODUCTO_DET: '', PRODUCTO_DESC: '' };
        },
        editProducto(){
            const self          = this;
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = 'EL PRODUCTO HA SIDO EDITADO EXITOSAMENTE';
            this.btnEditProductoLoad(true, true);
            Swal.showLoading();

            const formData = new FormData();
            formData.append('producto', JSON.stringify(this.productosEdit) );

            this.$http.post(base_url + 'menu/editProducto', formData).then(function(res) {
                
                self.btnEditProductoLoad(false, false);
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
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
        hideProducto(value) {
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = value.PRODUCTO_SHOW == 1 ? `ESTA ACCIÓN OCULTARÁ EL PRODUCTO ${value.PRODUCTO_NOMBRE}` : `ESTA ACCIÓN MOSTRARÁ EL PRODUCTO ${value.PRODUCTO_NOMBRE}`;
            const buttonText    = value.PRODUCTO_SHOW == 1 ? "SI, OCULTAR PRODUCTO!" : "SI, ACTIVAR PRODUCTO!";
            const buttonColor   = value.PRODUCTO_SHOW == 1 ? "#d9534f" : "#5cb85c";
            const apiRest       = base_url + 'menu/productoHidden';
            const dataString    = { idProducto: value.PRODUCTO_ID, value: value.PRODUCTO_SHOW };
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = value.PRODUCTO_SHOW == 0 ? "EL PRODUCTO ESTÁ ACTIVO" :  "EL PRODUCTO YA NO ESTÁ ACTIVO";
            const errorAccion   = 'Error hideProducto';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        hideProductoLinked(value) {
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = value.PRODUCTO_LINKED == 1 ? `ESTA ACCIÓN OCULTARÁ EL DETALLE DEL PRODUCTO ${value.PRODUCTO_NOMBRE}` : `ESTA ACCIÓN MOSTRARÁ EL DETALLE DEL PRODUCTO ${value.PRODUCTO_NOMBRE}`;
            const buttonText    = value.PRODUCTO_LINKED == 1 ? "SI, OCULTAR DETALLE DEL PRODUCTO!" : "SI, ACTIVAR DETALLE DEL PRODUCTO!";
            const buttonColor   = value.PRODUCTO_LINKED == 1 ? "#d9534f" : "#5cb85c";
            const apiRest       = base_url + 'menu/productoLinkedHidden';
            const dataString    = { idProducto: value.PRODUCTO_ID, value: value.PRODUCTO_LINKED };
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = value.PRODUCTO_LINKED == 0 ? "SE MOSTRARÁ DETALLE DEL PRODUCTO" :  "NO SE MOSTRARÁ DETALLE DEL PRODUCTO";
            const errorAccion   = 'Error hideProductoLinked';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        deleteProducto(value) {
            const title         = "¿ESTÁS SEGURO?";
            const txtText       = `ESTA ACCIÓN ELIMINARÁ EL PRODUCTO ${value.PRODUCTO_NOMBRE}, Y LOS VALORES ASOCIADOS`;
            const buttonText    = 'SI, ELIMINAR PRODUCTO';
            const buttonColor   = "#d9534f";
            const apiRest       = base_url + 'menu/productoDelete';
            const dataString    = { idProducto: value.PRODUCTO_ID };
            const titleAccion   = 'PRODUCTOS';
            const textAccion    = 'EL PRODUCTO HA SIDO ELIMINADO EXITOSAMENTE';
            const errorAccion   = 'Error deleteProducto';
            const instanciar    = true;

            this.swalLoading(title, txtText, buttonText, buttonColor, apiRest, dataString, titleAccion, textAccion, errorAccion, instanciar);
        },
        instanciarEditVP( p ){
            Swal.showLoading();
            const self              = this;
            this.productoGet        = p;
            this.productoEditVPS    = {};
            let array               = [];

            let dataString = { idProducto: p.PRODUCTO_ID, limit: this.maxImgs };
            this.$http.post( base_url + 'menu/getProducto', dataString ).then(function(res) {

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
        removeEditVV(index) {
            this.productoEditVPS.splice(index, 1);
            this.validarEditVP();
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

            const dataString = { idProducto: this.productoGet.PRODUCTO_ID, vps: JSON.stringify(this.productoEditVPS) };
            this.$http.post(base_url + 'menu/editVP', dataString).then(function(res) {                
                
                if( res.data.ok ){
                    self.swalSuccess(titleAccion, textAccion);
                    self.instanciar();
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
            this.$http.post( base_url + 'menu/getProducto', dataString ).then(function(res) {

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
            const apiRest       = base_url + 'menu/imagenDelete';
            const dataString    = { img: img };
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
            formData.append('idProducto', this.productoGet.PRODUCTO_ID );
            formData.append('imagen', this.imgTemp );
            formData.append('widthResize', this.widthResize );
            formData.append('coords', JSON.stringify(this.coords) );

            this.$http.post(base_url + 'menu/editGaleriaProductos', formData).then(function(res) {
                
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
        txtBtnLoad(){
            return '<i class="fas fa-sync-alt fa-spin"></i> PROCESANDO...';
        },
        btnEditOrderGrupoLoad(load, dis){
            this.btnEditOrderGrupo.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> REORDENAR GRUPOS'
            this.btnEditOrderGrupo.disabled = dis;
        },
        btnInsertGrupoLoad(load, dis){
            this.btnInsertGrupo.txt = load ? this.txtBtnLoad() : '<i class="fas fa-sync-alt"></i> AGREGAR GRUPO'
            this.btnInsertGrupo.disabled = dis;
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
                            instanciar ? self.instanciar() : self.instanciarEditGaleria( self.productoGet );
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
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">MANUAL DE USUARIO</h1>
            <h2 class="text-center">SECCIÓN MENÚ</h2>

            <div class="row margin-top-01">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">NOMENCLATURA</h3>

                    <div class="d-flex">
                        <ul class="list-inline mx-auto justify-content-center">
                            <li><span class="font-weight-bold">GRUPO</span>: Conjunto de productos agrupados.</li>
                            <li><span class="font-weight-bold">PRODUCTO</span>: Artículo a vender.</li>
                            <li><span class="font-weight-bold">VARIACIÓN DE PRECIO</span>: Subdivisión de precios del producto a vender.</li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="row margin-top-01">
                <div class="col-12">
                    <h1 class="text-center margin-top-01">GRUPO</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">ORDENAR Y AGREGAR GRUPO</h3>
                    <img src="<?php echo base_url('public/images/help/menu/01-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block" >
                    <p>Botones que abrirán modal respectivo para cada acción</p>

                </div>
            </div>
            
            <div class="row margin-top-01">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">ORDENAR GRUPOS</h3>
                    <img src="<?php echo base_url('public/images/help/menu/02-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block" >
                    <p>Opción que podrá ordenar a gusto los grupos, indistintamente al órden en que fue ingresado,<br> esto puede ser realizado mediante Drag & Drop (agarrar y arrastrar).<br> Es seleccionado el grupo a mover y luego se arrastra al lugar deseado.</p>

                </div>
            </div>
            
            <div class="row margin-top-01">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">AGREGAR GRUPO</h3>
                    <img src="<?php echo base_url('public/images/help/menu/11-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block" >
                    <p>Modal, en donde podrá ser ingresado un nuevo grupo.<br>
                    Nombre del grupo obligatorio.<br>
                    Imagen optativa, debe ser formato JPG o PNG, máximo 1MB.</p>

                </div>
            </div>
            
            <div class="row margin-top-01">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">OPCIONES GRUPO</h3>
                    <img src="<?php echo base_url('public/images/help/menu/12-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block" >
                    <p>Opciones de cada grupo, detalladas a continuación:</p>

                    <div class="d-flex">
                        <ul class="list-inline mx-auto justify-content-center">
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-plus"></i></button></span>: Será abierta ventana modal, en donde podrá ser agregado producto relacionado al grupo.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-edit"></i></button></span>: Será abierta ventana modal, en donde podrá ser editado el texto e imagen del grupo.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-eye-slash"></i></button></span>: Opción para ocultar el grupo respectivo, y todos los productos asociados, en el menú.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-arrows-alt"></i></button></span>: Será abierta ventana modal, con el listado de productos ingresados al grupo, en donde se podrá cambiar el órden de estos.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></span>: Podrá ser eliminado el grupo, y todos los productos asociados, sin opción a ser recuperado.</li>
                        </ul>
                    </div>

                </div>
            </div>

            <hr>

            <div class="row margin-top-01">
                <div class="col-12">
                    <h1 class="text-center margin-top-01">CREAR PRODUCTO</h1>
                </div>
            </div>
            
            <div class="row margin-top-01">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">NUEVO PRODUCTO</h3>
                    <img src="<?php echo base_url('public/images/help/menu/13-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block" >
                    <p>Para ingresar nuevo producto, se debe realizar click en el ícono de las opciones del grupo, indicado en la figura.</p>

                </div>
            </div>
            
            <div class="row margin-top-01">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">MODAL NUEVO PRODUCTO</h3>


                    <h4 class="text-center">PASO 1</h4>
                    <img src="<?php echo base_url('public/images/help/menu/14-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block">
                    <p>Paso 1, descripción nuevo producto.<br>
                    Datos para crear nuevo producto:</p>

                    <div class="d-flex">
                        <ul class="list-inline mx-auto justify-content-center">
                            <li><span class="font-weight-bold">NOMBRE DEL PRODUCTO</span>: Campo obligatorio, en donde se ingresará el nombre del producto.</li>
                            <li><span class="font-weight-bold">DETALLE DEL PRODUCTO</span>: Campo opcional, en donde se ingresará el detalle del producto. Esta información se visualizará en la vista principal del menú.</li>
                            <li><span class="font-weight-bold">DESCRIPCIÓN DEL PRODUCTO</span>: Campo opcional, en donde se ingresará la descripción del producto. Esta información se visualizara en la vista individual del producto.</li>
                        </ul>
                    </div>

                    <h4 class="text-center mt-2">PASO 2</h4>
                    <img src="<?php echo base_url('public/images/help/menu/15-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block">
                    <p>Paso 2, valor(es) del producto.<br>
                    Datos para ingresar valores:</p>

                    <div class="d-flex">
                        <ul class="list-inline mx-auto justify-content-center">
                            <li><span class="font-weight-bold">NOMBRE BASE(1)</span>: Campo opcional, en donde se podrá ingresar el nombre de este valor.</li>
                            <li><span class="font-weight-bold">VALOR BASE(1)</span>: Campo obligatorio, en donde se podrá ingresar el valor de este producto.</li>                            
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-primary"><i class="fas fa-plus"></i></button></span>: Al presionar este ícono, se podrá agregar otro valor, ya que su producto puede tener multiples precios.</li>
                            <li><span class="font-weight-bold">NOMBRE</span>: Campo obligatorio, en donde se podrá ingresar el nombre de este valor.</li>
                            <li><span class="font-weight-bold">VALOR</span>: Campo obligatorio, en donde se podrá ingresar el valor de este producto.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></span>: Al presionar este ícono, se podrá eliminar el par respectivo nombre/valor.</li>
                        </ul>
                    </div>

                    <h4 class="text-center mt-2">PASO 3</h4>
                    <img src="<?php echo base_url('public/images/help/menu/16-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block">
                    <p>Paso 3, imagen principal del producto.<br>
                       Las indicaciones són:</p>

                    <div class="d-flex">
                        <ul class="list-inline mx-auto justify-content-center">
                            <li>Formatos soportados JPG o PNG.</li>
                            <li>1MB máximo por imagen.</li>
                            <li>
                        </ul>
                    </div>
                    
                    <h4 class="text-center mt-2">PASO 4</h4>
                    <img src="<?php echo base_url('public/images/help/menu/17-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block">
                    <p>Paso 4, selecionar opciones del producto.<br>
                       Se debe seleccionar:</p>

                    <div class="d-flex">
                        <ul class="list-inline mx-auto justify-content-center">
                            <li>Si se desea o no mostrar el detalle del producto.</li>
                            <li>Si se desea o no activar el producto para ser visualizado automáticamente en el menú.</li>
                            <li>Al estar seleccionadas las opciones anteriores, se habilitará el botón para ser ingresado el producto.</li>
                            <li>
                        </ul>
                    </div>

                </div>
            </div>

            <hr>

            <div class="row margin-top-01">
                <div class="col-12">
                    <h1 class="text-center margin-top-01">OPCIONES DEL PRODUCTO</h1>
                </div>
            </div>

            <div class="row margin-top-01">
                <div class="col-12">

                    <h3 class="text-center margin-top-01">OPCIONES</h3>
                    <img src="<?php echo base_url('public/images/help/menu/10-menu.png')?>" alt="" class="img-fluid img-thumbnail mx-auto d-block" >
                    <p>Opciones de cada producto, detalladas a continuación:</p>

                    <div class="d-flex">
                        <ul class="list-inline mx-auto justify-content-center">
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button></span>: Será abierta ventana modal, en donde se podrá ver el detalle completo del producto ingresado.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-edit"></i></button></span>: Será abierta ventana modal, en donde podrá ser editado el texto descriptivo del producto: nombre, detalle y descripción.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-dollar-sign"></i></button></span>: Será abierta ventana modal, en donde podrá agregar, eliminar, editar la variación de precio del producto.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-images"></i></button></span>: Será abierta ventana modal, en donde podrá agregar, eliminar, editar las imágenes respectivas del producto.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-link"></i></button></span>: Opción para NO mostrar el detalle del producto en el menú, toda la información será visualizada en la vista principal de su menú.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-outline-primary"><i class="fas fa-eye-slash"></i></button></span>: Opción para ocultar el producto en su menú.</li>
                            <li><span class="font-weight-bold"><button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></span>: Opción para eliminar el producto, NO podrá ser recuperada.</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
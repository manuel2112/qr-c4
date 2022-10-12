<?php 
	$this->extend('layouts/main');
	$session = session();
?>

<?php $this->section('content') ?>

<div class="row">
	<div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $session->get('usuario')['nmbqrsession'] ?></a></li>
                <li class="breadcrumb-item active">Administrador</li>
            </ol>
        </nav>		
	</div>
</div>

<div id="app" v-cloak>

	<div class="row mt-2">
		
		<div class="col-12">

			<div class="form-group">
				<div class="input-group">
					<select 
					class="form-control form-control-lg"
					@change="validateCmbEmpresa()"
					v-model.trim=" empresaCmb ">					
						<option value=""> SELECCIONAR EMPRESA...</option>
						<option v-for=" e in empresas " :key=" e.EMPRESA_ID " :value=" e.EMPRESA_ID ">{{ e.EMPRESA_NOMBRE }}</option>
					</select>

					<div class="input-group-append">
						<button 
							type="button" 
							class="btn btn-lg btn-outline-primary" 
							v-html=" btnBuscarEmpresa.txt " 
							:disabled=" btnBuscarEmpresa.disabled "
							@click="getEmpresa()">
						</button>
					</div>
				</div>
			</div>

		</div>

	</div>

	<div class="row" v-if="empresa">
		<div class="col-12">
			<h1 class="text-secondary">{{ empresa.EMPRESA_NOMBRE }}</h1>
		</div>
		<div class="col-12">
			<div class="btn-group mt-3">
				<button 
					type="button" 
					class="btn btn-outline-primary"
					title="DATOS"
					@click=" getDatos() ">
					<i class="fas fa-cog"></i> DATOS
				</button>
				<button 
					type="button" 
					class="btn btn-outline-primary"
					title="PLAN"
					@click=" getPlan() ">
					<i class="fa fa-credit-card"></i> PLAN
				</button>
				<button 
					type="button" 
					class="btn btn-outline-primary"
					title="MENÚ"
					@click=" getMenu() ">
					<i class="fas fa-bars"></i> MENÚ
				</button>
				<button 
					type="button" 
					class="btn btn-outline-primary"
					title="ACCIONES"
					@click=" getAcciones() ">
					<i class="fas fa-network-wired"></i> ACCIONES
				</button>
				<button 
					type="button" 
					class="btn btn-outline-primary"
					title="DAR MEMBRESÍA"
					@click=" getPlanes() ">
					<i class="fa fa-gift"></i> DAR MEMBRESÍA
				</button>
				<button 
					type="button" 
					class="btn btn-outline-primary"
					title="RESET"
					@click=" resetInfo() ">
					<i class="fas fa-book-dead"></i> RESET
				</button>
			</div>
		</div>
	</div>

	<div class="row mt-5" v-if=" datos ">
		
		<div class="col-12 text-center">
			<img v-if=" datos.EMPRESA_LOGOTIPO " :src=" '<?php echo base_url()?>/public/' + datos.EMPRESA_LOGOTIPO" class="img-thumbnail logo-perfil" width="auto">
			<img v-else src="<?php echo base_url()?>/public/images/default.png" class="img-thumbnail" width="auto">
			
			<img :src="datos.QR_URL" alt="" class="img-thumbnail logo-perfil" width="auto" />
		</div>

		<div class="col-12">
				
			<table class="table">
				<tr>
					<td class="table-primary" style="width:14%">NOMBRE</td>
					<td>
						{{datos.EMPRESA_NOMBRE}}
					</td>
				</tr>
				<tr>
					<td class="table-primary" style="width:14%">RESPONSABLE</td>
					<td>
						{{datos.EMPRESA_RESPONSABLE}}
					</td>
				</tr>
				<tr>
					<td class="table-primary" style="width:14%">REFERIDO</td>
					<td>
						{{datos.EMPRESA_REFERIDO}}
					</td>
				</tr>
				<tr>
					<td class="table-primary">DIRECCIÓN</td>
					<td>
						{{datos.EMPRESA_DIRECCION}}
					</td>
				</tr>
				<tr>
					<td class="table-primary">CIUDAD</td>
					<td>{{datos.comuna}}</td>
				</tr>
				<tr>
					<td class="table-primary">FONO</td>
					<td>{{datos.EMPRESA_FONO}}</td>
				</tr>
				<tr>
					<td class="table-primary">EMAIL</td>
					<td>{{datos.EMPRESA_EMAIL}}</td>
				</tr>
				<tr>
					<td class="table-primary">URL MENÚ</td>
					<td>
						<a :href="datos.SLUG_URL" target="_blank">{{ datos.SLUG_URL }}</a>
					</td>
				</tr>
				<tr>
					<td class="table-primary">DESCRIPCIÓN</td>
					<td v-html=" nl2br(datos.EMPRESA_DESCRIPCION) "></td>
				</tr>
				<tr>
					<td class="table-primary" style="width:15%">WHATSAPP</td>
					<td>{{ datos.EMPRESA_WHATSAPP ? datos.EMPRESA_WHATSAPP : '---' }}</td>
				</tr>
				<tr>
					<td class="table-primary">WEB</td>
					<td>
						<a :href="datos.EMPRESA_WEB" target="_blank">{{ datos.EMPRESA_WEB ? datos.EMPRESA_WEB : '---' }}</a>
					</td>
				</tr>
				<tr>
					<td class="table-primary">FACEBOOK</td>
					<td>
						<a :href="datos.EMPRESA_FACEBOOK" target="_blank">{{ datos.EMPRESA_FACEBOOK ? datos.EMPRESA_FACEBOOK : '---' }}</a>
					</td>
				</tr>
				<tr>
					<td class="table-primary">INSTAGRAM</td>
					<td>
						<a :href="datos.EMPRESA_INSTAGRAM" target="_blank">{{ datos.EMPRESA_INSTAGRAM ? datos.EMPRESA_INSTAGRAM : '---' }}</a>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row mt-5" v-if=" membresias ">

		<div class="col-12">
				
			<button 
				class="btn btn-outline-info mb-3" 
				data-toggle="modal" 
				data-target="#modalVistas">
				<strong>{{ vistas.vistas.length }} VISTAS MENSUALES: VER DETALLE</strong>
				<i class="fa fa-chevron-right"></i>
				<i class="fa fa-chevron-right"></i>
			</button>

			<table class="table table-bordered table-hover">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">PLAN</th>
						<th scope="col">DESDE</th>
						<th scope="col">HASTA</th>
						<th scope="col">PAGO</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for=" (mem,index) in membresias " :key="mem" :class=" mem.EMP_MEMB_FLAG == 1 ? 'table-primary' : '' ">
						<th scope="row">{{ ++index }}</th>
						<td>{{ mem.MEMBRESIA_NOMBRE }}</td>
						<td>{{ mem.EMP_MEMB_INSERT | fechaLatinaCompleta }}</td>
						<td>{{ mem.EMP_MEMB_HASTA | fechaLatinaCompleta }}</td>
						<td class="text-center text-success" v-if="mem.EMP_MEMB_FREE == 0"><i class='fa fa-check'></i></td>
						<td class="text-center text-danger" v-else><i class='fa fa-times'></i></td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

	<div class="row mt-5" v-if=" acciones ">

		<div class="col-12">
				
			<table class="table table-hover">
				<tr v-for=" (ac,i) in acciones " :key=" ac.ACCION_DATE ">
					<td class="table-primary" style="width:3%">
						{{ ++i }}
					</td>
					<td style="width:15%">
						{{ ac.ACCION_DATE | fechaLatinaCompleta }}
					</td>
					<td>
						{{ac.ACCION_TXT}}
					</td>
				</tr>
			</table>

		</div>
	</div>

	<div class="row mt-5" v-if=" planes ">

		<div class="col-12">
				
			<form @submit.prevent=" insertGift " class="mt-3">
									
				<div class="form-group">
					<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-arrow-right"></i></span> 
					<select 
						class="form-control form-control-lg"
						v-model.trim=" mdl.MEMBRESIA_ID "
						@change="validateGiftPlan()">
					
					<option value=""> SELECCIONA PLAN...</option>
					<option v-for=" pl in planes " :key=" pl " :value=" pl.MEMBRESIA_ID ">{{ pl.MEMBRESIA_NOMBRE }}</option>
					</select>
					</div>
				</div>
									
				<div class="form-group">
					<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-arrow-right"></i></span> 
					<select 
						class="form-control form-control-lg"
						v-model.trim=" mdl.PAGO_CANTIDAD "
						@change="validateGiftPlan()">
					
					<option value=""> SELECCIONA MESES...</option>
					<option v-for=" mes in meses " :key=" mes " :value=" mes ">{{ mes }}</option>
					</select>
					</div>
				</div>

				<div class="col-12 text-center">

					<div class="btn-group mt-3">
						<button 
							type="button" 
							class="btn btn-outline-danger"
							title="LIMPIAR"
							@click="resetPlan()">
							<i class="fa fa-eraser"></i> LIMPIAR
						</button>
						<button 
							type="submit" 
							class="btn btn-outline-success"
							title="INGRESAR" 
							v-html=" btnPlan.txt " 
							:disabled=" btnPlan.disabled ">
						</button>
					</div>

				</div>

			</form>

		</div>
	</div>

	<div class="row mt-5" v-if=" grupos ">

		<div class="col-12">

			<div class="row">
				<div class="col-12">
					<div class="btn-group my-3 float-right">
						<button 
							type="button" 
							class="btn btn-primary" 
							data-toggle="modal" 
							data-target="#mdlOrderGrupos"
							title="REORDENAR GRUPOS"
							v-if=" grupos.length > 1 "
							@click="instanciarGrupoOrder()">
							<i class="fas fa-bars"></i> REORDENAR GRUPOS
						</button>

						<button 
							type="button" 
							class="btn btn-primary" 
							data-toggle="modal" 
							data-target="#mdlInsertGrupo"
							title="AGREGAR GRUPO" 
							@click=" resetMdlInsertGrupo() ">
							<i class="fas fa-plus"></i> AGREGAR GRUPO
						</button>
					</div>
				</div>
			</div>

			<div class="card menu-card" v-for=" grupo in grupos ">
				
				<div class="card-header">
					{{ grupo.GRUPO.GRUPO_NOMBRE }}
					<div class="btn-group">

						<button 
							type="button" 
							class="btn btn-outline-primary" 
							data-toggle="modal" 
							data-target="#mdlProductoPaso01" 
							title="AGREGAR PRODUCTO" 
							@click=" instanciarInsertProducto(grupo.GRUPO) ">
							<i class="fas fa-plus"></i> PRODUCTO
						</button>

						<button 
							type="button" 
							class="btn btn-outline-primary" 
							data-toggle="modal" 
							data-target="#mdlEditGrupo" 
							title="EDITAR GRUPO" 
							@click=" instanciarEditGrupo(grupo.GRUPO) ">
							<i class="fas fa-edit"></i>
						</button>
						
						<button 
							type= "button" 
							class= "btn btn-outline-primary" 
							data-toggle="modal" 
							data-target="#mdlOrderProductos"  
							title= "ORDENAR PRODUCTOS" 
							@click= " asignarProductos(grupo.GRUPO,grupo.PRODUCTOS) "
							v-if=" grupo.COUNT_PRODUCTOS > 1 ">
							<i class="fas fa-arrows-alt"></i>
						</button>
							
						<button 
							type= "button" 
							class= "btn" 
							:class= " grupo.GRUPO.GRUPO_SHOW == 1 ? 'btn-outline-primary' : 'btn-primary' " 
							title= "OCULTAR GRUPO" 
							@click= " hideGrupo(grupo.GRUPO) ">
							<i class="fas fa-eye-slash"></i>
						</button>

						<button 
							type="button" 
							class="btn btn-danger" 
							title="ELIMINAR GRUPO" 
							@click=" deleteGrupo(grupo.GRUPO) ">
							<i class="fas fa-trash-alt"></i>
						</button>

					</div>
				</div>
				
				<table class="table table-hover" v-if=" grupo.COUNT_PRODUCTOS > 0 ">
					<tbody>
						<tr v-for=" producto in grupo.PRODUCTOS ">
							<th width="20%">
								{{ producto.PRODUCTO_NOMBRE }}
							</th>
							<th>
								<div class="btn-group">

									<button 
										type="button" 
										class="btn btn-outline-primary" 
										data-toggle="modal" 
										data-target="#mdlVerProducto" 
										title="VER PRODUCTO" 
										@click=" detalleProducto(producto) ">
										<i class="fas fa-eye"></i>
									</button>
									
									<button 
										type="button" 
										class="btn btn-outline-primary" 
										data-toggle="modal" 
										data-target="#mdlEditProducto" 
										title="EDITAR PRODUCTO" 
										@click=" instanciarEditProducto(producto) ">
										<i class="fas fa-edit"></i>
									</button>
									
									<button 
										type="button" 
										class="btn btn-outline-primary" 
										data-toggle="modal" 
										data-target="#mdlEditVP" 
										title="VARIACIÓN DE PRECIO" 
										@click=" instanciarEditVP(producto) ">
										<i class="fas fa-dollar-sign"></i>
									</button>
									
									<button 
										type="button" 
										class="btn btn-outline-primary" 
										data-toggle="modal" 
										data-target="#mdlEditGaleria" 
										title="GALERÍA DE IMÁGENES" 
										@click=" instanciarEditGaleria(producto,true) ">
										<i class="fas fa-images"></i>
									</button>
									
									<button 
										type= "button" 
										class= "btn" 
										:class= " producto.PRODUCTO_LINKED == 1 ? 'btn-outline-primary' : 'btn-primary' " 
										title= "MOSTRAR/OCULTAR DETALLE PRODUCTO" 
										@click= " hideProductoLinked(producto) ">
										<i class="fas fa-link"></i>
									</button>

									<button 
										type= "button" 
										class= "btn" 
										:class= " producto.PRODUCTO_SHOW == 1 ? 'btn-outline-primary' : 'btn-primary' " 
										title= "OCULTAR PRODUCTO" 
										@click= " hideProducto(producto) ">
										<i class="fas fa-eye-slash"></i>
									</button>

									<button 
										type="button" 
										class="btn btn-danger" 
										title="ELIMINAR PRODUCTO" 
										@click=" deleteProducto(producto) ">
										<i class="fas fa-trash-alt"></i>
									</button>

								</div>
							</th>
						</tr>
					</tbody>
				</table>

			</div><!-- FIN LOOP GRUPOS -->
			

		</div>

	</div>

	

	<!--=====================================
	MODAL DETALLE VISTAS
	======================================-->
	<div id="modalVistas" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" v-if=" vistas ">  
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title" v-if=" vistas ">DETALLE VISTAS<br> DESDE {{ vistas.inicio | fechaLatinaConHora }}<br> HASTA {{ vistas.fin | fechaLatinaConHora }}</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
			
				<div class="modal-body">
					
					<div class="row">
					
						<div class="col-12">

						<table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">#</th>
								<th scope="col">FECHA</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for=" (vista,index) in vistas.vistas " :key="vista.VISTA_DATE">
									<td>{{ ++index }}</td>
									<td>{{ vista.VISTA_DATE | fechaLatinaCompleta }}</td>
								</tr>
								<tr v-if=" vistas.vistas.length == 0 ">
									<td colspan="2">SIN VISTAS REGISTRADAS</td>
								</tr>
							</tbody>
						</table>
							
						</div>
						
					</div><!-- PIE ROW -->

				</div>

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-default pull-left" 
						data-dismiss="modal">
						Salir
					</button>
				</div>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL ORDENAR GRUPOS
	======================================-->
	<div id="mdlOrderGrupos" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" insertGrupoOrder ">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">ORDENAR GRUPOS</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal" 
							@click=" resetMdlGrupoOrder ">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
					
					<div class="modal-body">

						<div class="row">
						
							<draggable v-model="gruposEdit" group="fragenblatt" style="width:90%;margin:0 auto" @change=" validateGrupoOrder ">
								<ul class="list-group drag" id="sort" v-for="(grupo, index) in gruposEdit">
									<li class="list-group-item d-flex justify-content-between">
										{{ grupo.GRUPO.GRUPO_NOMBRE }} <i class="fas fa-arrows-alt"></i></i>
									</li>
								</ul>
							</draggable>

						</div>
					</div>

					<!--=====================================
					PIE DEL MODAL
					======================================-->

					<div class="modal-footer">
						<button 
							type="button" 
							class="btn btn-default" 
							data-dismiss="modal" 
							@click=" resetMdlGrupoOrder ">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnEditOrderGrupo.txt " 
							:disabled=" btnEditOrderGrupo.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL ADD GRUPO
	======================================-->
	<div id="mdlInsertGrupo" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" insertGrupo " id="form-insert-grupo">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">AGREGAR GRUPO</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal"
							@click="resetMdlInsertGrupo()">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
					
					<div class="modal-body">	
						
						<div class="row">				
							
							<div class="col-12">

								<div class="form-group mb-5">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-plus"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg"
											placeholder="INGRESAR GRUPO (*)..." 
											v-model.trim=" grupoInsert "
											@input=" validarGrupoInsert " 
											required>
									</div>
								</div>
					
								<div class="row mt-5">
									<div class="col-12">
										<span class="help-block text-secondary">{{ imgProps.avisoHTMLMaxSize }}</span><br>
										<span class="help-block text-secondary">{{ imgProps.avisoHTMLTypes }}</span>
									</div>
								</div>

								<div class="form-group">
									<input 
										type="file"
										class="img-grupo"
										id="insert-grupo"
										@change=" loadImg "
										accept="image/*" />
								</div>
							
								<div class="text-center" v-if=" imgTempSrc != '' ">
									
									<div class="btn-group my-3">
										
										<button 
											type="button" 
											class="btn btn-warning"
											@click=" cutImgTemp(cutBool,'#cut-add-grupo', false) ">
											<i class="fas fa-cut"></i> RECORTAR
										</button>
										
										<button 
											type="button" 
											class="btn btn-danger"
											@click=" deleteImgTemp() ">
											<i class="fas fa-trash-alt"></i> ELIMINAR
										</button>
									</div>

									<br>

									<img 
										:src=" imgTempSrc " 
										class="img-thumbnail"
										id="cut-add-grupo"
										:width="widthResize">

								</div>

							</div>

						</div><!-- PIE ROW -->
					
					</div>

					<!--=====================================
					PIE DEL MODAL
					======================================-->

					<div class="modal-footer">
						<button 
							type="button" 
							class="btn btn-default" 
							data-dismiss="modal"
							@click="resetMdlInsertGrupo()">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnInsertGrupo.txt " 
							:disabled=" btnInsertGrupo.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL ADD PRODUCTO PASO 01
	======================================-->
	<div id="mdlProductoPaso01" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title">AGREGAR PRODUCTO EN: {{ grupoTemp.GRUPO_NOMBRE }}</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
				
				
				<div class="modal-body">

					<h3>PASO 1</h3>
					<small class="help-block text-secondary">*CAMPO NOMBRE OBLIGATORIO</small>

					<div class="form-group mt-2">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-plus-circle"></i></span>
							<input 
								type="text" 
								class="form-control"
								placeholder="INGRESAR NOMBRE PRODUCTO (*)..."
								v-model.trim=" productoInsert.nombre "
								@input=" validarInsertProductoPaso01 ">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-text-width"></i></span>
							<textarea 
								class="form-control" 
								rows="2" 
								placeholder="INGRESAR DETALLE...SE MOSTRARÁ EN LA VISTA PRINCIPAL DEL MENÚ"
								v-model.trim=" productoInsert.detalle "
								@input=" validarInsertProductoPaso01Detalle "></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-text-height"></i></span>
							<textarea 
								class="form-control" 
								rows="4" 
								placeholder="INGRESAR DESCRIPCIÓN...SE MOSTRARÁ EN LA VISTA INTERNA DEL PRODUCTO"
								v-model.trim=" productoInsert.descripcion "
								@input=" validarInsertProductoPaso01Descripcion "></textarea>
						</div>
					</div>
				
				</div>

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-default" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						Salir
					</button>
					<button 
						type="button" 
						class="btn btn-primary" 
						v-html=" btnInsertProductoPaso01.txt " 
						:disabled=" btnInsertProductoPaso01.disabled "
						@click=" goStep02 ">
					</button>
				</div>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL ADD PRODUCTO PASO 02
	======================================-->
	<div id="mdlProductoPaso02" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title">AGREGAR PRECIOS DE: {{ productoInsert.nombre }}</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
				
				
				<div class="modal-body">

					<h3>PASO 2</h3>
					<small class="help-block text-secondary">CAMPOS DONDE SE INGRESARÁN EL/LOS VALORES DEL PRODUCTO.<br>
					EL NOMBRE/VALOR BASE SERÁ EL PRINCIPAL.<br>
					EL NOMBRE DEBE SER IDENTIFICATORIO (EJEMPLO LT, KG, PACK, ETC.)</small>

					<div v-for="(vp, index) in vpInsert" style="margin:10px 0 25px">

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{ index + 1 }}</span>
								<input 
									type="text" 
									class="form-control"
									:placeholder=" index == 0 ? 'INGRESAR NOMBRE BASE (*)...' : 'INGRESAR NOMBRE' "
									v-model.trim=" vp.nombre "
									@input=" validarInsertProductoPaso02Nombre(index) ">
								<button 
									type="button" 
									class="btn btn-xs btn-primary btn-res" 
									title="AGREGAR VARIACIÓN DE PRODUCTO"
									@click=" addVV "
									v-if=" index == 0 ">
									<i class="fa fa-plus"></i>
								</button>
								<button 
									type="button" 
									class="btn btn-xs btn-danger btn-res" 
									title="AGREGAR VARIACIÓN DE PRODUCTO"
									@click=" removeVV(index) "
									v-else>
									<i class="fas fa-trash-alt"></i>
								</button>
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{ index + 1 }}</span>
								<input 
									type="number" 
									class="form-control"
									:placeholder=" index == 0 ? 'INGRESAR VALOR BASE (*)...' : 'INGRESAR VALOR' "
									v-model.trim=" vp.valor "
									@input=" validarInsertProductoPaso02 ">
							</div>
						</div>

					</div>
				
				</div>

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-primary" 
						v-html=" btnInsertProductoPaso02Back.txt " 
						:disabled=" btnInsertProductoPaso02Back.disabled "
						@click=" goStep01 ">
					</button>
					<button 
						type="button" 
						class="btn btn-default" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						Salir
					</button>
					<button 
						type="button" 
						class="btn btn-primary" 
						v-html=" btnInsertProductoPaso02.txt " 
						:disabled=" btnInsertProductoPaso02.disabled "
						@click=" goStep03 ">
					</button>
				</div>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL ADD PRODUCTO PASO 03
	======================================-->
	<div id="mdlProductoPaso03" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title">AGREGAR IMAGEN PRINCIPAL DE: {{ productoInsert.nombre }}</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
				
					<div class="modal-body">

						<h3>PASO 3</h3>
						<small class="help-block text-secondary">IMAGEN PRINCIPAL DEL PRODUCTO, CAMPO OPCIONAL, AL SER CREADO EL PRODUCTO Y DEPENDIENDO DE TU MEMBRESÍA PODRÁS AGREGAR LAS SIGUIENTES IMÁGENES</small>
					
						<div class="row my-2">
							<div class="col-12">
								<span class="help-block text-secondary">{{ imgProps.avisoHTMLMaxSize }}</span><br>
								<span class="help-block text-secondary">{{ imgProps.avisoHTMLTypes }}</span>
							</div>
						</div>

						<div class="row">
							<div class="col-12">

								<div class="form-group">
									<input 
										type="file"
										class="img-producto"
										id="insert-producto"
										@change=" loadImg "
										accept="image/*" />
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-12">
							
								<div class="text-center" v-if=" imgTempSrc != '' ">
									
									<div class="btn-group my-3">
										
										<button 
											type="button" 
											class="btn btn-warning"
											@click=" cutImgTemp(cutBool,'#cut-add-producto', true) ">
											<i class="fas fa-cut"></i> RECORTAR
										</button>
										
										<button 
											type="button" 
											class="btn btn-danger"
											@click=" deleteImgTemp() ">
											<i class="fas fa-trash-alt"></i> ELIMINAR
										</button>
									</div>

									<br>

									<img 
										:src=" imgTempSrc " 
										class="img-thumbnail"
										id="cut-add-producto"
										:width="widthResize">

								</div>

							</div>
						</div>

					</div>

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-primary" 
						v-html=" btnInsertProductoPaso03Back.txt " 
						:disabled=" btnInsertProductoPaso03Back.disabled "
						@click=" goStep02 ">
					</button>
					<button 
						type="button" 
						class="btn btn-default" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						Salir
					</button>
					<button 
						type="button" 
						class="btn btn-primary" 
						v-html=" btnInsertProductoPaso03.txt " 
						:disabled=" btnInsertProductoPaso03.disabled "
						@click=" goStep04 ">
					</button>
				</div>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL ADD PRODUCTO PASO 04
	======================================-->
	<div id="mdlProductoPaso04" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title">SELECCIONAR OPCIONES PARA: {{ productoInsert.nombre }}</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
				
				<div class="modal-body">

					<h3 class="mb-4">PASO 4</h3>

					<div class="row">
						<div class="col-12">
							<h4>¿DESEAS MOSTRAR EL DETALLE DEL PRODUCTO?</h4>							
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-outline-success reset" @click=" validarInsertProductoPaso04Linked(true) ">
									<input 
										type="radio" 
										value="true" 
										v-model="productoRadio.linked"> 
										SI mostrar detalle
								</label>
								<label class="btn btn-outline-danger reset" @click=" validarInsertProductoPaso04Linked(false) ">
									<input 
										type="radio" 
										value="false"
										v-model="productoRadio.linked"
										@change=" validarInsertProductoPaso04($event) "> 
										NO mostrar detalle
								</label>
							</div>
						</div>
					</div>

					<div class="row mt-5">
						<div class="col-12">
							<h4>¿DESEAS ACTIVAR ESTE PRODUCTO?</h4>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-outline-success reset" @click=" validarInsertProductoPaso04Show(true) ">
									<input 
										type="radio" 
										value="true" 
										v-model="productoRadio.show"
										@change=" validarInsertProductoPaso04($event) "> 
										SI activar
								</label>
								<label class="btn btn-outline-danger reset" @click=" validarInsertProductoPaso04Show(false) ">
									<input 
										type="radio" 
										value="false"
										v-model="productoRadio.show"
										@change=" validarInsertProductoPaso04($event) "> 
										NO activar
								</label>
							</div>
						</div>
					</div>

				</div>

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-primary" 
						v-html=" btnInsertProductoPaso04Back.txt " 
						:disabled=" btnInsertProductoPaso04Back.disabled "
						@click=" goStep03 ">
					</button>
					<button 
						type="button" 
						class="btn btn-default" 
						data-dismiss="modal"
						@click=" resetMdlInsertProducto ">
						Salir
					</button>
					<button 
						type="button" 
						class="btn btn-primary" 
						v-html=" btnInsertProductoPaso04.txt " 
						:disabled=" btnInsertProductoPaso04.disabled "
						@click=" insertProducto ">
					</button>
				</div>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL EDIT GRUPO
	======================================-->
	<div id="mdlEditGrupo" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" editGrupo " id="form-edit-grupo">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">EDITAR GRUPO: {{ grupoEdit.GRUPO_NOMBRE }}</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal"
							@click=" resetMdlEditGrupo() ">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
					
					<div class="modal-body">	
						
						<div class="row">				
							
							<div class="col-12">

								<div class="form-group mb-5">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-plus"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg"
											placeholder="EDITAR GRUPO (*)..." 
											v-model.trim=" grupoEdit.GRUPO_NOMBRE_EDIT "
											@input=" validarGrupoEdit " 
											required>
									</div>
								</div>

								<div class="form-group" v-if=" grupoEdit.GRUPO_IMG_EDIT == '' ">
									<input 
										type="file"
										class="img-grupo"
										id="edit-grupo"
										@change=" loadImg "
										accept="image/*" />
								</div>

								<div class="text-center my-3" v-if=" grupoEdit.GRUPO_IMG_EDIT != '' ">

									<button 
										type="button" 
										class="btn btn-danger" 
										@click=" deleteImgGrupo() ">
										<i class="fas fa-trash-alt"></i> ELIMINAR
									</button>
									<br>									
									<img 
										:src=" grupoEdit.GRUPO_IMG_EDIT " 
										class="img-thumbnail" 
										:width="widthResize">

								</div>
							
								<div class="text-center" v-if="imgTempSrc ">
									
									<div class="btn-group my-3">										
										<button 
											type="button" 
											class="btn btn-warning"
											@click=" cutImgTemp(cutBool,'#cut-edit-grupo', false) ">
											<i class="fas fa-cut"></i> RECORTAR
										</button>										
										<button 
											type="button" 
											class="btn btn-danger"
											@click=" deleteImgTemp() ">
											<i class="fas fa-trash-alt"></i> ELIMINAR
										</button>
									</div>

									<br>

									<img 
										:src=" imgTempSrc " 
										class="img-thumbnail"
										id="cut-edit-grupo"
										:width="widthResize">

								</div>

							</div>

						</div><!-- PIE ROW -->
					
					</div>

					<!--=====================================
					PIE DEL MODAL
					======================================-->

					<div class="modal-footer">
						<button 
							type="button" 
							class="btn btn-default" 
							data-dismiss="modal"
							@click=" resetMdlEditGrupo() ">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnEditGrupo.txt " 
							:disabled=" btnEditGrupo.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL ORDENAR PRODUCTOS
	======================================-->
	<div id="mdlOrderProductos" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" insertProductosOrder ">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">ORDENAR PRODUCTOS DE: {{ productosGrupoEdit.GRUPO_NOMBRE }}</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
					
					<div class="modal-body">	

						<div class="row">
						
							<draggable v-model="productosEdit" group="fragenblatt" style="width:90%;margin:0 auto" @change=" validateProductoOrder ">
								<ul class="list-group drag" id="sort" v-for="(producto, index) in productosEdit">
									<li class="list-group-item d-flex justify-content-between">
										{{ producto.PRODUCTO_NOMBRE }} <i class="fas fa-arrows-alt"></i></i>
									</li>
								</ul>
							</draggable>

						</div>
					</div>

					<!--=====================================
					PIE DEL MODAL
					======================================-->

					<div class="modal-footer">
						<button 
							type="button" 
							class="btn btn-default" 
							data-dismiss="modal">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnEditOrderProductos.txt " 
							:disabled=" btnEditOrderProductos.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL VER PRODUCTO
	======================================-->
	<div id="mdlVerProducto" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title">PRODUCTO: {{ productoGet.PRODUCTO_NOMBRE }}</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal"
						@click=" resetMdlEditGrupo() ">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
				
				<div class="modal-body">	
					
					<div class="row">				
						
						<div class="col-12">

						<table class="table">
							<tr>
								<td class="table-primary" style="width:15%">PRODUCTO</td>
								<td>
									{{ productoGet.PRODUCTO_NOMBRE }}
								</td>
							</tr>
							<tr>
								<td class="table-primary">DETALLE*</td>
								<td v-html=" productoGet.PRODUCTO_DET ? nl2br(productoGet.PRODUCTO_DET) : '---' "></td>
							</tr>
							<tr>
								<td class="table-primary">DESCRIPCIÓN**</td>
								<td v-html=" productoGet.PRODUCTO_DESC ? nl2br(productoGet.PRODUCTO_DESC) : '---' "></td>
							</tr>
						</table>
						<small>
							* SE MOSTRARÁ EN LA VISTA PRINCIPAL DEL MENÚ <br>
							** SE MOSTRARÁ EN LA VISTA INTERNA DEL PRODUCTO
						</small>						

						<fieldset class="scheduler-border">
							<legend class="scheduler-border">PRECIO(S)</legend>
							
							<table class="table">
								<tr v-for=" vp in productoGetVPS ">
									<td class="table-primary" style="width:15%">{{ vp.PROVAR_NOMBRE ? vp.PROVAR_NOMBRE : 'BASE' }}</td>
									<td>{{ vp.PROVAR_VALOR | formatoDinero }}</td>
								</tr>
							</table>

						</fieldset>
						
						<fieldset class="scheduler-border" v-if=" productoGetImgs.length > 0">
							<legend class="scheduler-border">IMÁGENES</legend>

							<div class="row img-productos">
								<div class="img-productos-box" v-for=" img in productoGetImgs ">
									<img v-if=" img.PROIMG_RUTA " :src=" '<?php echo base_url()?>/' + img.PROIMG_RUTA" class="img-thumbnail">									
								</div>
							</div>

						</fieldset>

						</div>

					</div><!-- PIE ROW -->
				
				</div>

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-default" 
						data-dismiss="modal">
						Salir
					</button>
				</div>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL EDIT PRODUCTO
	======================================-->
	<div id="mdlEditProducto" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" editProducto ">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">EDITAR PRODUCTO: {{ productoTitle }}</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
					
					<div class="modal-body">	

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-plus"></i></span>
								<input 
									type="text" 
									class="form-control"
									placeholder="INGRESAR NOMBRE PRODUCTO (*)..."
									v-model.trim=" productosEdit.PRODUCTO_NOMBRE "
									@input=" validarEditProducto ">
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-plus"></i></span>
								<textarea 
									class="form-control" 
									rows="2" 
									placeholder="INGRESAR DETALLE...SE MOSTRARÁ EN LA VISTA PRINCIPAL DEL MENÚ"
									v-model.trim=" productosEdit.PRODUCTO_DET "
									@input=" validarEditProducto ">
									{{ productosEdit.PRODUCTO_DET }}
								</textarea>
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-plus"></i></span>
								<textarea 
									class="form-control" 
									rows="4" 
									placeholder="INGRESAR DESCRIPCIÓN...SE MOSTRARÁ EN LA VISTA INTERNA DEL PRODUCTO"
									v-model.trim=" productosEdit.PRODUCTO_DESC "
									@input=" validarEditProducto ">
									{{ productosEdit.PRODUCTO_DESC }}
								</textarea>
							</div>
						</div>
					
					</div>

					<!--=====================================
					PIE DEL MODAL
					======================================-->

					<div class="modal-footer">
						<button 
							type="button" 
							class="btn btn-default" 
							data-dismiss="modal">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnEditProducto.txt " 
							:disabled=" btnEditProducto.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL EDIT VARIACIÓN DE PRODUCTO
	======================================-->
	<div id="mdlEditVP" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" editVP ">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
					<h4 class="modal-title">VARIACIÓN DE PRECIO: {{ productoGet.PRODUCTO_NOMBRE }}</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
					
					<div class="modal-body">	

						<div v-for="(vp, index) in productoEditVPS" style="margin-bottom:25px">

							<div class="form-group">
								<small v-if=" index == 0 ">*SI ES PRODUCTO ÚNICO SÓLO INGRESAR VALOR BASE</small>
								<div class="input-group">
									<span class="input-group-addon">{{ index + 1 }}</span>
									<input 
										type="text" 
										class="form-control"
										placeholder="INGRESAR NOMBRE BASE..."
										v-model.trim=" vp.nombre "
										@input=" validarEditVPNombre(index) "
										:required=" index > 0 ? true : false">
									<button 
										type="button" 
										class="btn btn-xs btn-primary btn-res" 
										title="AGREGAR VARIACIÓN DE PRECIO"
										@click=" editVV "
										v-if=" index == 0 ">
										<i class="fa fa-plus"></i>
									</button>
									<button 
										type="button" 
										class="btn btn-xs btn-danger btn-res" 
										title="ELIMINAR VARIACIÓN DE PRECIO"
										@click=" removeEditVV(index) "
										v-else>
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</div>

							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">{{ index + 1 }}</span>
									<input 
										type="number" 
										class="form-control"
										placeholder="INGRESAR VALOR BASE (*)..."
										v-model.trim=" vp.valor "
										@input=" validarEditVP "
										ondrop="return false;" 
										onpaste="return false;" 
										onkeypress="return event.charCode>=48 && event.charCode<=57" 
										required>
								</div>
							</div>

						</div>
					
					</div>

					<!--=====================================
					PIE DEL MODAL
					======================================-->

					<div class="modal-footer">
						<button 
							type="button" 
							class="btn btn-default" 
							data-dismiss="modal">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnEditVP.txt " 
							:disabled=" btnEditVP.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL EDIT GALERÍA PRODUCTO
	======================================-->
	<div id="mdlEditGaleria" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title">
						GALERÍA DE IMÁGENES PARA PRODUCTO: {{ productoGet.PRODUCTO_NOMBRE }} <br>
					</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
				
				<div class="modal-body">				

					<div class="row img-productos">
						<div class="img-productos-box" v-for=" img in productoEditImgs ">
							<img v-if=" img.PROIMG_RUTA " :src=" '<?php echo base_url()?>/' + img.PROIMG_RUTA" class="img-thumbnail"> <br>
							<div class="text-center">
								<button 
									type="button" 
									class="btn btn-danger"
									@click=" deleteImgProducto(img) ">
									<i class="fas fa-trash-alt"></i>
								</button>
							</div>
						</div>
					</div>

					<hr>

					<div class="row mt-5" v-if="maxImgsVar > 0">

						<div class="col-12 col-md-6">
							
							<div class="form-group">
								<input 
									type="file"
									class="form-control-file img-producto"
									id="galeria-productos"
									@change=" loadImg "
									accept="image/*" />
							</div>

						</div>
						<div class="col-12">
							
							<div class="text-center" v-if=" imgTempSrc != '' ">
								
								<div class="btn-group my-3">
									<button 
										type="button" 
										class="btn btn-success"
										@click="editGaleriaProductos">
										<i class="fas fa-upload"></i> SUBIR
									</button>
									
									<button 
										type="button" 
										class="btn btn-warning"
										@click=" cutImgTemp(cutBool,'#cut-add-galeria',true) ">
										<i class="fas fa-cut"></i> RECORTAR
									</button>
									
									<button 
										type="button" 
										class="btn btn-danger"
										@click=" deleteImgTemp() ">
										<i class="fas fa-trash-alt"></i> ELIMINAR
									</button>
								</div>

								<br>

								<img 
									:src=" imgTempSrc " 
									class="img-thumbnail"
									id="cut-add-galeria"
									:width="widthResize">

							</div>

						</div>

					</div>
					
					<div class="row mt-5">

						<div class="col-12">
							<span class="help-block text-secondary">{{ maxImgs }} {{ imgProps.avisoHTMLCant }}</span><br>
							<span class="help-block text-secondary">TIENES INGRESADAS {{ productoEditImgs .length}} DE {{ maxImgs }}</span><br>
							<span class="help-block text-secondary">{{ imgProps.avisoHTMLMaxSize }}</span><br>
							<span class="help-block text-secondary">{{ imgProps.avisoHTMLTypes }}</span>
						</div>

					</div>
				
				</div>

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-default" 
						data-dismiss="modal">
						Salir
					</button>
				</div>

			</div>

		</div>

	</div>

</div><!-- FIN APP -->

<?php $this->endSection() ?>
<div class="row">
	<div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $this->session_nmb?></a></li>
                <li class="breadcrumb-item active">Empresa</li>
				
				<li class="ml-auto"><a href="<?php echo base_url('empresa/help')?>" class="btn btn-outline-warning" target="_blank"><i class="fas fa-question"></i></a></li>
            </ol>
        </nav>		
	</div>
</div>

<div id="app" v-cloak>

	<div class="row mt-2">
		
		<div class="col-12 text-center">
			<img v-if=" empresa.EMPRESA_LOGOTIPO " :src=" '<?php echo base_url()?>' + empresa.EMPRESA_LOGOTIPO" class="img-thumbnail logo-perfil" width="auto">
			<img v-else src="<?php echo base_url()?>/public/images/default.png" class="img-thumbnail" width="auto">	
		</div>

		<div class="col-12">

			<fieldset class="scheduler-border">
				<legend class="scheduler-border">DATOS DE LA EMPRESA (* CAMPOS NO EDITABLES)</legend>
				
				<table class="table">
					<tr>
						<td class="table-primary">NOMBRE</td>
						<td>
							{{empresa.EMPRESA_NOMBRE}}
						</td>
					</tr>
					<tr>
						<td class="table-primary">DIRECCIÓN</td>
						<td>
							{{empresa.EMPRESA_DIRECCION}}
						</td>
					</tr>
					<tr>
						<td class="table-primary">RESPONSABLE</td>
						<td>
							{{empresa.EMPRESA_RESPONSABLE}}
						</td>
					</tr>
					<tr>
						<td class="table-primary">CIUDAD</td>
						<td>{{empresa.comuna}}</td>
					</tr>
					<tr>
						<td class="table-primary">FONO</td>
						<td>{{empresa.EMPRESA_FONO}}</td>
					</tr>
					<tr>
						<td class="table-primary">EMAIL *</td>
						<td>{{empresa.EMPRESA_EMAIL}}</td>
					</tr>
					<tr>
						<td class="table-primary">URL MENÚ *</td>
						<td>
							<a :href="slugURL" target="_blank">{{ slugURL }}</a>
						</td>
					</tr>
					<tr>
						<td class="table-primary">DESCRIPCIÓN</td>
						<td v-html=" nl2br(empresa.EMPRESA_DESCRIPCION) "></td>
					</tr>
				</table>

				<button 
					class="btn btn-warning" 
					data-toggle="modal" 
					data-target="#modalEditarDatos"
					@click=" cleanEditar "
					v-if=" permiso ">
					<strong>EDITAR DATOS DE LA EMPRESA</strong>
				</button>
				<a href="<?php echo base_url()?>pagos" class="btn btn-danger" v-else>
					<strong>
						RENOVAR MEMBRESÍA 
						<i class="fa fa-chevron-right"></i>
						<i class="fa fa-chevron-right"></i>
					</strong>
				</a>

			</fieldset>
			
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">MEMBRESÍA</legend>
				
				<table class="table">
					<tr>
						<td class="table-primary" style="width:14%">PLAN</td>
						<td>
							<span v-for=" (mem,index) in membresiasContratadas " :key="mem.EMP_MEMB_ID">
								<div v-if=" index == 0 && mem.MEMBRESIA_ID != 1 ">
									<button
										type="button"
										class="btn btn-outline-primary"
										title="CANCELAR PLAN"
										@click="downPlan(mem.EMP_MEMB_ID)">
										PLAN {{ mem.MEMBRESIA_NOMBRE }}</strong>: DESDE {{ mem.EMP_MEMB_INSERT | fechaLatinaSinHora }}<br> HASTA {{ mem.EMP_MEMB_HASTA | fechaLatinaSinHora }}
									</button>
								</div>
								<div v-if=" index > 0 || mem.MEMBRESIA_ID == 1 ">
									<strong>PLAN {{ mem.MEMBRESIA_NOMBRE }}</strong>: DESDE {{ mem.EMP_MEMB_INSERT | fechaLatinaSinHora }}<br> HASTA {{ mem.EMP_MEMB_HASTA | fechaLatinaSinHora }}<br>
								</div>
							</span>
						</td>
					</tr>
					<tr>
						<td class="table-primary">VISTAS MENSUALES</td>
						<td>
							<button 
								class="btn btn-info" 
								data-toggle="modal" 
								data-target="#modalVistas"
								@click="getVistas()">
								<strong>{{ vistas.count }} VISTAS: VER DETALLE</strong>
								<i class="fa fa-chevron-right"></i>
								<i class="fa fa-chevron-right"></i>
							</button>
						</td>
					</tr>
				</table>
				
				<a href="<?php echo base_url()?>pagos" class="btn btn-info">
					<strong>
						CENTRO DE PAGOS 
						<i class="fa fa-chevron-right"></i>
						<i class="fa fa-chevron-right"></i>
					</strong>
				</a>

			</fieldset>

			<fieldset class="scheduler-border">
				<legend class="scheduler-border">REDES SOCIALES</legend>
				
				<table class="table">
					<tr>
						<td class="table-primary" style="width:15%">WHATSAPP</td>
						<td>{{ empresa.EMPRESA_WHATSAPP ? empresa.EMPRESA_WHATSAPP : '---' }}</td>
					</tr>
					<tr>
						<td class="table-primary">WEB</td>
						<td>
							<a :href="empresa.EMPRESA_WEB" target="_blank">{{ empresa.EMPRESA_WEB ? empresa.EMPRESA_WEB : '---' }}</a>
						</td>
					</tr>
					<tr>
						<td class="table-primary">FACEBOOK</td>
						<td>
							<a :href="empresa.EMPRESA_FACEBOOK" target="_blank">{{ empresa.EMPRESA_FACEBOOK ? empresa.EMPRESA_FACEBOOK : '---' }}</a>
						</td>
					</tr>
					<tr>
						<td class="table-primary">INSTAGRAM</td>
						<td>
							<a :href="empresa.EMPRESA_INSTAGRAM" target="_blank">{{ empresa.EMPRESA_INSTAGRAM ? empresa.EMPRESA_INSTAGRAM : '---' }}</a>
						</td>
					</tr>
				</table>

				<button 
					class="btn btn-warning" 
					data-toggle="modal" 
					data-target="#modalEditarRedes"
					@click=" mdlRRSS "
					v-if=" permiso ">
					<strong>EDITAR REDES SOCIALES</strong>
				</button>
				<a href="<?php echo base_url()?>pagos" class="btn btn-danger" v-else>
					<strong>
						RENOVAR MEMBRESÍA 
						<i class="fa fa-chevron-right"></i>
						<i class="fa fa-chevron-right"></i>
					</strong>
				</a>

			</fieldset>
		
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">LOGOTIPO</legend>

				<div class="btn-group" v-if=" permiso ">
					<button 
						class="btn btn-warning" 
						data-toggle="modal" 
						data-target="#modalLogo"
						@click=" instanciarMdlLogo ">
						<strong>{{ txtIngresarEditarLogo }} LOGOTIPO</strong>
					</button>
				</div>
				<a href="<?php echo base_url()?>pagos" class="btn btn-danger" v-else>
					<strong>
						RENOVAR MEMBRESÍA 
						<i class="fa fa-chevron-right"></i>
						<i class="fa fa-chevron-right"></i>
					</strong>
				</a>
			</fieldset>
		
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">CONTRASEÑA</legend>

				<button 
					class="btn btn-warning" 
					data-toggle="modal" 
					data-target="#modalEditarPassword"
					@click=" cleanPass ">
					<strong>EDITAR CONTRASEÑA</strong>
				</button>

			</fieldset>

		</div>

	</div><!-- FIN ROW -->

	<!--=====================================
	MODAL EDITAR EMPRESA
	======================================-->
	<div id="modalEditarDatos" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" editDatos ">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">
							EDITAR DATOS DE LA EMPRESA<br />
							<small>* Al cambiar el nombre de tu empresa, cambiarás la URL de tu menú.</small>
						</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal"
							@click=" resetMdl ">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
				
					<div class="modal-body">
						
						<div class="row">
						
							<div class="col-12">
								
								<div class="form-group">
              						<small class="text-danger">{{ error.nombre }}</small>
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-home"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg"
											placeholder="NOMBRE EMPRESA (*)..." 
											v-model.trim =" empresa.EMPRESA_NOMBRE "
											:value=" empresa.EMPRESA_NOMBRE "
                  							@input=" validarNombre "
											required>
									</div>
								</div>
								
								<div class="form-group">
              						<small class="text-danger">{{ error.fono }}</small>
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-phone"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg"
											placeholder="TELÉFONO (*)..." 
											v-model.trim =" empresa.EMPRESA_FONO "
											:value=" empresa.EMPRESA_FONO "
                  							@input=" validarFono "
											required>
									</div>
								</div>

								<div class="form-group">
              						<small class="text-danger">{{ error.direccion }}</small>
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-location-arrow"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg" 
											placeholder="DIRECCIÓN..."
											v-model.trim =" empresa.EMPRESA_DIRECCION "
											:value=" empresa.EMPRESA_DIRECCION ">
									</div>
								</div>

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg" 
											placeholder="CIUDAD..."
											v-model.trim =" empresa.comuna "
											:value=" empresa.comuna "
											disabled>
										<button 
											type="button" 
											class="btn btn-warning btn-res" 
											@click=" btnEditarCiudad ">
											<i class="fas fa-edit"></i>
										</button>
									</div>
								</div>

								<div :class=" classEditarCiudad ">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span> 
											<select 
											class="form-control form-control-lg"
											@change="getCiudad()"
											v-model.trim=" region ">
											
											<option value=""> REGIÓN DE TU EMPRESA...</option>
											<?php
												foreach( $regiones as $region ){
												echo '<option value="'.$region->id.'">'.$region->region.'</option>';
												}
											?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span> 
											<select 
											class="form-control form-control-lg"
											v-model.trim=" ciudad "
											:disabled=" dsbCiudad ">
											
											<option value=""> CIUDAD DE TU EMPRESA...</option>
											<option v-for=" city in ciudades " :key=" city.id " :value=" city.id ">{{ city.comuna }}</option>
											</select>
										</div>
									</div>								

								</div>

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-align-left"></i></span>
										<textarea 
											class="form-control form-control-lg"
											placeholder="DESCRIPCIÓN (*)..." 
											v-model.trim =" empresa.EMPRESA_DESCRIPCION "
											rows="3">
											{{ empresa.EMPRESA_DESCRIPCION }}
										</textarea>
									</div>
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
							class="btn btn-default pull-left" 
							data-dismiss="modal"
							@click=" resetMdl ">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnDatos.txt " 
							:disabled=" btnDatos.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL EDITAR/INGRESAR LOGOTIPO
	======================================-->
	<div id="modalLogo" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title">
						{{ txtIngresarEditarLogo }} LOGOTIPO
					</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal"
						@click=" resetMdl ">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->
			
				<div class="modal-body">
					
					<div class="row">

						<div class="col-12 col-md-6">
							
							<div class="form-group" v-if=" !empresa.EMPRESA_LOGOTIPO ">
								<input
									type="file"
									class="form-control-file img-logo"
									id="insert-logo"
									@change=" loadImg "
									accept="image/*" />
							</div>

						</div>

						<div class="col-12">

							<div class="text-center my-3" v-if=" empresa.EMPRESA_LOGOTIPO ">

								<button 
									type="button" 
									class="btn btn-danger" 
									@click=" deleteLogotipo() ">
									<i class="fas fa-trash-alt"></i> ELIMINAR
								</button>
								<br>									
								<img 
									:src=" empresa.EMPRESA_LOGOTIPO " 
									class="img-thumbnail" 
									:width="widthResize">
							</div>

						</div>
								
						<div class="col-12">
							
							<div class="text-center" v-if=" imgTempSrc != '' ">
								
								<div class="btn-group my-3">
									<button 
										type="button" 
										class="btn btn-success"
										@click=" uploadLogo ">
										<i class="fas fa-upload"></i> SUBIR
									</button>
									
									<button 
										type="button" 
										class="btn btn-warning"
										@click=" cutImgTemp(cutBool,'#cut-add-logotipo') ">
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
									id="cut-add-logotipo"
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
						class="btn btn-default pull-left" 
						data-dismiss="modal"
						@click=" resetMdl ">
						Salir
					</button>
				</div>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL EDITAR RRSS
	======================================-->
	<div id="modalEditarRedes" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">  
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" editRedes ">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">EDITAR REDES SOCIALES</h4>
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal"
							@click=" resetMdl ">
							&times;
						</button>
					</div>

					<!--=====================================
					CUERPO DEL MODAL
					======================================-->
				
					<div class="modal-body">
						
						<div class="row">
						
							<div class="col-12">
							
								<div class="form-group">
									<small class="text-danger">{{ error.whatsapp }}</small>
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-whatsapp"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg"
											placeholder="WHATSAPP..." 
											v-model.trim =" editEmpresa.EMPRESA_WHATSAPP "
											:value=" editEmpresa.EMPRESA_WHATSAPP "
											@input=" validarWhatsapp ">
									</div>
								</div>
								
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-globe"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg"
											placeholder="PÁGINA WEB, INGRESAR URL COMPLETA ..." 
											v-model.trim =" editEmpresa.EMPRESA_WEB "
											:value=" editEmpresa.EMPRESA_WEB "
											@input=" validarWeb ">
									</div>
								</div>

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-facebook-square"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg" 
											placeholder="FACEBOOK, INGRESAR URL COMPLETA ..."
											v-model.trim =" editEmpresa.EMPRESA_FACEBOOK "
											:value=" editEmpresa.EMPRESA_FACEBOOK "
											@input=" validarFacebook ">
									</div>
								</div>

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-instagram"></i></span>
										<input 
											type="text" 
											class="form-control form-control-lg" 
											placeholder="INSTAGRAM, INGRESAR URL COMPLETA ..."
											v-model.trim =" editEmpresa.EMPRESA_INSTAGRAM "
											:value=" editEmpresa.EMPRESA_INSTAGRAM "
											@input=" validarInstagram ">
									</div>
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
							class="btn btn-default pull-left" 
							data-dismiss="modal"
							@click=" resetMdl ">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnRRSS.txt " 
							:disabled=" btnRRSS.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>

	<!--=====================================
	MODAL EDITAR PASSWORD
	======================================-->
	<div id="modalEditarPassword" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">  
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form @submit.prevent=" updatePass ">

					<!--=====================================
					CABEZA DEL MODAL
					======================================-->

					<div class="modal-header">
						<h4 class="modal-title">EDITAR CONTRASEÑA</h4>
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
            
								<div class="form-group">
									<div class="input-group" id="pass01">
										<span class="input-group-addon"><i class="fas fa-key"></i></span>
										<input 
										type="password" 
										class="form-control form-control-lg"                  
										placeholder="CONTRASEÑA ACTUAL..."
										v-model.trim=" editPass.actual "
										@input=" validarPass ">
										<div class="input-group-addon">
											<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
            
								<div class="form-group">
									<div class="input-group" id="pass02">
										<span class="input-group-addon"><i class="fas fa-key"></i></span>
										<input 
										type="password" 
										class="form-control form-control-lg"                  
										placeholder="NUEVA CONTRASEÑA..."
										v-model.trim=" editPass.nueva "
										@input=" validarPass ">
										<div class="input-group-addon">
											<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
            
								<div class="form-group">
									<div class="input-group" id="pass03">
										<span class="input-group-addon"><i class="fas fa-key"></i></span>
										<input 
										type="password" 
										class="form-control form-control-lg"                  
										placeholder="REPETIR NUEVA CONTRASEÑA..."
										v-model.trim=" editPass.repetir "
										@input=" validarPass ">
										<div class="input-group-addon">
											<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
										</div>
									</div>
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
							class="btn btn-default pull-left" 
							data-dismiss="modal">
							Salir
						</button>
						<button 
							type="submit" 
							class="btn btn-primary" 
							v-html=" btnPass.txt " 
							:disabled=" btnPass.disabled ">
						</button>
					</div>

				</form>

			</div>

		</div>

	</div>	

	<!--=====================================
	MODAL DETALLE VISTAS
	======================================-->
	<div id="modalVistas" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">  
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header">
					<h4 class="modal-title" v-if="resVistas.inicio">DETALLE VISTAS DESDE {{ resVistas.inicio | fechaLatinaConHora }} AL {{ resVistas.fin | fechaLatinaConHora }}</h4>
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

						<table class="table table-hover" v-if="resVistas.inicio">
							<thead>
								<tr>
								<th scope="col">#</th>
								<th scope="col">FECHA</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for=" (vista,index) in resVistas.vistas " :key="vista.VISTA_ID">
									<td>{{ ++index }}</td>
									<td>{{ vista.VISTA_DATE | fechaLatinaCompleta }}</td>
								</tr>
								<tr v-if=" resVistas.vistas.length == 0 ">
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

</div><!-- FIN APP -->
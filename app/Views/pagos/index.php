<div id="index" v-cloak>

	<div class="row">
		<div class="col-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $this->session_nmb?></a></li>
					<li class="breadcrumb-item active">Centro de Pagos</li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('pagos/miscompras')?>">Mis Compras</a></li>
				</ol>
			</nav>		
		</div>
	</div>

	<div class="row mb-2">

		<div class="col-12 mt-4" id="pagos">

			<div v-html="msnMembresia"></div>

			<h1>PLANES</h1>

			<div class="row">
				<div class="col-12">
					<p>*Servicio de administración: Como sabemos que tu tiempo vale oro, te ofrecemos el servicio para que no te preocupes de la administración de tu menú, solo debes indicarnos los cambios a realizar o agregar y lo haremos por ti.</p>
				</div>
			</div>

			<div class="row">

				<div class="col-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal">PLATA</h4>
							<small>-- La Mejor Opción --</small>
						</div>						
						<div class="card-body">
							<h1 class="card-title pricing-card-title">$10.000 <small class="text-muted">+IVA / mes</small></h1>

							<ul class="list-unstyled mt-3 mb-4">
								<li><i class="fa fa-check text-success"></i> {{ textos.qr }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.panel }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.categorias }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.productos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.fotos }}</li>
								<li><i class="fa fa-check text-success"></i> 3 {{ textos.maxfotos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.url }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.rrss }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.update }}</li>
								<li><i class="fa fa-check text-success"></i> 1.000 {{ textos.visualizaciones }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.tecnico }}</li>
								<li>&nbsp;</li>
							</ul>

							<button 
								type="button" 
								class="btn btn-lg btn-block btn-primary"
								@click=" seleccionarMembresia(2) "
								data-toggle="modal" 
								data-target="#modalPayMembresia">
								CONTRATAR
							</button>

						</div>
					</div>
				</div>
				
				<div class="col-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal">PLATA PREMIUM</h4>
							<small>-- La Mejor Opción Premium --</small>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">$15.000 <small class="text-muted">+IVA / mes</small></h1>

							<ul class="list-unstyled mt-3 mb-4">
								<li><i class="fa fa-check text-success"></i> {{ textos.qr }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.panel }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.categorias }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.productos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.fotos }}</li>
								<li><i class="fa fa-check text-success"></i> 3 {{ textos.maxfotos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.url }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.rrss }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.update }}</li>
								<li><i class="fa fa-check text-success"></i> 1.000 {{ textos.visualizaciones }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.servicio }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.tecnico }}</li>
							</ul>

							<button 
								type="button" 
								class="btn btn-lg btn-block btn-primary"
								@click=" seleccionarMembresia(3) "
								data-toggle="modal" 
								data-target="#modalPayMembresia">
								CONTRATAR
							</button>

						</div>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal">ORO</h4>
							<small>-- Medianas Empresas --</small>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">$20.000 <small class="text-muted">+IVA / mes</small></h1>

							<ul class="list-unstyled mt-3 mb-4">
								<li><i class="fa fa-check text-success"></i> {{ textos.qr }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.panel }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.categorias }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.productos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.fotos }}</li>
								<li><i class="fa fa-check text-success"></i> 9 {{ textos.maxfotos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.url }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.rrss }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.update }}</li>
								<li><i class="fa fa-check text-success"></i> 5.000 {{ textos.visualizaciones }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.tecnico }}</li>
								<li>&nbsp;</li>
							</ul>

							<button 
								type="button" 
								class="btn btn-lg btn-block btn-primary"
								@click=" seleccionarMembresia(4) "
								data-toggle="modal" 
								data-target="#modalPayMembresia">
								CONTRATAR
							</button>
							
						</div>
					</div>
				</div>
				
				<div class="col-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal">ORO PREMIUM</h4>
							<small>-- Medianas Empresas Premium --</small>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">$25.000 <small class="text-muted">+IVA / mes</small></h1>

							<ul class="list-unstyled mt-3 mb-4">
								<li><i class="fa fa-check text-success"></i> {{ textos.qr }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.panel }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.categorias }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.productos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.fotos }}</li>
								<li><i class="fa fa-check text-success"></i> 9 {{ textos.maxfotos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.url }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.rrss }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.update }}</li>
								<li><i class="fa fa-check text-success"></i> 5.000 {{ textos.visualizaciones }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.servicio }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.tecnico }}</li>
							</ul>

							<button 
								type="button" 
								class="btn btn-lg btn-block btn-primary"
								@click=" seleccionarMembresia(5) "
								data-toggle="modal" 
								data-target="#modalPayMembresia">
								CONTRATAR
							</button>
							
						</div>
					</div>
				</div>

			</div>

			<div class="row">

				<div class="col-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal">PLATINO</h4>
							<small>-- Grandes Empresas --</small>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">$40.000 <small class="text-muted">+IVA / mes</small></h1>

							<ul class="list-unstyled mt-3 mb-4">
								<li><i class="fa fa-check text-success"></i> {{ textos.qr }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.panel }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.categorias }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.productos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.fotos }}</li>
								<li><i class="fa fa-check text-success"></i> 20 {{ textos.maxfotos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.url }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.rrss }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.update }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.sinrestriccion }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.tecnico }}</li>
								<li>&nbsp;</li>
							</ul>

							<button 
								type="button" 
								class="btn btn-lg btn-block btn-primary"
								@click=" seleccionarMembresia(6) "
								data-toggle="modal" 
								data-target="#modalPayMembresia">
								CONTRATAR
							</button>

						</div>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal">PLATINO PREMIUM</h4>
							<small>-- Grandes Empresas Premium --</small>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">$45.000 <small class="text-muted">+IVA / mes</small></h1>

							<ul class="list-unstyled mt-3 mb-4">
								<li><i class="fa fa-check text-success"></i> {{ textos.qr }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.panel }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.categorias }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.productos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.fotos }}</li>
								<li><i class="fa fa-check text-success"></i> 20 {{ textos.maxfotos }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.url }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.rrss }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.update }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.sinrestriccion }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.servicio }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.tecnico }}</li>
							</ul>

							<button 
								type="button" 
								class="btn btn-lg btn-block btn-primary"
								@click=" seleccionarMembresia(7) "
								data-toggle="modal" 
								data-target="#modalPayMembresia">
								CONTRATAR
							</button>
						</div>
					</div>
				</div>					
				
				<div class="col-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card mb-4 box-shadow">
						<div class="card-header">
							<h4 class="my-0 font-weight-normal">BRONCE</h4>
							<small>-- Desarrollando mi PYME --</small>
						</div>
						<div class="card-body bg-bronce">
							<h1 class="card-title pricing-card-title">GRATIS</h1>

							<ul class="list-unstyled mt-3 mb-4">
								<li><i class="fa fa-check text-success"></i> {{ textos.qrbronce }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.url }}</li>
								<li><i class="fa fa-check text-success"></i> 200 {{ textos.visualizaciones }}</li>
								<li><i class="fa fa-check text-success"></i> {{ textos.tecnico }}</li>
								<li>&nbsp;</li>
							</ul>

							<button type="button" class="btn btn-lg btn-block btn-light" disabled>GRATIS</button>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div><!-- FIN ROW PRINCIPAL -->

	<!--=====================================
	PAGO MEMBRESIA
	======================================-->
	<div id="modalPayMembresia" class="modal fade" role="dialog" data-backdrop="static">  
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			

				<!--=====================================
				CABEZA DEL MODAL
				======================================-->

				<div class="modal-header" style="background:#3c8dbc; color:white">
					<h4 class="modal-title">CONTRATAR PLAN {{ membresia.MEMBRESIA_NOMBRE }}</h4>
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal"
						@click="resetMdlMembresia">
						&times;
					</button>
				</div>

				<!--=====================================
				CUERPO DEL MODAL
				======================================-->

				<form method="post" action="<?php echo base_url()?>pagos/pay" id="form-pagos">
				
					<div class="modal-body">
						
						<div class="p-3 mb-2 bg-secondary text-light">
							<h2 class="text-center">VALOR MENSUAL {{ membresia.MEMBRESIA_VALOR | formatoDinero }} + IVA </h2>
						</div>

						<div class="img-webpay d-flex justify-content-center mb-4">
							<img src="<?php echo base_url('public/images/img-webpay.png')?>" alt="" class="img-fluid" width="350">
						</div>
						
						<input type="hidden" name="cantMeses" :value=" cantMeses ">
						<input type="hidden" name="valor" :value=" membresia.MEMBRESIA_VALOR ">
						<input type="hidden" name="plan" :value=" membresia.MEMBRESIA_NOMBRE ">
						<input type="hidden" name="idMembresia" :value=" membresia.MEMBRESIA_ID ">

						<div class="form-group">              
							<div class="input-group">              
								<span class="input-group-addon"><i class="fa fa-plus"></i></span>
								<select class="form-control" id="select-dias" @change=" calcMembresia " v-model=" cantMeses ">
									<option value="0">SELECCIONAR MESES MEMBRESÍA (*)...</option>
									<option v-for="index in optItems" :key="index" :value=" index ">{{ index }}</option>
								</select>
							</div>
						</div>

						<div v-html=" htmlPorPagar "></div>

						<div class="form-group">
							<div class="input-group">					   
								<button 
									type="submit" 
									class="btn btn-lg btn-primary btn-block" 
									v-html=" btnMembresia.txt " 
									:disabled=" btnMembresia.disabled "
									@click="loadBtn()">
								</button>
							</div>
						</div>

					</div>

				</form> 

				<!--=====================================
				PIE DEL MODAL
				======================================-->

				<div class="modal-footer">
					<button 
						type="button" 
						class="btn btn-default pull-left" 
						data-dismiss="modal"
						@click="resetMdlMembresia">
						Salir
					</button>
				</div>

			</div>

		</div>

	</div>

</div>
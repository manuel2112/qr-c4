<div id="index" v-cloak>

	<div class="row">
		<div class="col-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><?php echo $this->session_nmb?></li>
					<li class="ml-auto"><a href="<?php echo base_url('home/help')?>" class="btn btn-outline-warning" target="_blank"><i class="fas fa-question"></i></a></li>
				</ol>			
			</nav>		
		</div>
	</div>

	<div v-html="msnMembresia"></div>

	<div class="text-center" v-if="msnMembresia">
		<a 
			href="<?php echo base_url()?>pagos" 
			class="btn btn-danger">
			<strong>
				RENOVAR MEMBRESÍA 
				<i class="fa fa-chevron-right"></i>
				<i class="fa fa-chevron-right"></i>
			</strong>
		</a>
	</div>

	<div class="row">
		<div class="col-md-6 offset-md-3">
			<img :src="qr" alt="" class="img-fluid my-5 w-100" />

			<div v-if=" empresa.EMPRESA_MEMBRESIA == 1 ">
			
				<a 
					href="<?php echo base_url()?>empresa"
					class="btn btn-primary btn-block btn-lg"
					v-if=" !empresa.EMPRESA_LOGOTIPO ">
					<strong>PERSONALIZA TU QR INGRESANDO<br> TU LOGOTIPO AQUI</strong>
				</a>

				<a 
					:href="qr" 
					target="_blank" 
					class="btn btn-primary btn-block btn-lg mt-4" 
					download>
					<strong>DESCARGA TU CÓDIGO QR AQUÍ</strong>
				</a>

			</div>

		</div>
	</div>

</div>
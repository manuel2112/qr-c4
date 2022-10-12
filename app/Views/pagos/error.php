<div class="row">
	<div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $this->session_nmb?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('pagos')?>">Centro de Pagos</a</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('pagos/miscompras')?>">Mis Compras</a></li>
                
				<li class="ml-auto"><a href="#" class="btn btn-outline-warning"><i class="fas fa-question"></i></a></li>
            </ol>
        </nav>		
	</div>
</div>

<div class="row">

    <div class="col-12">

        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;
            </button>
            <h4 class="text-center">SE HA PRODUCIDO UN ERROR,NO SE HAN REALIZADO CARGOS A SU TARJETA, FAVOR VOLVER A INTENTAR<br><a href="<?php echo base_url('pagos') ?>">VOLVER</a></h4>
        </div>

    </div>

</div>      
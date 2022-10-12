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

        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;
            </button>
            <h4 class="text-center">PAGO REALIZADO CON ÉXITO,<br> DESCARGA TU COMPROBANTE <a href="<?php echo base_url('recibo/cliente/'.$buyOrder)?>" target="_blank" >AQUÍ</a></h4>
        </div>

    </div>

</div>      
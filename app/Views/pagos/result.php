<?php 
	$this->extend('layouts/main');
	$session = session();
	$this->section('content')
?>

<div class="row">
	<div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $session->get('usuario')['nmbqrsession'] ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('pagos')?>">Centro de Pagos</a</li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('pagos/miscompras')?>">Mis Compras</a></li>
                
				<li class="ml-auto"><a href="#" class="btn btn-outline-warning"><i class="fas fa-question"></i></a></li>
            </ol>
        </nav>		
	</div>
</div>

<div class="row">

    <div class="col-12">
        
        <?php if( isset($token_ws) ){ ?>
            <?php if( $status == 'AUTHORIZED' ){ ?>
                <div class="col-12">
                    <div class="alert alert-success">
                        <h4 class="text-center">PAGO REALIZADO CON ÉXITO,<br> DESCARGA TU COMPROBANTE <a href="<?php echo base_url('recibo/cliente/'.$buyOrder)?>" target="_blank" >AQUÍ</a></h4>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong><h4 class="text-center">SE HA RECHAZADO TU COMPRA, NO SE HAN REALIZADO CARGOS A SU TARJETA, FAVOR VOLVER A INTENTAR<br>
                        <a href="<?php echo base_url('/pagos')?>">VOLVER</a></h4></strong>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <div class="col-12">
                <div class="alert alert-danger">
                    <strong><h4 class="text-center">SE HA PRODUCIDO UN ERROR,NO SE HAN REALIZADO CARGOS A SU TARJETA, FAVOR VOLVER A INTENTAR<br>
                    <a href="<?php echo base_url('/pagos')?>">VOLVER</a></h4></strong>
                </div>
            </div>                        
        <?php } ?>

    </div>

</div>

<?php $this->endSection() ?>
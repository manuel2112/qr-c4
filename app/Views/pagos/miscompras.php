<div class="row">
	<div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $this->session_nmb?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('pagos')?>">Centro de Pagos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mis Compras</li>

				<li class="ml-auto"><a href="#" class="btn btn-outline-warning"><i class="fas fa-question"></i></a></li>
            </ol>
        </nav>		
	</div>
</div>

<div class="row mb-2">

	<div class="col-12 mt-4" id="pagos">

        <h2 class="text-center">COMPRAS REALIZADAS</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-dark table-hover" id="tbl-compra" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ORDEN DE COMPRA</th>
                        <th scope="col">PLAN</th>
                        <th scope="col">CANTIDAD</th>
                        <th scope="col">TOTAL</th>
                        <th scope="col">FECHA</th>
                        <th scope="col">EXPORTAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if( $compras ){ ?>
                    <?php $i=1; ?>
                    <?php foreach( $compras as $compra ){ ?>
                    <tr>
                        <th scope="row"><?php echo $i++ ?></th>
                        <td><?php echo $compra->PAGO_ORDEN ?></td>
                        <td><?php echo $compra->MEMBRESIA_NOMBRE ?></td>
                        <td><?php echo $compra->PAGO_CANTIDAD ?></td>
                        <td><?php echo formatoDinero($compra->PAGO_TOTAL) ?></td>
                        <td><?php echo fechaLatinaSinHora($compra->PAGO_FECHA) ?></td>
                        <td><a href="<?php echo base_url('recibo/cliente/'.$compra->PAGO_ORDEN)?>" target="_blank" class="btn btn-primary"><i class="far fa-file-pdf"></i></a></td>
                    </tr>
                    <?php } ?>
                    <?php }else{ ?>
                    <tr>
                        <td colspan="5">AÚN NO HAS REALIZADO COMPRAS</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    


	</div>
</div><!-- FIN ROW PRINCIPAL -->
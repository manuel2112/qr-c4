<div id="index">

    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $this->session_nmb?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('pagos')?>">Centro de Pagos</a</li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('pagos/miscompras')?>">Mis Compras</a></li>
                    <li class="breadcrumb-item active">Pago</li>
                    
                    <li class="ml-auto"><a href="#" class="btn btn-outline-warning"><i class="fas fa-question"></i></a></li>
                </ol>
            </nav>		
        </div>
    </div>

    <div class="row" id="pay">

        <?php if( $error ){ ?>
        <div class="col-12">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;
                </button>
                <h4 class="text-center">SE HA PRODUCIDO UN ERROR, FAVOR VOLVER A INTENTAR<br><a href="<?php echo base_url('pagos') ?>">VOLVER</a></h4>
            </div>
        <?php }else{ ?>
            
            <div class="well col-12 col-sm-10 col-md-6 offset-sm-1 offset-md-3">
                <div class="row">
                    <div class="col-6 col-sm-6 col-md-6">
                        <address>
                            <strong>FACILBAK QR</strong>
                        </address>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em>FECHA: <?php echo fechaNowTxt(); ?></em>
                        </p>
                        <p>
                            <em>N° ORDEN: <?php echo $buyOrder; ?></em>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <h1>PLAN A CONTRATAR</h1>
                    </div>
                    </span>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>PLAN</th>
                                <th>MESES</th>
                                <th class="text-center">VALOR</th>
                                <th class="text-center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-md-9"><em><?php echo $plan ?></em></h4></td>
                                <td class="col-md-1" style="text-align: center"> <?php echo $meses ?> </td>
                                <td class="col-md-1 text-center"><?php echo formatoDinero($valor) ?></td>
                                <td class="col-md-1 text-right"><?php echo formatoDinero($neto) ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="text-right">
                                <p>
                                    <strong>SUBTOTAL: </strong>
                                </p>
                                <p>
                                    <strong>IVA: </strong>
                                </p></td>
                                <td class="text-right">
                                <p>
                                    <strong><?php echo formatoDinero($neto) ?></strong>
                                </p>
                                <p>
                                    <strong><?php echo formatoDinero($iva) ?></strong>
                                </p></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="text-right"><h4><strong>TOTAL: </strong></h4></td>
                                <td class="text-right text-danger"><h4><strong><?php echo formatoDinero($total) ?></strong></h4></td>
                            </tr>
                        </tbody>
                    </table>

                    <form action="<?php echo $formAction ?>" method="POST" style="width:100%">
                        <input type="hidden" name="token_ws" value="<?php echo $tokenWs ?>">
                        <button type="submit" class="btn btn-success btn-lg btn-block">
                            PAGAR AHORA <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
                        </button>
                    </form>
                    
                </div>
            </div>
        
        <?php } ?>
        </div>

    </div>

</div>




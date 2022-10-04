<?php $v = time();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $this->layout->getTitle(); ?></title>
    <meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>"  />
    <meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />    

    <link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.css')?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url('public/css/style.css?v='.$v)?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/responsive.css?v='.$v)?>">

	<link rel="stylesheet" href="<?php echo base_url('public/plugins/fileinput/css/fileinput.css')?>">
	<link rel="stylesheet" href="<?php echo base_url('public/plugins/Jcrop/jquery.Jcrop.min.css')?>">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

	<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
</head>

<body>

	<div class="container-fluid">
        <div class="row">
        	<div class="barra-lateral col-12 col-sm-auto">
            	<div class="logo mx-auto text-center">
                	<a href="<?php echo base_url()?>" title="INICIO"><img src="<?php echo imgLogo()?>" alt="" class="img-fluid logo" ></a>
                </div>
				<div id = "clockDiv" class="text-center my-2">
					{{ timestamp }}
				</div>
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">

					<?php if( $this->isadminqrsession ){ ?>

						<a href="<?php echo base_url()?>admin" title="ADMINISTRADOR" class="<?php echo $this->uri->segment(1) == 'admin' ? 'active' : '' ;?>"><i class="fa fa-lock"></i> <span>ADMINISTRADOR</span></a>

						<a href="<?php echo base_url()?>gestion" title="GESTIÓN" class="<?php echo $this->uri->segment(1) == 'gestion' ? 'active' : '' ;?>"><i class="fa fa-cogs"></i> <span>GESTIÓN</span></a>

						<?php if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ){ ?>						
							<a href="<?php echo base_url()?>mailing" title="MAILING" class="<?php echo $this->uri->segment(1) == 'mailing' ? 'active' : '' ;?>"><i class="fa fa-object-group"></i> <span>MAILING</span></a>
						<?php } ?>

					<?php } ?>

               		<!--SESION CLIENTE-->
                	<?php if( $this->session_id ){?>
                	
                		<a href="<?php echo base_url()?>home" title="INICIO" class="<?php echo $this->uri->segment(1) == 'home' ? 'active' : '' ;?>"><i class="fa fa-home"></i> <span>INICIO</span></a>
                		
						<a href="<?php echo base_url()?>empresa" title="MIS DATOS" class="<?php echo $this->uri->segment(1) == 'empresa' ? 'active' : '' ;?>"><i class="fas fa-cog"></i> <span>MIS DATOS</span></a>

						<a href="<?php echo base_url()?>tipospago" title="TIPOS DE PAGO" class="<?php echo $this->uri->segment(1) == 'tipospago' ? 'active' : '' ;?>"><i class="fa fa-shopping-cart"></i> <span>TIPOS DE PAGO</span></a>

						<a href="<?php echo base_url()?>menu" title="MENÚ" class="<?php echo $this->uri->segment(1) == 'menu' ? 'active' : '' ;?>"><i class="fas fa-bars"></i> <span>MENÚ</span></a>
						
						<a href="<?php echo base_url()?>pagos" title="CENTRO DE PAGOS" class="<?php echo $this->uri->segment(1) == 'pagos' ? 'active' : '' ;?>"><i class="far fa-credit-card"></i> <span>CENTRO DE PAGOS</span></a>
						
						<a href="<?php echo base_url()?>contacto" title="CONTACTO" class="<?php echo $this->uri->segment(1) == 'contacto' ? 'active' : '' ;?>"><i class="fas fa-envelope"></i> <span>CONTACTO</span></a>

					<?php } ?>
                	
                	<a href="<?php echo base_url()?>login/logout" title="SALIR"><i class="fas fa-sign-out-alt"></i> <span>SALIR</span></a>
                </nav>
            </div>
            
            <main class="col">
            	<div class="row">
                	<div class="columna col-lg-12">
                    	<div class="widget">
                            <?php echo $content_for_layout;?>
                        </div>
                    </div>
                </div>
            </main>
            
        </div>
    </div>
  

	<script type="text/javascript">
		var base_url		= '<?php echo base_url();?>';
		Vue.prototype.$http = axios
	</script>
	<script src="<?php echo base_url('public/js/jquery.min.js')?>"></script>
	<script src="<?php echo base_url('public/js/popper.min.js')?>"></script>
	<script src="<?php echo base_url('public/js/bootstrap.min.js')?>"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="<?php echo base_url('public/js/fileinput.min.js')?>"></script>
	<script src="<?php echo base_url('public/plugins/fileinput/js/locales/es.js')?>"></script>
	<script src="<?php echo base_url('public/plugins/fileinput/js/theme.js')?>"></script>
	<script src="<?php echo base_url('public/plugins/fileinput/themes/explorer-fas/theme.js')?>"></script>
	<script src="<?php echo base_url('public/plugins/Jcrop/jquery.Jcrop.min.js')?>"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/2.1.0/bootstrap-filestyle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/jitbit/HtmlSanitizer@master/HtmlSanitizer.js"></script>
	
	<script src="<?php echo base_url('public/js/functions/function.fecha.js?v='.$v)?>"></script>
	<script src="<?php echo base_url('public/js/functions/function.custom.js?v='.$v)?>"></script>
	<script src="<?php echo base_url('public/js/functions/function.vue.filters.js')?>"></script>

	<?php $segmento = $this->uri->segment(1) ?>

	<?php if( $segmento == 'admin' ){ ?>
		<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.7.0/Sortable.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.16.0/vuedraggable.min.js"></script>
		<script src="<?php echo base_url('public/validate/validate.admin.js?v='.$v)?>"></script>
	<?php } ?>
	
	<?php if( $segmento == 'gestion' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.gestion.js?v='.$v)?>"></script>
	<?php } ?>

	<?php if( $segmento == 'mailing' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.mailing.js?v='.$v)?>"></script>
	<?php } ?>
	
	<?php if( $segmento == 'home' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.home.js?v='.$v)?>"></script>
	<?php } ?>
	
	<?php if( $segmento == 'empresa' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.empresa.js?v='.$v)?>"></script>
	<?php } ?>
	
	<?php if( $segmento == 'tipospago' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.tipospago.js?v='.$v)?>"></script>
	<?php } ?>

	<?php if( $segmento == 'menu' ){ ?>
		<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.7.0/Sortable.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.16.0/vuedraggable.min.js"></script>
		<script src="<?php echo base_url('public/validate/validate.menu.js?v='.$v)?>"></script>
	<?php } ?>

	<?php if( $segmento == 'pagos' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.pagos.js?v='.$v)?>"></script>
	<?php } ?>
	
	<?php if( $segmento == 'contacto' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.contacto.js?v='.$v)?>"></script>
	<?php } ?>
	
	<?php if( $segmento == 'test' ){ ?>
		<script src="<?php echo base_url('public/validate/validate.test.js?v='.$v)?>"></script>
	<?php } ?>

</body>
</html>
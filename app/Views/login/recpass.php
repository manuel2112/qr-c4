<?php $v = time();?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $this->layout->getTitle(); ?></title>
    <meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>"  />
    <meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
    
    <link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url('public/css/style_login.css?v='.$v)?>">

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
</head>

<body>

    <div id="login">

        <div class="container-fluid">
            <div class="row">                    
                <div class="col col-md-6 offset-md-3">
                            
                    <div class="mx-auto text-center">
                        <a href="<?php echo base_url()?>" title="PORTADA">
                            <img src="<?php echo imgLogo()?>" alt="" class="img-fluid logo" width="200">
                        </a>
                    </div>

                    <h1>Nueva Contraseña</h1>
                                
                    <form @submit.prevent="sendNewPass">
            
                        <div class="form-group">
                            <small class="text-danger">{{ passError.pass }}</small>
                            <div class="input-group" id="pass01">
                                <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                <input 
                                    type="password" 
                                    class="form-control form-control-lg"                  
                                    placeholder="CONTRASEÑA..."
                                    v-model.trim=" pass.pass01 "
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
                                    placeholder="REPETIR CONTRASEÑA..."
                                    v-model.trim=" pass.pass02 "
                                    @input=" validarPass ">
                                <div class="input-group-addon">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>                 
                                            
                        <button 
                            type="submit" 
                            class="btn btn-lg btn-primary btn-block btnlogin"
                            v-html=" btnPass.txt "
                            :disabled=" btnPass.disabled ">
                        </button>
                                            
                    </form>
                                    
                </div>              
            </div>
        </div>

    </div><!-- FIN LOGIN -->

    <script type="text/javascript">
        var base_url	    = '<?php echo base_url();?>';
        Vue.prototype.$http = axios
    </script>
    <script src="<?php echo base_url('public/js/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('public/js/popper.min.js')?>"></script>
    <script src="<?php echo base_url('public/js/bootstrap.min.js')?>"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('public/js/functions/function.custom.js?v='.$v)?>"></script>
    <script src="<?php echo base_url('public/validate/validate.login.js?v='.$v)?>"></script>
</body>
</html>
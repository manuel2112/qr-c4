<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $this->layout->getTitle();?> >> 404 </title>    
    <link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.min.css')?>">
</head>

<body>

    <div class="container-fluid">
        <div class="row">              
            <div class="col col-md-6 offset-md-3">
                <div class="mx-auto text-center">
                    <img src="<?php echo base_url('public/images/logo.png')?>" alt="" class="img-fluid" width="200"> <br>
                    <img src="<?php echo base_url('public/images/404.png')?>" alt="" class="img-fluid"> <br>

                    <h1 class="mt-3">SE HA PRODUCIDO UN ERROR <br>
                        <a href="<?php echo base_url(); ?>">VOLVER A LA PORTADA</a>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
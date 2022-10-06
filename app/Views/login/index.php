<?php $v = time();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo title() ?></title>
    
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
                <img src="<?php echo imgLogo()?>" alt="" class="img-fluid logo" >
              </div>

                <?php 
                  if( $registro )
                  {
                    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><h2>HAS VALIDADO TU REGISTRO EXITOSAMENTE, INGRESA TU USUARIO Y CONTRASEÑA PARA GESTIONAR TU MENÚ Y OBTENER TU CÓDIGO QR.</h2></div>';
                  }
                ?>
              
                <form @submit.prevent="sendLogin">

                  <?php echo form_input(array('type'=>'email','placeholder'=>'EMAIL...','class'=>'form-control form-control-lg','required'=>'required','v-model'=>'login.user', 'autocomplete'=>'off', '@input'=>'validateLogin')) ?>
            
                  <?php echo form_input(array('type'=>'password','placeholder'=>'CONTRASEÑA...','class'=>'form-control form-control-lg','required'=>'required','v-model'=>'login.pass', 'autocomplete'=>'off', '@input'=>'validateLogin')) ?>                  
                    
                  <button 
                    type="submit" 
                    class="btn btn-lg btn-primary btn-block btnlogin"
                    v-html=" btnLogin.txt "
                    :disabled=" btnLogin.disabled ">
                  </button>
                        
                </form>
                        
                <div class="d-flex justify-content-center mt-5">
                  <a href="#" class="btn" data-toggle="modal" data-target="#mdlContacto">Problemas para ingresar? Contáctanos aquí</a>
                </div>
                <div class="d-flex justify-content-center mt-3">
                  <a href="#" class="btn" data-toggle="modal" data-target="#mdlPassForget">Olvidaste tu contraseña?</a>
                </div>
                <div class="d-flex justify-content-center mt-5">
                  <a href="#" class="btn btn-primary registro" data-toggle="modal" data-target="#mdlRegistro" id="mdlRegistroOpen">REGISTRARME</a>
                </div>
                      
            </div>
              
          </div>
      </div>
      
<!--=====================================
MODAL CONTACTO
======================================-->
  <div id="mdlContacto" class="modal fade" role="dialog" data-backdrop="static">  
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent=" sendContacto ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header color-modal-header">
            <h4 class="modal-title">CUÉNTANOS CUÁL ES TU PROBLEMA</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal">
            &times;
            </button>
          </div>

          <!--=====================================
          CUERPO DEL MODAL
          ======================================-->

          <div class="modal-body">			

            <div class="form-group">
              <small class="text-danger">{{ contactoError.nombre }}</small>            
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-plus"></i></span> 
                <input 
                  type="text" 
                  class="form-control" 
                  placeholder="NOMBRE..."
                  v-model.trim=" contacto.nombre "
                  @input="validarContactoNombre">
              </div>
            </div>			

            <div class="form-group">
              <small class="text-danger">{{ contactoError.email }}</small> 
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                <input 
                  type="email" 
                  class="form-control"
                  placeholder="EMAIL..."
                  v-model.trim=" contacto.email "
                  @input="validarContactoEmail">
              </div>
            </div>
                          
            <div class="form-group">
              <small class="text-danger">{{ contactoError.mensaje }}</small> 
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                <textarea 
                  class="form-control"
                  rows="3" 
                  placeholder="INGRESAR PROBLEMA..."
                  v-model.trim=" contacto.mensaje "
                  @input="validarContactoMensaje">
                </textarea>
              </div>
            </div>
                          
            <div class="form-group">
              <div class="input-group">
                <button
                  type="submit" 
                  class="btn btn-lg btn-primary btn-block"
                  v-html=" btnContacto.txt "
                  :disabled=" btnContacto.disabled ">
                </button>
              </div>
            </div>
                      
          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->

          <div class="modal-footer">
            <button 
              type="button" 
              class="btn btn-default pull-left" 
              data-dismiss="modal">
            Salir
            </button>
          </div>

        </form> 

      </div>

    </div>

  </div>   
      
<!--=====================================
MODAL RECUPERAR CONTRASEÑA
======================================-->
    <div id="mdlPassForget" class="modal fade" role="dialog" data-backdrop="static">  
      <div class="modal-dialog">
        <div class="modal-content">
          <form @submit.prevent=" recuperarPass ">

            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->

            <div class="modal-header color-modal-header">
              <h4 class="modal-title">Recupera tu contraseña</h4>
              <button 
                type="button" 
                class="close" 
                data-dismiss="modal">
                &times;
              </button>
            </div>

            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->

            <div class="modal-body">		

              <div class="form-group">
                <small class="text-danger">{{ recuperarError.email }}</small> 
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                  <input 
                    type="email" 
                    class="form-control"
                    placeholder="EMAIL..."
                    v-model.trim=" recuperar.email "
                    @input="validarRecuperarEmail">
                </div>
              </div>
                          
              <div class="form-group">
                <div class="input-group">
                  <button
                    type="submit" 
                    class="btn btn-lg btn-primary btn-block"
                    v-html=" btnRecuperar.txt "
                    :disabled=" btnRecuperar.disabled ">
                  </button>
                </div>
              </div>
                          
            </div>

            <!--=====================================
            PIE DEL MODAL
            ======================================-->

            <div class="modal-footer">
              <button 
                type="button" 
                class="btn btn-default pull-left" 
                data-dismiss="modal">
                Salir                
              </button>
            </div>

          </form> 

        </div>

      </div>

    </div>

  </div><!-- FIN LOGIN -->

<!--=====================================
MODAL REGISTRO
======================================-->
<div id="app">
  <div id="mdlRegistro" class="modal fade" role="dialog" data-backdrop="static">  
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" sendRegistro() ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header color-modal-header">
            <h4 class="modal-title">Registro</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!--=====================================
          CUERPO DEL MODAL
          ======================================-->

          <div class="modal-body">		

            <div class="form-group">
              <small class="text-danger">{{ error.nombre }}</small>
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-home"></i></span> 
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  placeholder="NOMBRE DE TU EMPRESA..."
                  v-model.trim=" registro.nombre "
                  @input=" validarNombre ">
              </div>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  placeholder="NOMBRE RESPONSABLE..."
                  v-model.trim=" registro.responsable "
                  @input=" validarResponsable ">
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span> 
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  placeholder="DIRECCIÓN DE TU EMPRESA (OPCIONAL)..."
                  v-model.trim=" registro.direccion "
                  @input="validarDireccion">
              </div>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-map-marker"></i></span> 
                <select 
                  class="form-control form-control-lg"
                  @change="getCiudad()"
                  v-model.trim=" region ">
                  
                  <option value=""> REGIÓN DE TU EMPRESA...</option>
                  <?php
                    foreach( $regiones as $region ){
                      echo '<option value="'.$region->id.'">'.$region->region.'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <small class="text-danger">{{ error.ciudad }}</small>
              <small class="text-danger" v-html=" loadingCity "></small>
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-map-marker"></i></span> 
                <select 
                  class="form-control form-control-lg"
                  v-model.trim=" registro.ciudad "
                  @change=" validarCiudad "
                  :disabled=" dsbCiudad ">
                  
                  <option value=""> CIUDAD DE TU EMPRESA...</option>
                  <option v-for=" city in ciudades " :key=" city.id " :value=" city.id ">{{ city.comuna }}</option>
                </select>
              </div>
            </div>
                      
            <div class="form-group">
              <small class="text-danger">{{ error.fono }}</small>
              <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-phone"></i></span> 
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  placeholder="N° CELULAR DE TU EMPRESA..."
                  v-model.trim=" registro.fono "
                  @input=" validarFono ">
              </div>
            </div>
            
            <div class="form-group">
              <small class="text-danger">{{ error.email }}</small>
              <small class="text-danger" v-html=" loadingMail "></small>
              <div class="input-group">
                <span class="input-group-addon"><i class="far fa-envelope"></i></span> 
                <input 
                  type="email" 
                  class="form-control form-control-lg" 
                  placeholder="EMAIL..."
                  v-model.trim=" registro.email "
                  @input=" validarEmail ">
              </div>
            </div>
            
            <div class="form-group">
              <small class="text-danger">{{ error.pass }}</small>
              <div class="input-group" id="pass01">
                <span class="input-group-addon"><i class="fas fa-key"></i></span>
                <input 
                  type="password" 
                  class="form-control form-control-lg"                  
                  placeholder="CONTRASEÑA..."
                  v-model.trim=" registro.pass01 "
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
                  v-model.trim=" registro.pass02 "
                  @input=" validarPass ">
                  <div class="input-group-addon">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
              </div>
            </div>
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-comments"></i></span> 
                <select 
                  class="form-control form-control-lg"
                  v-model.trim=" referido "
                  @change=" validarReferido ">
                  
                  <option value=""> CUÉNTANOS CÓMO NOS CONOCISTE...</option>
                  <option v-for=" ref in referidos " :key=" ref " :value=" ref ">{{ ref.value }}</option>
                </select>
              </div>
            </div>

            <div class="form-group" v-if=" referido.bool ">
              <small class="text-danger">{{ error.referido }}</small>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user-circle"></i></span> 
                <input 
                  type="text" 
                  class="form-control form-control-lg" 
                  placeholder="¿QUIEN TE INVITÓ A INGRESAR?"
                  v-model.trim=" referido.nombre "
                  @input=" validarReferido ">
              </div>
            </div>
            
            
            <div class="form-group">
              <div class="input-group">					   
                <button 
                  :type=" btnRegistro.disabled ? 'button' : 'submit' " 
                  class="btn btn-lg btn-primary btn-block"
                  v-html=" btnRegistro.txt "
                  :disabled=" btnRegistro.disabled ">
                </button>
              </div>
            </div>
              
          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          </div>

        </form> 

      </div>

    </div>

  </div>
</div>

  <script type="text/javascript">
    var base_url	= '<?php echo base_url();?>/';
    Vue.prototype.$http = axios
  </script>
  <script src="<?php echo base_url('public/js/jquery.min.js')?>"></script>
  <script src="<?php echo base_url('public/js/popper.min.js')?>"></script>
  <script src="<?php echo base_url('public/js/bootstrap.min.js')?>"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="<?php echo base_url('public/js/functions/function.custom.js?v='.$v)?>"></script>
  <script src="<?php echo base_url('public/validate/validate.login.js?v='.$v)?>"></script>
  <script src="<?php echo base_url('public/validate/validate.registro.js?v='.$v)?>"></script>
</body>
</html>
<?php 
	$this->extend('layouts/main');
	$session = session();
	$this->section('content')
?>

<div id="app" v-cloak>

  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $session->get('usuario')['nmbqrsession'] ?></a></li>
          <li class="breadcrumb-item active">Gestión</li>
        </ol>
      </nav>		
    </div>
  </div>

  <div class="row mb-2">

    <div class="col-12">

      <fieldset class="scheduler-border">
        <legend class="scheduler-border">PARAMETROS</legend>
        
        <table class="table">
          <tr>
            <td class="table-primary w-25">IVA</td>
            <td>
              {{ parametros.PARAMETRO_IVA }}
            </td>
          </tr>
          <tr>
            <td class="table-primary">ZONA HORARIA</td>
            <td>
              {{ parametros.PARAMETRO_ZONA_HORARIA }}
            </td>
          </tr>
          <tr>
            <td class="table-primary">TRANSBANK</td>
            <td>
              {{ parametros.PARAMETRO_TRANSBANK == 1 ? 'PRODUCCIÓN' : 'DESARROLLO' }}              
            </td>
          </tr>
        </table>

        <button 
          class="btn btn-warning" 
					data-toggle="modal" 
					data-target="#modalEditarParametros">
          <strong>EDITAR PARAMETROS</strong>
        </button>

      </fieldset>
		
      <fieldset class="scheduler-border">
        <legend class="scheduler-border">CRON</legend>

        <div class="btn-group">
          <a href="<?php echo base_url('public/upload/txt/buy/')?>" class="btn btn-info" target="_blank">LOGS PAGOS</a>
          <a href="<?php echo base_url('public/upload/txt/cron/cron_membresia.txt')?>" class="btn btn-info" target="_blank">TXT MEMBRESÍAS</a>
          <a href="<?php echo base_url('public/upload/txt/cron/cron_test.txt')?>" class="btn btn-info" target="_blank">TXT TEST</a>
          <button 
            class="btn btn-danger"
            @click=" ejecutarCron ">
            <strong>EJECUTAR</strong>
          </button>
        </div>
      </fieldset>

    </div>

  </div><!-- FIN ROW PRINCIPAL -->

  <!--=====================================
  MODAL EDITAR PARAMETROS
  ======================================-->
  <div id="modalEditarParametros" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" editParametros ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">
              EDITAR DATOS DE LA PARAMETROS
            </h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="mdlReset">
              &times;
            </button>
          </div>

          <!--=====================================
          CUERPO DEL MODAL
          ======================================-->
        
          <div class="modal-body">
            
            <div class="row">
            
              <div class="col-12">
                
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    <input 
                      type="number" 
                      class="form-control form-control-lg"
                      placeholder="IVA (*)..." 
                      v-model.trim =" editParam.PARAMETRO_IVA "
                      :value=" editParam.PARAMETRO_IVA "
                      @input="validarIva"
                      required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <h4>ZONA HORARIA</h4>							
                  </div>
                  <div class="col-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label 
                        class="btn reset" 
                        :class=" editParam.PARAMETRO_ZONA_HORARIA == 'America/Santiago' ? 'btn-success' : 'btn-outline-success' " @click=" validarZona('America/Santiago') ">
                        <input 
                          type="radio" 
                          value="America/Santiago" 
                          v-model="editParam.PARAMETRO_ZONA_HORARIA"> 
                          America/Santiago
                      </label>
                      <label 
                        class="btn reset" 
                        :class=" editParam.PARAMETRO_ZONA_HORARIA == 'America/New_York' ? 'btn-success' : 'btn-outline-success' " @click=" validarZona('America/New_York') ">
                        <input 
                          type="radio" 
                          value="America/New_York"
                          v-model="editParam.PARAMETRO_ZONA_HORARIA"> 
                          America/New_York
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <h4>TRANSBANK</h4>							
                  </div>
                  <div class="col-12">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label 
                        class="btn reset" 
                        :class=" editParam.PARAMETRO_TRANSBANK == 1 ? 'btn-success' : 'btn-outline-success' " @click=" validarTransbank(1) ">
                        <input 
                          type="radio" 
                          value="editParam.PARAMETRO_TRANSBANK" 
                          v-model="editParam.PARAMETRO_TRANSBANK"> 
                          PRODUCCIÓN
                      </label>
                      <label 
                        class="btn reset" 
                        :class=" editParam.PARAMETRO_TRANSBANK == 0 ? 'btn-success' : 'btn-outline-success' " @click=" validarTransbank(0) ">
                        <input 
                          type="radio" 
                          value="editParam.PARAMETRO_TRANSBANK"
                          v-model="editParam.PARAMETRO_TRANSBANK"> 
                          DESARROLLO
                      </label>
                    </div>
                  </div>
                </div>
                
              </div>
              
            </div><!-- PIE ROW -->

          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->

          <div class="modal-footer">
            <button 
              type="button" 
              class="btn btn-default pull-left" 
              data-dismiss="modal"
              @click="mdlReset">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnEditar.txt " 
              :disabled=" btnEditar.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<?php $this->endSection() ?>
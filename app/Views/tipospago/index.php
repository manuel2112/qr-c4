<div id="app" v-cloak>

  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $this->session_nmb?></a></li>
          <li class="breadcrumb-item active">Tipos de Pago</li>
        </ol>
      </nav>		
    </div>
  </div>

  <div class="row mb-2">

    <div class="col-12">		
      <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ empresaPago ? 'LA PLATAFORMA DE PAGO ESTÁ ACTIVADA' :  'LA PLATAFORMA DE PAGO ESTÁ DESACTIVADA'}}</legend>

        <div class="btn-group">
          <button 
            v-if=" !empresaPago "
            class="btn btn-info"
            @click="accionPago(true)">
            <strong>ACTIVAR</strong>
          </button>
          <button 
            v-else
            class="btn btn-danger"
            @click="accionPago(false)">
            <strong>DESACTIVAR</strong>
          </button>
        </div>
      </fieldset>      
    </div>

    <div class="col-12">

      <h5>TIPOS DE ENTREGA</h5>

      <div 
        class="card mb-2" 
        v-for=" e in tiposEntrega " 
        :style=" e.TIPO_ENTREGA_EMPRESA_FLAG == 1 ? { 'background-color': '#a3cfbb' } : { 'background-color': '#f1aeb5' }">
        <div class="card-body">
          <h5 class="card-title">{{ e.TIPO_ENTREGA_NMB }}</h5>
          <p class="card-text">{{ e.TIPO_ENTREGA_EMPRESA_DETALLE ? e.TIPO_ENTREGA_EMPRESA_DETALLE : e.TIPO_ENTREGA_DESC }}</p>
          <button 
            type="button" 
            class="btn"
            :class=" e.TIPO_ENTREGA_EMPRESA_FLAG == 0 ? 'btn-success' : 'btn-danger' "
            @click="accionTipo(e.TIPO_ENTREGA_EMPRESA_ID,e.TIPO_ENTREGA_EMPRESA_FLAG,e.TIPO_ENTREGA_NMB,1)">
            {{ e.TIPO_ENTREGA_EMPRESA_FLAG == 0 ? 'ACTIVAR' : 'DESACTIVAR' }}
          </button>
          <button 
            type="button" 
            class="btn btn-info"
            @click="instanciarModalInfo(e.TIPO_ENTREGA_EMPRESA_ID,e.TIPO_ENTREGA_NMB,e.TIPO_ENTREGA_DESC,e.TIPO_ENTREGA_EMPRESA_DETALLE,1)">
            INFORMACIÓN
          </button>
        </div>
      </div>

    </div>

    <div class="col-12 mt-5">

      <h5>TIPOS DE PAGO</h5>

      <div 
        class="card mb-2" 
        v-for=" p in tiposPago " 
        :style=" p.TIPO_PAGO_EMPRESA_FLAG == 1 ? { 'background-color': '#a3cfbb' } : { 'background-color': '#f1aeb5' }">
        <div class="card-body">
          <h5 class="card-title">{{ p.TIPO_PAGO_NMB }}</h5>
          <p class="card-text" v-html=" p.TIPO_PAGO_EMPRESA_DETALLE ? nl2br(p.TIPO_PAGO_EMPRESA_DETALLE) : p.TIPO_PAGO_DESC "></p>
          <button 
            type="button" 
            class="btn"
            :class=" p.TIPO_PAGO_EMPRESA_FLAG == 0 ? 'btn-success' : 'btn-danger' "
            @click="accionTipo(p.TIPO_PAGO_EMPRESA_ID,p.TIPO_PAGO_EMPRESA_FLAG,p.TIPO_PAGO_NMB,2)">
            {{ p.TIPO_PAGO_EMPRESA_FLAG == 0 ? 'ACTIVAR' : 'DESACTIVAR' }}
          </button>
          <button 
            type="button" 
            class="btn btn-info"
            @click="instanciarModalInfo(p.TIPO_PAGO_EMPRESA_ID ,p.TIPO_PAGO_NMB,p.TIPO_PAGO_DESC,p.TIPO_PAGO_EMPRESA_DETALLE,2)">
            INFORMACIÓN
          </button>
        </div>
      </div>

    </div>

  </div><!-- FIN ROW PRINCIPAL -->

  <!--=====================================
  MODAL INFORMACIÓN
  ======================================-->
  <div id="modalInfo" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" accionInfo ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">
              {{ info.nombre }}<br>
              <small>{{ info.desc }}</small>
            </h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="infoReset">
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
                    <textarea 
                      class="form-control form-control-lg"
                      placeholder="INFORMACIÓN (*)..." 
                      v-model.trim =" info.info "
                      @input="validateInfo"
                      rows="3">
                      {{ info.info }}
                    </textarea>
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
              @click="infoReset">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnInfo.txt " 
              :disabled=" btnInfo.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

</div>
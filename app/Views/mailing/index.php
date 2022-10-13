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
          <li class="breadcrumb-item active">Mailing</li>
        </ol>
      </nav>		
    </div>
  </div>

  <div class="row mb-2">

    <div class="col-12">

      <fieldset class="scheduler-border">
        <legend class="scheduler-border">RESÚMEN</legend>
        
        <table class="table">
          <tr>
            <td class="table-primary w-25">TOTAL</td>
            <td>
              {{ resumen.total }}
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25"><?php echo nmbEstado(1) ?></td>
            <td>
              {{ resumen.activo }}
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25"><?php echo nmbEstado(2) ?></td>
            <td>
              <button
                type="button"
                class="btn btn-outline-primary"
                data-toggle="modal" 
                data-target="#mdlGetGrupoStatus"
                title="GRUPO STATUS"
                @click="getGrupoStatus(2)">
                {{ resumen.listaNegra }}
              </button>
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25"><?php echo nmbEstado(3) ?></td>
            <td>
              <button
                type="button"
                class="btn btn-outline-primary"
                data-toggle="modal" 
                data-target="#mdlGetGrupoStatus"
                title="GRUPO STATUS"
                @click="getGrupoStatus(3)">
                {{ resumen.rebotado }}
              </button>
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25"><?php echo nmbEstado(4) ?></td>
            <td>
              <button
                type="button"
                class="btn btn-outline-primary"
                data-toggle="modal" 
                data-target="#mdlGetGrupoStatus"
                title="GRUPO STATUS"
                @click="getGrupoStatus(4)">
                {{ resumen.inactivo }}
              </button>
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25"><?php echo nmbEstado(5) ?></td>
            <td>
              <button
                type="button"
                class="btn btn-outline-primary"
                data-toggle="modal" 
                data-target="#mdlGetGrupoStatus"
                title="GRUPO STATUS"
                @click="getGrupoStatus(5)">
                {{ resumen.spam }}
              </button>
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25"><?php echo nmbEstado(6) ?></td>
            <td>
              <button
                type="button"
                class="btn btn-outline-primary"
                data-toggle="modal" 
                data-target="#mdlGetGrupoStatus"
                title="GRUPO STATUS"
                @click="getGrupoStatus(6)">
                {{ resumen.baja }}
              </button>
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25">MAILRELAY</td>
            <td>
              {{ resumen.mailrelaey }}
            </td>
          </tr>
          <tr>
            <td class="table-primary w-25">NO MAILRELAY</td>
            <td>
              {{ resumen.nomailrelaey }}
            </td>
          </tr>
        </table>

        <div class="btn-group my-3">

          <button 
            type="button" 
            class="btn btn-outline-primary" 
            data-toggle="modal" 
            data-target="#modalInsertEmail"
            title="AGREGAR CORREO"
            @click="resetVariables">
            AGREGAR CORREO
          </button>

          <button 
            type="button" 
            class="btn btn-outline-primary" 
            data-toggle="modal" 
            data-target="#mdlInsertGrupo"
            title="AGREGAR GRUPO"
            @click="resetVariables">
            AGREGAR GRUPO
          </button>

          <button 
            type="button" 
            class="btn btn-outline-primary" 
            data-toggle="modal" 
            data-target="#modalSearchEmail"
            title="BUSCAR CORREO">
            BUSCAR CORREO
          </button>

          <button 
            type="button" 
            class="btn btn-outline-primary" 
            data-toggle="modal" 
            data-target="#mdlSearchGrupo"
            title="BUSCAR GRUPO">
            BUSCAR GRUPO
          </button>

          <button 
            type="button" 
            class="btn btn-outline-primary" 
            data-toggle="modal" 
            data-target="#mdlEstado"
            title="CAMBIAR ESTADOS">
            CAMBIAR ESTADOS
          </button>

          <button 
            type="button" 
            class="btn btn-outline-primary" 
            data-toggle="modal" 
            data-target="#mdlSearchTexto"
            title="BUSQUEDA POR TEXTO">
            BUSQUEDA POR TEXTO
          </button>

        </div>

      </fieldset>

    </div>

  </div><!-- FIN ROW PRINCIPAL -->

  <button type="button" class="btn btn-primary btn-block" @click="executeAutomated">AUTOMATIZAR</button>

  <div class="progress mt-5" style="height: 30px;" v-if="isInitAutomated">
    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" id="progress-bar" aria-valuemin="0" aria-valuemax="100"></div>
  </div>

  <div v-if="msnAutomated">
    <div class="alert alert-success mt-4" v-html="msnAutomated" role="alert"></div>
    <button type="button" class="btn btn-danger btn-block" @click="stopExecuteAutomated">DETENER</button>
  </div>
    

  <!--=====================================
  MODAL INSERT EMAIL
  ======================================-->
  <div id="modalInsertEmail" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" insertEmail ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">INGRESAR EMAIL</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="resetVariables">
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
                  <small class="text-danger">{{ error.emailIns }}</small>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                    <input 
                    type="text" 
                    class="form-control form-control-lg"                  
                    placeholder="INGRESAR EMAIL..."
                    v-model.trim=" emailIns "
                    @input=" validarEmail "
                    autofocus>
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
              @click="resetVariables">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnEmail.txt " 
              :disabled=" btnEmail.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

  <!--=====================================
  MODAL INSERT GROUP
  ======================================-->
  <div id="mdlInsertGrupo" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" insertGrupo ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">INGRESAR GRUPO</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="resetVariables">
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
                    class="form-control" 
                    rows="30" 
                    placeholder="INGRESAR GRUPO..."
                    v-model.trim=" grupoIns "
                    @input=" validateGrupo "
                    autofocus
                    required>
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
              @click="resetVariables">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnGrupo.txt " 
              :disabled=" btnGrupo.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

  <!--=====================================
  MODAL SEARCH EMAIL
  ======================================-->
  <div id="modalSearchEmail" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" searchEmail ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">BUSCAR EMAIL</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="resetVariables">
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
                  <small class="text-danger">{{ error.emailIns }}</small>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                    <input 
                    type="email" 
                    class="form-control form-control-lg"                  
                    placeholder="INGRESAR EMAIL..."
                    v-model.trim=" emailIns "
                    @input=" validarEmail "
                    autofocus>
                  </div>
                </div>

                <table class="table table-success" v-if="searchResp">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">EMAIL</th>
                      <th scope="col">ESTADO</th>
                      <th scope="col">ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">{{ searchResp.MAILING_ID }}</th>
                      <td>{{ searchResp.MAILING_TXT }}</td>
                      <td>{{ searchResp.MAILING_ESTADO_NMB != '' ? searchResp.MAILING_ESTADO_NMB : 'SIN ESTADO' }}</td>
                      <td>
                        <div class="btn-group">
                          <button 
                            type="button" 
                            class="btn btn-primary"
                            title="EDITAR CORREO"
                            @click="editEmail">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button 
                            type="button" 
                            class="btn btn-danger"
                            title="ELIMINAR CORREO"
                            @click="deleteEmailProcess">
                            <i class="fa fa-trash"></i>
                          </button>
                        </div>

                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="input-group mt-3" v-if=" boolFlag ">
                  <input 
                    type="text" 
                    class="form-control form-control-lg" 
                    placeholder="EDITAR EMAIL"
                    v-model.trim=" emailEdit.MAILING_TXT ">
                  <div class="input-group-append">
                    <button 
                      type="button" 
                      class="btn btn-lg btn-outline-primary"
                      @click="editEmailProcess">
                      EDITAR
                    </button>
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
              @click="resetVariables">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnSearchEmail.txt " 
              :disabled=" btnSearchEmail.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

  <!--=====================================
  MODAL SEARCH GRUPO
  ======================================-->
  <div id="mdlSearchGrupo" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" searchGrupo ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">BUSCAR GRUPO - MÁXIMO {{ totalGrupos }} GRUPOS</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="resetVariables">
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
                  <small class="text-danger">{{ error.grupo }}</small>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <input 
                    type="number" 
                    class="form-control form-control-lg"                  
                    placeholder="INGRESAR GRUPO..."
                    v-model.trim=" nmbGrupo "
                    @input=" validateGrupoSearch "
                    autofocus>
                  </div>
                </div>

                <table class="table table-success" v-if="searchResp">
                  <caption>GRUPO {{ captionGrupo }}</caption>
                  <thead>
                    <tr>
                      <th scope="col">EMAIL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for=" (email,index) in searchResp ">
                      <td>{{ email.MAILING_TXT }}</td>
                    </tr>
                  </tbody>
                </table>
                
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
              @click="resetVariables">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnSearchGrupo.txt " 
              :disabled=" btnSearchGrupo.disabled ">
            </button>
            <button 
              type="button" 
              class="btn btn-primary"
              @click="exportFile"
              v-html=" btnExport.txt " 
              :disabled=" btnExport.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

  <!--=====================================
  MODAL INSERT GROUP
  ======================================-->
  <div id="mdlEstado" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" changeState ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">CAMBIAR ESTADO</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="resetVariables">
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
                    <span class="input-group-addon"><i class="fa fa-filter"></i></span> 
                    <select 
                      class="form-control form-control-lg"
                      @change="getState()"
                      v-model.trim=" state ">                    
                      <option value=""> SELECCIONAR ESTADO...</option>
                      <option  v-for=" estado in estados " :value="estado.MAILING_ESTADO_ID"> {{ estado.MAILING_ESTADO_NMB }}</option>
                    </select>
                  </div>
                </div>
                
              </div>
              
              <div class="col-12">
            
                <div class="form-group">
                  <textarea 
                    class="form-control" 
                    rows="30" 
                    placeholder="INGRESAR GRUPO..."
                    v-model.trim=" grupoIns "
                    @input=" validateGrupoState "
                    autofocus
                    required>
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
              @click="resetVariables">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnChangeState.txt " 
              :disabled=" btnChangeState.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

  <!--=====================================
  MODAL SEARCH GRUPO TABLE
  ======================================-->
  <div id="mdlGetGrupoStatus" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" searchGrupo ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">GRUPO {{ captionGrupo }}</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="resetVariables">
              &times;
            </button>
          </div>

          <!--=====================================
          CUERPO DEL MODAL
          ======================================-->
        
          <div class="modal-body">
            
            <div class="row">
            
              <div class="col-12">

                <table class="table table-success" v-if="searchResp">
                  <caption>GRUPO {{ captionGrupo }}</caption>
                  <thead>
                    <tr>
                      <th scope="col">EMAIL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for=" (email,index) in searchResp ">
                      <td>{{ email.MAILING_TXT }}</td>
                    </tr>
                    <tr v-if=" searchResp.length == 0 ">
                      <td>BUSQUEDA SIN RESULTADOS</td>
                    </tr>
                  </tbody>
                </table>
                
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
              @click="resetVariables">
              Salir
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

  <!--=====================================
  MODAL SEARCH TEXTO
  ======================================-->
  <div id="mdlSearchTexto" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent=" searchTexto ">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header">
            <h4 class="modal-title">BUSQUEDA POR TEXTO</h4>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
              @click="resetVariables">
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
                    <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
                    <input 
                    type="text" 
                    class="form-control form-control-lg"                  
                    placeholder="INGRESAR TEXTO..."
                    v-model.trim=" textoSearch "
                    @input=" validarTexto ">
                  </div>
                </div>

                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-primary reset" @click=" validarSearchTextRadio(1) ">
                    <input 
                      type="radio"> 
                      TODOS
                  </label>
                  <label class="btn btn-outline-primary reset" @click=" validarSearchTextRadio(2) ">
                    <input 
                      type="radio"> 
                      MAILRELAY
                  </label>
                  <label class="btn btn-outline-primary reset" @click=" validarSearchTextRadio(3) ">
                    <input 
                      type="radio"> 
                      NO MAILRELAY
                  </label>
                </div>

                <table class="table table-success" v-if="searchResp">
                  <caption>TOTAL {{ searchResp.length }}</caption>
                  <thead>
                    <tr>
                      <th scope="col">EMAIL</th>
                      <th>ESTADO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for=" (email,index) in searchResp ">
                      <td>{{ email.MAILING_TXT }}</td>
                      <td>{{ email.MAILING_ESTADO_NMB ? email.MAILING_ESTADO_NMB : '----------------'  }}</td>
                    </tr>
                    <tr v-if=" searchResp.length == 0 ">
                      <td>BUSQUEDA SIN RESULTADOS</td>
                    </tr>
                  </tbody>
                </table>
                
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
              @click="resetVariables">
              Salir
            </button>
            <button 
              type="submit" 
              class="btn btn-primary" 
              v-html=" btnTextSearch.txt " 
              :disabled=" btnTextSearch.disabled ">
            </button>
            <button 
              type="button" 
              class="btn btn-primary"
              @click="exportFile"
              v-html=" btnExport.txt " 
              :disabled=" btnExport.disabled ">
            </button>
          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<?php $this->endSection() ?>
<div id="app" v-cloak>

  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>"><?php echo $this->session_nmb?></a></li>
          <li class="breadcrumb-item active">Contacto</li>
        </ol>
      </nav>		
    </div>
  </div>

  <div class="row mb-2">

    <div class="col-12" id="contacto">
    
      <form @submit.prevent=" sendForm " class="mt-3">
									
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-comment-alt"></i></span> 
            <select 
              class="form-control form-control-lg"
              v-model.trim=" asunto "
              @change="cmbAsunto()">
            
            <option value=""> SELECCIONA EL ASUNTO...</option>
            <option v-for=" asu in asuntos " :key=" asu " :value=" asu ">{{ asu.value }}</option>
            </select>
          </div>
        </div>
        
        <div class="alert alert-info" v-if="detalle">
          <strong>{{ detalle }}</strong>
        </div>
            
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-comment-alt"></i></span>
            <textarea 
              class="form-control" 
              rows="5" 
              placeholder="INGRESAR MENSAJE..."
              v-model.trim=" mensaje "
              @input=" validateForm "
              required>
            </textarea>
          </div>
        </div>
              
        <div class="form-group">
          <div class="input-group">					   
            <button 
              type="submit" 
              class="btn btn-lg btn-primary btn-block" 
							v-html=" btnMsn.txt "
							:disabled=" btnMsn.disabled ">
            </button>
          </div>
        </div>

      </form>

    </div>
  </div><!-- FIN ROW PRINCIPAL -->

</div>
<div class="row">
	<div class="col-12">
		<div class="modal-header" style="background:#3c8dbc; color:white">
			<h4 class="modal-title">ADMINISTRADOR</h4>
		</div>
	</div>
</div>
	
	<a href="<?php echo base_url('cron/uf')?>" target="_blank" class="btn btn-primary">REST UF</a>
	<a href="<?php echo base_url('cron/membresia')?>" target="_blank" class="btn btn-primary">MEMBRESÍA</a>

<div class="row mt-2" id="app" v-cloak>
	
	<div class="col-6">

		<table class="table table-bordered">
				<tr v-if=" htmlLoading != '' ">
					<td colspan="2" v-html="htmlLoading"></td>
				</tr>

			<tbody v-if=" htmlLoading == '' ">
				<tr>
					<td>UF</td>
					<td>{{ UF }}</td>
				</tr>
				<tr>
					<td>MEMBRESIA {{ membresiaUF }}</td>
					<td>{{ membresiaPeso }}</td>
				</tr>
				<tr>
					<td>INCORPORACIÓN {{ incorporacionUF }}</td>
					<td>{{ incorporacionPeso }}</td>
				</tr>
				<tr>
					<td>PUSH {{ pushUF }}</td>
					<td>{{ pushPeso }}</td>
				</tr>
			</tbody>
		</table>

		<table class="table table-hover" v-if=" visitas != '' ">

			<caption>VISITAS</caption>

			<thead class="thead-light">
				<tr class="table-primary">
					<td>#</td>
					<td>EMPRESA</td>
					<td>DEVICE</td>
					<td>FECHA</td>
				</tr>
			</thead>

			<tbody>
				<tr v-for=" (visita,index) in visitas">
					<td>{{ ++index }}</td>
					<td>{{ visita.EMPRESA_ID }}</td>
					<td>{{ visita.DEVICE_ID }}</td>
					<td>{{ visita.VIS_FECHA_DATE }}</td>
				</tr>
			</tbody>
		</table>

	</div>	
        		
</div><!-- FIN ROW -->
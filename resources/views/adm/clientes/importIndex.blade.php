@extends('layout/admin')

@section('conteudo')

<style>
.success{
	background-color: #CDDC39!important;
	font-weight: 800;
}

.warning{
	background-color: #FF5722!important;
	font-weight: 800;
}
</style>

<div id="elImport">
	<h2 class="text-right">Importar clientes</h2><br>

	@include('errors.messages')

	<div v-show="loading">
		@include('utils.loading-full')
	</div>

	<div class="row">
		<div class="col-md-12">

			<div class="form-group">
				<label>Selecionar arquivo para processar</label>
				<input type="file" class="form-control" id="files" multiple="">
			</div>
							
			<button id="submit" class="btn btn-primary">Processar arquivo</button>
			<br><br>
			<button v-on:click="parse()" v-el:parsin class="btn btn-success">Importar</button>

			<br><br>
			<button v-on:click="saveImport($event)" class="btn btn-success">Salvar importação</button>
			
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
		
			<div class="panel panel-default">
				<div class="panel-header">
					<h4>Lista de clientes</h4>
				</div>
				
				<div class="panel-body">
					
					<table class="table table-bordered table-hover table-striped">
					    <thead>
					        <tr>
					            <th>Nome cliente</th>
					            <th>Email</th>
					            <th>Telefone</th>
					            <th>Telefone</th>
					        </tr>
					    </thead>
					    <tbody>
					        <tr v-for="client in clients.data">
					            <td>@{{client[4]}}</td>
					            <td>@{{client[6]}}</td>
					            <td>@{{client[7]}}</td>
					            <td>@{{client['teste'] = 'test'}}</td>
					        </tr>
					    </tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>

				
		




		<!-- Modal -->
<div class="modal fade" id="modalCaixaSelected" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" >ddsad: </h4>
      </div>
      <div class="modal-body">



	    <hr size="3px" style="margin-top: 2px"/>


		<hr size="3px" style="margin-top: 2px"/>

		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

</div>


    @section('scripts')
	    @parent
	        <script src="{!! elixir('js/financeiro.js') !!}"></script>

			<script type="text/javascript">

				$('.maskValor').mask("0000.00", {reverse: true});


				Vue.config.debug = true;
				Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#_tokenLaravel').getAttribute('value');

				var vm = new Vue({
				    el: '#elImport',
				    data: 
				    {	
				    	loading: false,
				    	clients: '',
				    	index: 1

				    },
				    ready: function(){
				    	var self = this;	
				      	// GET request
				      	//this.$http.get('/admin/financeiro/historico/caixa/fetchAll').then(function (response) {
				       //  	self.caixas = response.data.caixas;
				       //  	self.retorno = response.data.retorno;
				       //  	console.log('Caixas carregados com sucesso.');

						//}, function (response) {

					   //  	console.log('Erro ao tentar carregar caixas.');

					   //});


				    },
				    methods:
				    {
				    	parse: function(ev){

				    		this.clients = resultado;
							
				    	},
				    	saveImport: function(ev){
				    		ev.preventDefault();

				    		var self = this;

					    	this.$http.post('/admin/clientes/import/data', self.clients).then(function (response) {

					         	console.log(response);

							}, function (response) {

						     	console.log(response);

						   });
				    	}

					}
				});



var inputType = "local";
var stepped = 0, rowCount = 0, errorCount = 0, firstError;
var start, end;
var firstRun = true;
var maxUnparseLength = 10000;

$(function()
{

	// Demo invoked
	$('#submit').click(function()
	{
		if ($(this).prop('disabled') == "true")
			return;

		stepped = 0;
		rowCount = 0;
		errorCount = 0;
		firstError = undefined;

		var config = buildConfig();
		var input = $('#input').val();

		if (inputType == "remote")
			input = $('#url').val();
		else if (inputType == "json")
			input = $('#json').val();

		// Allow only one parse at a time
		$(this).prop('disabled', true);

		if (!firstRun)
			console.log("--------------------------------------------------");
		else
			firstRun = false;



		if (inputType == "local")
		{
			if (!$('#files')[0].files.length)
			{
				alert("Please choose at least one file to parse.");
				return enableButton();
			}
			
			$('#files').parse({
				config: config,
				before: function(file, inputElem)
				{
					console.log("Parsing file...", file);
				},
				error: function(err, file)
				{
					console.log("ERROR:", err, file);
					firstError = firstError || err;
					errorCount++;
				},
				complete: function()
				{
					printStats("Done with all files");
				}
			});
		}
		else if (inputType == "json")
		{
			if (!input)
			{
				alert("Please enter a valid JSON string to convert to CSV.");
				return enableButton();
			}

			var csv = Papa.unparse(input, config);

			console.log("Unparse complete");
			console.log("Time:", (end-start || "(Unknown; your browser does not support the Performance API)"), "ms");
			
			if (csv.length > maxUnparseLength)
			{
				csv = csv.substr(0, maxUnparseLength);
				console.log("(Results truncated for brevity)");
			}

			console.log(csv);

			setTimeout(enableButton, 100);	// hackity-hack
		}
		else if (inputType == "remote" && !input)
		{
			alert("Please enter the URL of a file to download and parse.");
			return enableButton();
		}
		else
		{
			window.results = Papa.parse(input, config);
			console.log("Synchronous results:", results);
			if (config.worker || config.download)
				console.log("Running...");
		}
	});

	$('#insert-tab').click(function()
	{
		$('#delimiter').val('\t');
	});
});




function printStats(msg)
{
	if (msg)
		console.log(msg);
	console.log("       Time:", (end-start || "(Unknown; your browser does not support the Performance API)"), "ms");
	console.log("  Row count:", rowCount);
	if (stepped)
		console.log("    Stepped:", stepped);
	console.log("     Errors:", errorCount);
	if (errorCount)
		console.log("First error:", firstError);
}



function buildConfig()
{
	return {
		delimiter: $('#delimiter').val(),
		header: $('#header').prop('checked'),
		dynamicTyping: $('#dynamicTyping').prop('checked'),
		skipEmptyLines: $('#skipEmptyLines').prop('checked'),
		preview: parseInt($('#preview').val() || 0),
		step: $('#stream').prop('checked') ? stepFn : undefined,
		encoding: $('#encoding').val(),
		worker: $('#worker').prop('checked'),
		comments: $('#comments').val(),
		complete: completeFn,
		error: errorFn,
		download: inputType == "remote"
	};
}

function stepFn(results, parser)
{
	stepped++;
	if (results)
	{
		if (results.data)
			rowCount += results.data.length;
		if (results.errors)
		{
			errorCount += results.errors.length;
			firstError = firstError || results.errors[0];
		}
	}
}

function completeFn(results)
{
	end = now();

	if (results && results.errors)
	{
		if (results.errors)
		{
			errorCount = results.errors.length;
			firstError = results.errors[0];
		}
		if (results.data && results.data.length > 0)
			rowCount = results.data.length;
	}

	printStats("Parse complete");
	console.log("    Results:", results);

	window.resultado = results;

	// icky hack
	setTimeout(enableButton, 100);
}

function errorFn(err, file)
{
	end = now();
	console.log("ERROR:", err, file);
	enableButton();
}

function enableButton()
{
	$('#submit').prop('disabled', false);
}

function now()
{
	return typeof window.performance !== 'undefined'
			? window.performance.now()
			: 0;
}

			</script>

	    @stop

@stop
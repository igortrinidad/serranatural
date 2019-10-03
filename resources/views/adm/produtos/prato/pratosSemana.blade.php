@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Pratos da semana</h1>

  @include('errors.messages')

<div class="panel panel-default">
	<div class="panel-heading"><h5>Agendar Pratos</h5></div>
		<div class="panel-body">
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              {!! Form::select('pratos_id', $pratosForSelect, null, ['class' => 'form-control', 
              'single' => 'single', 'id' => 'pratos', 'placeholder' => 'Selecione um prato'])   !!}
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
                <input type="text" id="dataStr" class="form-control datepicker" placeholder="dd/mm/aaaa" required>
            </div>
          </div> 
          <div class="col-md-2">
            <div class="btn btn-default" id="btnModal" data-toggle="modal" data-target="#modalPrato">Agendar Prato</div>
          </div>
      
    </div>
  </div>
</div>

  <div class="panel panel-default">
  	<div class="panel-heading"><h5>Pratos agendados</h5></div>
  	<div class="panel-body">

  		<table class="table table-hover">
  			<thead>
  				<tr>
          <strong>
  					<td>Data programada</td>
            <td>Prato</td>
            <td>Acompanhamentos</td>
            <td>Pequeno</td>
            <td>Grande</td>
  					<td>Edita</td>
            <td>Exclui</td>
  					<td>Foto</td>
          </strong>
  				</tr>
  			</thead>

        <tbody>

        @foreach($agenda as $a)
          @if($a->pratos)
            <tr>
              <td><b>{{ dataMysqlParaDateTime($a->dataStamp) }}</b>, {{ dataMysqlParaPtBr($a->dataStamp) }}</td>
              <td>{{ $a->pratos['prato'] }}</td>
              <td>{{ $a->pratos['acompanhamentos'] }}</td>
              <td>{{ $a->pratos['valor_pequeno'] }}</td>
              <td>{{ $a->pratos['valor_grande'] }}</td>
              <td><a href="/admin/produtos/pratos/edita/{{$a->pratos->id}}"><i class="fa fa-pencil"></i>
                  </a>
              </td>
              <td><a href="/admin/produtos/excluiPratoSemana/{{$a->id}}">
                    <i class="fa fa-trash"></i>
                  </a>
              </td>
              <td>
                <a href="/admin/produtos/pratos/mostra/{{$a->pratos->id}}"><img src="/arquivos/produtos/{{$a->pratos['foto']}}" width="80px" /></a>
              </td>
            </tr>
          @endif
        @endforeach

        </tbody>

  		</table>
    </div>
  </div>

  <div class="panel panel-default">
  <div class="panel-heading"><h5>Envia email com o Prato do Dia</h5></div>
    <div class="panel-body">
      
          <form action="/admin/produtos/enviaPratoDoDia" method="POST">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <div class="form-group">
                <label>Mensagem personalizada</label>
                <textarea type="textarea" name="mensagem" class="form-control"></textarea>
            </div>
      
          <button type="submit" class="btn btn-default">Enviar emails</button>
          </form>
    </div>
  </div>



<!-- INICIO MODAL PRATO -->

                            <div class="modal inmodal fade" id="modalPrato" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="tituloModal">Agendar para: <span id="dataPrato"></span></h4>
                                        </div>
                                        <div class="modal-body text-center">
                                          
                                          <div id="loader">
                                            <img src="/assets/loading-ring.gif" width="80px">
                                            <div style="background:url(/assets/loading-ring.gif) no-repeat center center;width:25px;height:25px;"></div>
                                          </div>

                                          <div id="div_prato">

                                            <p id="nome_prato"></p>
                                            
                                            <label>Acompanhamentos</label>
                                            <p id="acompanhamentos_prato"></p>

                                            <div class="row">
                                              <div class="col-md-6">
                                                <label>Valor pequeno</label>
                                                <p id="valor_pequeno_prato"></p>
                                              </div>
                                              <div class="col-md-6">
                                                <label>Valor grande</label>
                                                <p id="valor_grande_prato"></p>
                                              </div>
                                            </div>
                                            
                                            <p>
                                            <img id="foto_prato" src="" width="200px">
                                            </p>

                                            <div class="row">
                                              <div class="col-md-6">
                                                <a id="btnEditar" href="" class="btn btn-default btn-block">
                                                Editar</a>
                                              </div>

                                              <form action="/admin/produtos/salvaPratoSemana" class="form-inline" method="POST">
                                                <div class="col-md-6">
                                                  <input type="hidden" name="pratos_id" />
                                                  <input type="hidden" name="dataStr"/> 
                                                  <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                                  <button type="submit" class="btn btn-default btn-block">Confirma</button>
                                                </div>
                                              </form>


                                            </div>


                                          </div>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>


  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">


    @section('scripts')
      @parent

      <script type="text/javascript">

      $('#pratos').select2();

      String.prototype.nl2br = function()
        {
            return this.replace(/\n/g, "<br/>");
        }

      $('#div_prato').fadeOut();

      $("#pratos").change(function() 
      {
        var id = $(this).val();
        //var href = '/admin/clientes/' + id + '/mostra';
        //  //adiciona o valor do id recebido como parametro na funcao
        //$('#linkCliente').prop("href", href);

        console.log(id);
        consultaPrato(id);
      });

      $('#modalPrato').on('hidden.bs.modal', function () {
        $('#loader').show();
        $('#div_prato').fadeOut();
      })

      $('#btnModal').on('click', function(){
        var id = $('#pratos').val();
        var dataStr = $('#dataStr').val()

        $('#dataPrato').text(dataStr);
        $('input[name="pratos_id"]').val(id);
        $('input[name="dataStr"]').val(dataStr);
        var href = '/admin/produtos/pratos/edita/' + id;
        $('#btnEditar').prop("href", href);
        consultaPrato(id);

      });



function consultaPrato(id)
{
  var id = $('#pratos').val();
  formData = {
    '_token' : $("#token").val(),
    'id' : id,
  };

  var url = "/admin/produtos/pratos/consultaPrato";

  $.ajax(
  {
      type: "POST",
      url : url,
      data : formData,
      success : function(data)
      {

        $('#loader').hide();
        $('#div_prato').fadeIn();

        $('#nome_prato').text(data['prato']);
        $('#acompanhamentos_prato').html(data['acompanhamentos'].nl2br());
        $('#valor_pequeno_prato').text('R$ ' + data['valor_pequeno']);
        $('#valor_grande_prato').text('R$ ' + data['valor_grande']);

        if(data['foto'] != '')
        {
          $('#foto_prato').attr("src", '/arquivos/produtos/' + data['foto']);
        }


        
        

      }
  },"json");

};

      </script>

      @stop

@stop
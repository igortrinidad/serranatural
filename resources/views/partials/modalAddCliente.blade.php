<!-- INICIO MODAL CLIENTE -->

    <div class="modal  fade" id="modalAddCliente" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Cadastra Cliente</h4>

                </div>
                <div class="modal-body">   

                    @include('errors.messages')
                    
                    <div class="row">
                        <div class="col-md-12" style="padding: 30px">
                        
                            <form id="votoForm" action="/cadastro" class="form-group" method="POST">
                                <input form="votoForm" type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                <input form="votoForm" type="hidden" name="senha_resgate" value="{{ rand(1000, 9999)}}" />
                               
                                <div class="form-group">
                                    <label class="label_form primeiro_label_form">Nome</label>
                                    <input form="votoForm" type="text" name="nome" value="{{ old('nome') }}" class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label class="label_form">Email</label>
                                    <input form="votoForm" type="email" name="email" value="{{ old('email') }}"class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label class="label_form">Telefone</label>
                                    <input form="votoForm" type="text" name="telefone" value="{{ old('telefone') }}"class="form-control phone_with_ddd"/>
                                </div>
                                <div class="form-group">
                                    <input form="votoForm" type="checkbox" name="opt_email" value="1" class="checkbox" checked/>
                                    <p class="texto_votacao">Cliente deseja receber email de almoço do dia?</p>
                                </div>

                                <div class="form-group">
                                    <button id="votoCadastro" form="votoForm" type="submit" class="btn btn-primary btn-block">Cadastrar</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@extends('layout/admin')

@section('conteudo')

<h1 class="text-right">Dashboard</h1>

	@if(Session::has('msg_retorno'))
	<div class="alert alert-{{Session::get('tipo_retorno')}}">
	     {{Session::get('msg_retorno')}}
	 </div>
	@endif

<div class="row">

    <div class="panel panel-default">
        <div class="panel-body">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-exclamation-triangle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$pgto_dashboard}}</div>
                                    <div>Contas a pagar</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.financeiro.aPagar')}}">
                            <div class="panel-footer">
                                <span class="pull-left">Confira</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
        

                @if(isset($pratoHoje))
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cutlery fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{isset($pratoHoje) ? substr($pratoHoje->prato, 0, 10) : ''}}</div>
                                    <div>Prato de HOJE</div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/produtos/pratosSemana">
                            <div class="panel-footer">
                                <span class="pull-left">Confira</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif

                @if(isset($pratoAmanha))
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cutlery fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{isset($pratoAmanha) ? substr($pratoAmanha->prato, 0, 10) : ''}}</div>
                                    <div>Prato de Amanhã</div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/produtos/pratosSemana">
                            <div class="panel-footer">
                                <span class="pull-left">Confira</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
        </div>
    </div>

</div>



@stop
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de administração Serra Natural">
    <meta name="author" content="Igor Trindade">
    <input type="hidden" id="_tokenLaravel" value="{!! csrf_token() !!}" />

    <title>Serra Natural - Adiministrativo (2)</title>

    <link href="{!! asset('css/vendor.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/app.css') !!}" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/admin">Serra Natural</a>
            </div>
            <!-- /.navbar-header -->

        @if (Auth::guest())
        <ul class="nav navbar-top-links navbar-right">
          <li><a href="/login">Login</a></li>
        </ul>
        @else


            <ul class="nav navbar-top-links navbar-right">
                <li>
                   {{ \Auth::user()->name }}
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown" >
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
                        @if($pgto_vencido >= 1) style="color: #ED3D34" 
                        @elseif($pgto_incompleto >= 1) style="color: #FCB93D"
                        @endif
                    >
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                    @if($pgto_vencido >= 1)
                        <li>
                            <a href="{{route('admin.financeiro.aPagar')}}">
                                <div>
                                    <i class="fa fa-exclamation fa-fw"></i> Contas vencendo 
                                        <strong>(<span style="color: #ED3D34">{{$pgto_vencido}}</span>)</strong>
                                    <span class="pull-right text-muted small">Hoje</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                    @endif
                    @if($pgto_incompleto >= 1)
                        <li>
                            <a href="{{route('admin.financeiro.aPagar')}}">
                                <div>
                                    <i class="fa fa-exclamation fa-fw"></i> Pagamento incompleto 
                                        <strong>(<span style="color: #ED3D34">{{$pgto_incompleto}}</span>)</strong>
                                    <span class="pull-right text-muted small">Hoje</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                    @endif

                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">

                        <li><a href="{{ route('admin.users.edit')}}"><i class="fa fa-user fa-fw"></i> Editar usuário</a>
                        </li>
                        <li><a href="{{ route('admin.users.add')}}"><i class="fa fa-plus fa-fw"></i> Adiciona novo</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ route('auth.logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                    <!--
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>

                        </li>
                    -->
                        <li>
                            <a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>

<!-- inicio itens do menu -->
                        <li>
                            <a href="#"><i class="fa fa-sitemap"></i> Clientes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!! route('admin.client.lista') !!}">Lista</a>
                                </li>
                                <li>
                                    <a href="#modalAddCliente" data-toggle="modal" >Adiciona</a>
                                </li>
                                <li>
                                    <a href="{!! route('admin.client.fidelidade') !!}">Fidelidade</a>
                                </li>
                                <li>
                                    <a href="{!! route('admin.client.voucherList') !!}">Lista Vouchers</a>
                                </li>

                            </ul>
                        </li>

                        <li>
                             <a href="#"><i class="fa fa-cutlery"></i> Pratos<span class="fa arrow"></span></a>
                             <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('produtos.pratos.add')}}">Adiciona</a>
                                </li>

                                <li>
                                    <a href="/admin/produtos/pratos/lista">Lista pratos</a>
                                </li>
                                <li>
                                    <a href="/admin/produtos/pratosSemana">Agenda Pratos</a>
                                </li>
                                <li>
                                    <a href="/admin/produtos/quantidadeVendaPrato">Relatório de venda</a>
                                </li>



                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-th-list"></i> Produtos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/produtos/create">Adiciona</a>
                                </li>

                                <li>
                                    <a href="/admin/produtos/lista">Lista</a>
                                </li>

                                <li>
                                    <a href="/admin/produtos/calcular/index">Calcular</a>
                                </li>

                                <li>
                                    <a href="/admin/produtos/disponiveis">Produtos disponíveis</a>
                                </li>

                            </ul>
                        </li>
                            

                        <li>
                            <a href="#"><i class="fa fa-money"></i> Caixa<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                
                                <li>
                                    <a href="{{ route('admin.financeiro.caixa')}}">Fluxo de caixa</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.financeiro.caixa.historico')}}">Histórico de caixa</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.financeiro.retirada')}}">Retirada</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.financeiro.retiradasList')}}">Histórico retiradas</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.financeiro.conferencias')}}">Histórico conferências</a>
                                </li>

                            </ul>
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-tasks"></i> Financeiro<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.financeiro.pagamentos')}}"> Cadastrar pagamento</a>
                                </li>

                                <li>
                                    <a href="{{route('admin.financeiro.despesa')}}"> Despesa simples</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.financeiro.aPagar')}}"> A pagar</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.financeiro.historicoPagamentos')}}"> Historico</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="admin/promocoes"><i class="fa fa-money"></i> Promoções<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/promocoes">Criar</a>
                                </li>
                                <li>
                                    <a href="/admin/promocoes/lista">Lista</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="admin/estoque"><i class="fa fa-check-square"></i> Estoque<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/produtos/baixaestoque">Dar baixa</a>
                                </li>
                                <li>
                                    <a href="/admin/produtos/balanco">Balanço</a>
                                </li>
                                <li>
                                    <a href="/admin/produtos/historico/balanco">Historico Balanço</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="admin/marketing"><i class="fa fa-reply-all"></i> Marketing<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.marketing.criarModelo') }}">Criar modelo</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.marketing.lista')}}">Lista modelos</a>
                                </li>
                               <li>
                                    <a href="{{ route('admin.marketing.lastLogs')}}">Ultimos logs</a>
                                </li>
                            </ul>
                        </li>
<!--
                        <li>
                            <a href="admin/promocoes"><i class="fa fa-diamond"></i> Promoções<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/promocoes">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#">Vouchers</a>
                                </li>


                            </ul>
                        </li>
-->


                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Equipe<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.funcionarios.adiciona')}}">Adiciona</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.funcionarios.lista')}}">Lista</a>
                                </li>


                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

                    @endif
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                    @include('flash::message')
                    
                    @yield('conteudo')


                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    @include('partials.modalAddCliente')

    @section('scripts')

    <script src="{!! asset('js/vendor.js') !!}"></script>
    <script src="{!! elixir('js/app.js') !!}"></script>
    <script src="{!! asset('js/dropzone.js') !!}"></script>

    @show

</body>

</html>

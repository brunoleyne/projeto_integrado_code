@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Relatórios</li>
        <li class="breadcrumb-item active">Mensal</li>
    </ol>
    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-list"></i> Relatório Fechamento Mensal</strong>
                    </div>
                    <div class="card-body">
                        @if (isset($sessoes->total))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Número Sessões Realizada:</label>
                                        <span>{{$sessoes->realizadas->count()}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Número Sessões Pendentes:</label>
                                        <span>{{$sessoes->naoRealizadas->count()}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sessões Tipo M:</label>
                                        <span>{{ $sessoes->tipoM}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sessões Tipo S:</label>
                                        <span>{{ $sessoes->tipoS}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Total Sessões (Realizadas + Pendentes):</label>
                                        <span>{{$sessoes->total}}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse-realizadas" aria-expanded="true">
                                <i class="icon-action fa fa-chevron-down"></i>
                                <span class="title">Sessões Realizadas</span>
                            </a>
                        </header>
                        <div class="collapse" id="collapse-realizadas">
                            <div class="card-body">
                                <h3>Sessões Realizadas</h3>
                                <table class="table table-sm table-striped table-responsive table-borderless">
                                    <thead>
                                    <tr class="table-active">
                                        <th scope="col">Nome</th>
                                        <th scope="col">Nº</th>
                                        <th scope="col">Data Ínicio</th>
                                        <th scope="col">Data Evolução</th>
                                        <th scope="col">Fisioterapeuta</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Data Alta</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($sessoes->realizadas as $realizadas)
                                        <tr>
                                            <td>{{$realizadas->paciente_nome}}</td>
                                            <td>{{$realizadas->numero_evolucao}}</td>
                                            <td>{{$realizadas->data_inicial}}</td>
                                            <td>{{$realizadas->data_evolucao}}</td>
                                            <td>{{$realizadas->fisioterapeuta}}</td>
                                            <td>{{$realizadas->tipo_cid}}</td>
                                            <td>{{$realizadas->data_alta}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse-nao-realizadas"
                               aria-expanded="true">
                                <i class="icon-action fa fa-chevron-down"></i>
                                <span class="title">Sessões Pendentes</span>
                            </a>
                        </header>
                        <div class="card-body">
                            <div class="collapse" id="collapse-nao-realizadas">
                                <h3>Sessões Pendentes</h3>
                                <table class="table table-sm table-striped table-responsive table-borderless">
                                    <thead>
                                    <tr class="table-active">
                                        <th scope="col">Nome</th>
                                        <th scope="col">Nº</th>
                                        <th scope="col">Data Ínicio</th>
                                        <th scope="col">Data Evolução</th>
                                        <th scope="col">Fisioterapeuta</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Data Alta</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($sessoes->naoRealizadas as $naoRealizadas)
                                        <tr>
                                            <td>{{$naoRealizadas->paciente_nome}}</td>
                                            <td>{{$naoRealizadas->numero_evolucao}}</td>
                                            <td>{{$naoRealizadas->data_inicial}}</td>
                                            <td>{{$naoRealizadas->data_evolucao}}</td>
                                            <td>{{$naoRealizadas->fisioterapeuta}}</td>
                                            <td>{{$naoRealizadas->tipo_cid}}</td>
                                            <td>{{$naoRealizadas->data_alta}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-filter"></i> Filtros</strong>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('method'=>'POST', 'id'=>'filtro-form', 'url' => route('relatorio.mensal-post'))) !!}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="data_inicial">Data Inicial</label>
                                    {!! Form::text('data_inicial', null, ['placeholder' => 'Data Inicial','class' => "date form-control".($errors->has('data_inicial') ? ' is-invalid' : '' )]) !!}
                                    @if ($errors->has('data_inicial'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('data_inicial') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="data_final">Data Final</label>
                                    {!! Form::text('data_final', null, ['placeholder' => 'Data Final','class' => "date form-control".($errors->has('data_final') ? ' is-invalid' : '' )]) !!}
                                    @if ($errors->has('data_final'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('data_final') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-filter"></i>
                                    Filtrar
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
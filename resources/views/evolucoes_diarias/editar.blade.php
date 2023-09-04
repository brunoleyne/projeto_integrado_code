@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Evoluções Diárias</li>
        <li class="breadcrumb-item active">Atualizar Informações</li>
    </ol>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <i class="fa fa-line-chart" aria-hidden="true"></i> <strong>Editar Evolução Nº {{$evolucao->numero_evolucao}}</strong>
            </div>
            <div class="card-body">
                {!! Form::model($evolucao, ['method' => 'PATCH','route' => ['evolucoesdiarias.update', $evolucao->id]]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nome">Data Sessão</label>
                            {!! Form::text('data', null, ['placeholder' => 'Data','class' => "date form-control".($errors->has('data') ? ' is-invalid' : '' )]) !!}
                            {!! $errors->first('data','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="descricao">Data Faturamento</label>
                            {!! Form::select('fechamento_id', $fechamentos, null, ['class' => "form-control".($errors->has('descricao') ? ' is-invalid' : '' )]) !!}
                            {!! $errors->first('fechamento_id','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="descricao">Finalizado</label>
                            {!! Form::select('completa', [1 => 'Sim',0 => 'Não' ], null, ['class' => "form-control".($errors->has('completa') ? ' is-invalid' : '' )]) !!}
                            {!! $errors->first('completa','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            {!! Form::text('descricao', null, ['placeholder' => 'Descrição','class' => "form-control".($errors->has('descricao') ? ' is-invalid' : '' )]) !!}
                            {!! $errors->first('descricao','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection

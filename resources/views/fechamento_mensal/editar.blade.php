@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Fechamento Mensal</li>
        <li class="breadcrumb-item active">Atualizar Informações</li>
    </ol>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="nav-icon fa fa-calendar-o"></i> <strong>Atualizar Fechamento Mensal</strong>
            </div>
            <div class="card-body">
                {!! Form::model($fechamentoMensal, ['method' => 'PATCH','route' => ['fechamento-mensal.update', $fechamentoMensal->id]]) !!}
                @include('fechamento_mensal.form')
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

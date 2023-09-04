@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Pacientes</li>
        <li class="breadcrumb-item active">Atualizar</li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="nav-icon fa fa-user"></i> <strong>Atualizar Paciente {{$paciente->nome}}</strong>
            </div>
            <div class="card-body">
                {!! Form::model($paciente, ['method' => 'PATCH','route' => ['pacientes.update', $paciente->id]]) !!}
                @include('pacientes.form')
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

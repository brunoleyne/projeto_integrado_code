@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Médicos</li>
        <li class="breadcrumb-item active">Cadastrar</li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="nav-icon fa fa-user-md"></i> <strong>Cadastrar Médico</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'medicos.store','method'=>'POST')) !!}
                @include('medicos.form')
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

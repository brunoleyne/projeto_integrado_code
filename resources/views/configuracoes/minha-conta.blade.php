@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Configurações</li>
        <li class="breadcrumb-item active">Minha Conta</li>
    </ol>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <i class="nav-icon fa fa-user"></i> <strong>Minha Conta</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'usuario.minha-conta.update','method'=>'PATCH')) !!}
                @include('configuracoes.minha-conta-form')
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
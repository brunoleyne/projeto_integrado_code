@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Avaliacoes</li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
    <div class="container-fluid">
        <div id="ui-view">
            {!! Form::model($avaliacao, ['method' => 'PATCH','route' => ['avaliacoes.update', $avaliacao->id]]) !!}
            @include('avaliacoes.realizar-avaliacao-form')
            <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

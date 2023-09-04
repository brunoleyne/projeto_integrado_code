@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Avaliações</li>
        <li class="breadcrumb-item active">Agendar</li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="nav-icon fa fa-calendar"></i> <strong>Agendar Avaliações</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'avaliacoes.store','method'=>'POST')) !!}
                @include('avaliacoes.cadastrar-avaliacao-form')
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
@section('script')
    <script type="text/javascript" defer>
        $(document).ready(function(){
            $('.select-multiple').select2();
        });
    </script>
@endsection
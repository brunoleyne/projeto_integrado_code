@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Fisioterapeutas</li>
        <li class="breadcrumb-item active">Atualizar Informações</li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="nav-icon fa fa-user-o"></i> <strong>Atualizar Fisioterapeuta {{$fisioterapeuta->name}}</strong>
            </div>
            <div class="card-body">
                {!! Form::model($fisioterapeuta, ['method' => 'PATCH','route' => ['fisioterapeutas.update', $fisioterapeuta->id]]) !!}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            {!! Form::text('name', null, ['placeholder' => 'Nome', 'disabled' => 'true','class' => "form-control"]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nome">E-mail</label>
                            {!! Form::text('email', null, ['placeholder' => 'E-mail', 'disabled' => 'true','class' => "form-control"]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nome">Crefito</label>
                            {!! Form::text('crefito', null, ['placeholder' => 'Crefito', 'type=' => 'password', 'class' => "form-control".($errors->has('crefito') ? ' is-invalid' : '' )]) !!}
                            {!! $errors->first('crefito','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>

                {{--<div class="row">--}}
                    {{--<div class="col-sm-6">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="nome">Senha</label>--}}
                            {{--{!! Form::text('password', null, ['placeholder' => 'Senha', 'type=' => 'password', 'class' => "form-control".($errors->has('password') ? ' is-invalid' : '' )]) !!}--}}
                            {{--{!! $errors->first('password','<div class="invalid-feedback">:message</div>') !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-sm-6">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="nome">Confirmar Senha</label>--}}
                            {{--{!! Form::text('password_confirmation', null, ['placeholder' => 'Confirmar Senha', 'type=' => 'password_confirmation', 'class' => "form-control".($errors->has('password_confirmation') ? ' is-invalid' : '' )]) !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
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

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Nome</label>
            {!! Form::text('name', null, ['placeholder' => 'Nome','class' => "form-control".($errors->has('name') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('name','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">E-mail</label>
            {!! Form::text('email', null, ['placeholder' => 'E-mail','class' => "form-control".($errors->has('email') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('email','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Senha</label>
            {!! Form::text('password', null, ['placeholder' => 'Senha', 'type=' => 'password', 'class' => "form-control".($errors->has('password') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('password','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Confirmar Senha</label>
            {!! Form::text('password_confirmation', null, ['placeholder' => 'Confirmar Senha', 'type=' => 'password_confirmation', 'class' => "form-control".($errors->has('password_confirmation') ? ' is-invalid' : '' )]) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Cargo</label>
            {!! Form::select('role', ['fisioterapeuta' => 'Fisioterapeuta', 'recepcao' => 'Recepção'], null, ['class' => "form-control".($errors->has('role') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('role','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Crefito</label>
            {!! Form::text('crefito', null, ['placeholder' => 'Crefito', 'type=' => 'password', 'class' => "form-control".($errors->has('crefito') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('crefito','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>



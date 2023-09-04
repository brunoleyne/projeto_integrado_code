<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Nome</label>
            {!! Form::text('name', $user->name, ['placeholder' => 'Nome', 'disabled' => 'true','class' => "form-control"]) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">E-mail</label>
            {!! Form::text('email',  $user->email, ['placeholder' => 'E-mail', 'class' => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Senha</label>
            {!! Form::password('password', ['placeholder' => 'Senha', 'class' => "form-control".($errors->has('password') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('password','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Confirmar Senha</label>
            {!! Form::password('password_confirmation', ['placeholder' => 'Confirmar Senha', 'class' => "form-control".($errors->has('password_confirmation') ? ' is-invalid' : '' )]) !!}
        </div>
    </div>
</div>
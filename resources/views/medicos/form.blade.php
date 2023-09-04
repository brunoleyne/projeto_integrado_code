<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label for="nome">Nome</label>
            {!! Form::text('nome', null, ['placeholder' => 'Nome','class' => "form-control".($errors->has('nome') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('nome','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="nome">CRM</label>
            {!! Form::text('crm', null, ['placeholder' => 'CRM','class' => "form-control".($errors->has('crm') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('crm','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
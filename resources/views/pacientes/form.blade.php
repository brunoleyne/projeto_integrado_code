<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="nome">Nome</label>
            {!! Form::text('nome', null, ['placeholder' => 'Nome','class' => "form-control".($errors->has('nome') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('nome','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="nome">CNS</label>
            {!! Form::text('cns', null, ['placeholder' => 'CNS','class' => "form-control".($errors->has('cns') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('cns','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label for="nome">Data Nascimento</label>
            {!! Form::text('data_nascimento', null, ['placeholder' => 'Nascimento','class' => "date form-control".($errors->has('data_nascimento') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('data_nascimento','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label for="nome">CPF</label>
            {!! Form::text('cpf', null, ['placeholder' => 'CPF','class' => "cpf form-control".($errors->has('cpf') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('cpf','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
            <label for="nome">CEP</label>
            {!! Form::text('cep', null, ['placeholder' => 'CEP','class' => "form-control".($errors->has('cep') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('cep','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Endereço</label>
            {!! Form::text('logradouro', null, ['placeholder' => 'Rua, número','class' => "form-control".($errors->has('logradouro') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('logradouro','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="nome">Bairro</label>
            {!! Form::text('bairro', null, ['placeholder' => 'Bairro','class' => "form-control".($errors->has('bairro') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('bairro','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="nome">  Município</label>
            {!! Form::text('municipio', null, ['placeholder' => 'Município','class' => "form-control".($errors->has('municipio') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('municipio','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-1">
        <div class="form-group">
            <label for="nome">Estado</label>
            {!! Form::text('estado', null, ['placeholder' => 'UF','class' => "form-control".($errors->has('estado') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('estado','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="nome">Telefone</label>
            {!! Form::text('telefone', null, ['placeholder' => 'Telefone','class' => "telefone form-control".($errors->has('telefone') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('telefone','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="nome">Telefone Secundário</label>
            {!! Form::text('telefone_secundario', null, ['placeholder' => 'Telefone Secundário','class' => "telefone form-control".($errors->has('telefone_secundario') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('telefone_secundario','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3" style="margin-top: 31px;">
        <button type="button" class="btn btn-primary" onclick="ChamarDigital()">Capturar Digital</button>
        @if (isset($paciente->fingerprint))
            <small class="text-muted">Digital já registrada no sistema</small>
        @endif
    </div>
</div>
<br>
{!! Form::text('fingerprint', null, ['id' => 'fingerprint','class' => "form-control d-none"]) !!}
@section('script')
    <script type="text/javascript" defer>
        function ChamarDigital() {
            $.ajax({
                url: 'http://localhost:9000/api/public/v1/captura/Capturar/1',
                type: 'GET',
                success: function (data) {
                    if (data !== "") {
                        $('#fingerprint').val(data)
                    }
                }
            })
        }
    </script>
@endsection

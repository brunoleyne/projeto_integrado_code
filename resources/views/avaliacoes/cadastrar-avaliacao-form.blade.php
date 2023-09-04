@if ($errors->any())
    <div class="alert alert-danger">
        <p>Ocorreu um erro no sistema: {{ implode('', $errors->all(':message')) }}</p>
    </div>
@endif
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="paciente_id">Paciente</label>
            {!! Form::select('paciente_id', $pacienteSelect, null, ['class' => "form-control".($errors->has('paciente_id') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('paciente_id','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="medico_id">Médico</label>
            {!! Form::select('medico_id', $medicoSelect, null, ['class' => "form-control".($errors->has('medico_id') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('medico_id','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="fisioterapeuta_id">Fisioterapeuta</label>
            {!! Form::select('fisioterapeuta_id', $fisioterapeutaSelect, null, ['class' => "form-control".($errors->has('fisioterapeuta_id') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('fisioterapeuta_id','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="origem">Origem</label>
            {!! Form::select('origem', [
            'CGR' => 'CGR', 'CREAB' => 'CREAB', 'PADRE EUSTÁQUIO' => 'PADRE EUSTÁQUIO', 'CAMPOS SALES' => 'CAMPOS SALES', 'OUTROS' => 'OUTROS'
            ], null, ['class' => "form-control".($errors->has('origem') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('origem','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4 origem-area">
        <div class="form-group">
            <label for="situacao">Lugar de Origem</label>
            {!! Form::text('origem_outros', null, ['id' => 'origem_outros', 'disabled' => 'true', 'placeholder' => 'Origem','class' => "form-control".($errors->has('origem_outros') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('origem_outros','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_avaliacao">Data Avaliação</label>
            {!! Form::text('data_avaliacao', null, ['placeholder' => 'Data Avaliação','class' => "date form-control".($errors->has('data_avaliacao') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('data_avaliacao','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="cmc">CMC(SISREG)</label>
            {!! Form::text('cmc', null, ['placeholder' => 'CMC','class' => "form-control".($errors->has('cmc') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('cmc','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="data_avaliacao">Número Avaliações</label>
            {!! Form::select('numero_avaliacoes', [40 => 40, 30 => 30, 20 => 20, 15 => 15, 10 => 10], null, ['placeholder' => 'Número Avaliações','class' => "form-control".($errors->has('numero_avaliacoes') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('numero_avaliacoes','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="dias_semana">Dias na Semana</label>
            {!! Form::select('dias_semana[]', [1 => 'Segunda-Feira', 2 => 'Terça-Feira', 3 => 'Quarta-Feira', 4 => 'Quinta-Feira', 5 => 'Sexta-Feira',], null,
            ['multiple' => 'multiple', 'class' => "select-multiple form-control".($errors->has('dias_semana') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('dias_semana','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<script type="text/javascript" defer>
    $('[name=origem]').change(function() {
       if ($('[name=origem]').val() == 'OUTROS') {
           $("#origem_outros").prop('disabled', false);
       } else {
           $("#origem_outros").prop('disabled', true);
       }
    });

    $(function() {
        if ($("#origem_outros").val()) {
            $("#origem_outros").prop('disabled', false);
        }
    });
</script>
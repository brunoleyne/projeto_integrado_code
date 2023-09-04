
    @if ($errors->any())
        <div class="alert alert-danger">
            <p>Ocorreu um erro no sistema: {{ implode('', $errors->all(':message')) }}</p>
        </div>
    @endif
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <h3>Ficha de Avaliaçao: {{$avaliacao->paciente->nome}} - Data {{$avaliacao->data_avaliacao}}</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="situacao">Situaçao</label>
            {!! Form::select('situacao', $enumSituacao, null, ['placeholder' => 'Situaçao','class' => "form-control".($errors->has('situacao') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('situacao','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="cid">CID</label>
            {!! Form::text('cid', null, ['placeholder' => 'CID','class' => "form-control".($errors->has('cid') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('cid','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
    <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="diagnostico">Diagnóstico</label>
            {!! Form::text('diagnostico', null, ['placeholder' => 'Diagnóstico','class' => "form-control".($errors->has('diagnostico') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('diagnostico','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="queixas">Queixas</label>
            {!! Form::text('queixas', null, ['placeholder' => 'Queixas','class' => "form-control".($errors->has('queixas') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('queixas','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="anamnese">Anamnese</label>
            {!! Form::textarea('anamnese', null, ['placeholder' => 'Anamnese','rows' => '4','class' => "form-control".($errors->has('anamnese') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('anamnese','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="dor">Situaçao</label>
            {!! Form::select('dor', $enumDor, null, ['placeholder' => 'Escala de Dor','class' => "form-control".($errors->has('dor') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('dor','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="codigo">Código</label>
            {!! Form::text('codigo', null, ['placeholder' => 'Código','class' => "form-control".($errors->has('codigo') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('codigo','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="localizacao_dor">Localização da Dor</label>
            {!! Form::text('localizacao_dor', null, ['placeholder' => 'Localização da Dor','class' => "form-control".($errors->has('localizacao_dor') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('localizacao_dor','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>


</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="evas">Eva</label>
            {!! Form::select('evas', [0,1,2,3,4,5,6,7,8,9,10], null, ['placeholder' => 'Escala Evas','class' => "form-control".($errors->has('evas') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('evas','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="codigo">Edema</label>
            {!! Form::select('edema', $enumEdema, null, ['placeholder' => 'Edema','class' => "form-control".($errors->has('edema') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('edema','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="localizacao_edema">Localização Edema</label>
            {!! Form::text('localizacao_edema', null, ['placeholder' => 'Localização Edema','class' => "form-control".($errors->has('localizacao_edema') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('localizacao_edema','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="medidas_adm">Medidas de ADM</label>
            {!! Form::textarea('medidas_adm', null, ['placeholder' => 'Medidas de ADM', 'rows' => '2', 'class' => "form-control".($errors->has('medidas_adm') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('medidas_adm','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="forca_muscular">Força Muscular</label>
            {!! Form::select('forca_muscular', $enumForcaMuscular, null, ['placeholder' => 'Força Muscular','class' => "form-control".($errors->has('forca_muscular') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('forca_muscular','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="escala_fm">Grau de Força Muscular</label>
            {!! Form::select('escala_fm', [0,1,2,3,4,5], null, ['placeholder' => 'Selecione a Escala','class' => "form-control".($errors->has('escala_fm') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('escala_fm','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="descricao">Descrição</label>
            {!! Form::text('descricao', null, ['placeholder' => 'Descrição','class' => "form-control".($errors->has('descricao') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('descricao','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="atividades_domesticas">Ativ. Domésticas</label>
            {!! Form::select('atividades_domesticas', $enumAtividades, null, ['placeholder' => 'Selecione...','class' => "form-control".($errors->has('atividades_domesticas') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('atividades_domesticas','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="atividades_comunidade">Ativ. em Comunidade</label>
            {!! Form::select('atividades_comunidade', $enumAtividades, null, ['placeholder' => 'Selecione...','class' => "form-control".($errors->has('atividades_comunidade') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('atividades_comunidade','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="auto_cuidado">Auto Cuidado</label>
            {!! Form::select('auto_cuidado', $enumAtividades, null, ['placeholder' => 'Selecione...','class' => "form-control".($errors->has('auto_cuidado') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('auto_cuidado','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="auto_cuidado">Marcha Nível Comunitário</label>
            {!! Form::select('marcha', $enumAtividades, null, ['placeholder' => 'Selecione...','class' => "form-control".($errors->has('marcha') ? ' is-invalid' : '' )])!!}
            {!! $errors->first('marcha','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="tratamento_realizado">Tratamento Realizado</label>
            {!! Form::textarea('tratamento_realizado', null, ['rows' => '2', 'placeholder' => 'Tratamento Realizado','class' => "form-control".($errors->has('tratamento_realizado') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('tratamento_realizado','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="condicoes_alta">Condições de Alta</label>
            {!! Form::textarea('condicoes_alta', null, ['rows' => '2', 'placeholder' => 'Condições de Alta','class' => "form-control".($errors->has('condicoes_alta') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('condicoes_alta','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="data_alta">Data Alta</label>
            {!! Form::text('data_alta', null, ['placeholder' => 'Data Alta','class' => "date form-control".($errors->has('data_alta') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('data_alta','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
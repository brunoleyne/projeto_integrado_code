<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Data Inicial</label>
            {!! Form::text('data_inicial', null, ['placeholder' => 'Data Inicial','class' => "date form-control".($errors->has('data_inicial') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('data_inicial','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="nome">Data Final</label>
            {!! Form::text('data_final', null, ['placeholder' => 'Data Final','class' => "date form-control".($errors->has('data_final') ? ' is-invalid' : '' )]) !!}
            {!! $errors->first('data_final','<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
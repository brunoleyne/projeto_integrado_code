@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Registrar Entrada</li>
    </ol>
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <p id="alert_error">{{ implode('', $errors->all(':message')) }}</p>
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <i class="nav-icon icon-login"></i> <strong>Registrar Entrada</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'registrar.entrada.acao','method'=>'POST', 'id' => 'formEntrada')) !!}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="paciente_id">Paciente</label>
                            {!! Form::select('paciente_id', $pacienteSelect, null, ['id' => 'paciente','class' => "form-control".($errors->has('paciente_id') ? ' is-invalid' : '' )])!!}
                            {!! $errors->first('paciente_id','<div class="invalid-feedback">:message</div>') !!}
                            <span id="msg_digital" style="color: red"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="btn-capturar-digital" class="btn btn-outline-primary">Registrar com Digital</button>
                        <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Registrar</button>
                    </div>
                </div>
                {!! Form::text('fingerprint', null, ['id' => 'fingerprint','class' => "form-control d-none"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" defer>

        class paciente {

            constructor() {
                this.selectPacienteField = $( "select[name='paciente_id']" );
                this.pacienteField = $('#paciente');
                this.fingerprintField = $('#fingerprint');
                this.msgErroField = $('#msg_digital');
                this.alertError = $('#alert_error');
                this.formEntrada = $('#formEntrada');
            }


            autoComplete() {
                this.selectPacienteField.select2({
                    language: "pt-BR",
                    placeholder: "Selecione o Paciente",
                    theme: 'bootstrap4',
                    minimumInputLength: 3,
                    ajax: {
                        url: '{!! route('autocomplete.pacientes') !!}',
                        dataType: 'json',
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
            }

            compararDigital() {
                const self = this;

                $.ajax({
                    url: 'http://localhost:9000/api/public/v1/captura/Comparar?Digital=teste',
                    type: 'GET',
                    success: function (data) {
                        if ( data == false) {
                            this.alertError.text("Digital não confere", "warning");
                        } else {
                            let newOption = new Option('Digital Registrada', data, false, false);
                            $( "select[name='paciente_id']" ).append(newOption).trigger('change');
                            self.formEntrada.submit();
                        }
                    }
                })
            }
        }

        $(document).ready(function(){
            let pacienteClass = new paciente();
            pacienteClass.autoComplete();

            $( "#btn-capturar-digital" ).click(function() {
                pacienteClass.compararDigital();
            });
        });
    </script>
@endsection
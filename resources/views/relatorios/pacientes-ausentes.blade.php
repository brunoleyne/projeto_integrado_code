@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Relatórios</li>
        <li class="breadcrumb-item active">Pacientes Ausentes</li>
    </ol>
    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-list"></i> Lista de Pacientes</strong>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered" id="pacientes-ausentes-table">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data Ausência</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-filter"></i> Filtros</strong>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('method'=>'POST', 'id'=>'filtro-form')) !!}

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    {!! Form::text('nome', null, ['placeholder' => 'Nome','class' => "form-control"]) !!}
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fechamento_mensal">Fechamento Mensal</label>
                                    <select class="form-control" name="fechamento_mensal" id="fechamento_mensal">
                                        <option selected="selected" value="">Fechamento Mensal</option>
                                        @foreach ($fechamentos as $option)
                                            <option value="{{$option->id}}" data-inicial="{{$option->data_inicial}}" data-final="{{$option->data_final}}">{{$option->data_inicial}} à {{$option->data_final}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="data_inicial">Data Inicial</label>
                                    {!! Form::text('data_inicial', null, ['placeholder' => 'Data Inicial','class' => "date form-control"]) !!}
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="data_final">Data Final</label>
                                    {!! Form::text('data_final', null, ['placeholder' => 'Data Final','class' => "date form-control"]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-filter"></i> Filtrar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" defer>
        $(function () {
            let table = $('#pacientes-ausentes-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                language: {
                    "url": "{{ asset('js/dataTables-pt-br.json') }}"
                },
                ajax: {
                    url: '{!! route('pacientes-ausentes.lista') !!}',
                    data: function (d) {
                        d.nome = $('input[name="nome"]').val();
                        d.dataInicial = $('input[name="data_inicial"]').val();
                        d.dataFinal = $('input[name="data_final"]').val();
                    }
                },
                columns: [
                    {data: 'nome', name: 'nome'},
                    {data: 'data', name: 'data', orderable: false},
                ]
            });

            $('#filtro-form').on('submit', function (e) {
                e.preventDefault();
                table.draw();
            });

            $('#fechamento_mensal').change(function() {
                let dataInicial = $('option:selected', this).attr('data-inicial');
                let dataFinal = $('option:selected', this).attr('data-final');
                $( "input[name='data_inicial']" ).val(dataInicial);
                $( "input[name='data_final']" ).val(dataFinal);
            });

        });
    </script>
@endsection
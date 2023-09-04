@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Fechamento Mensal</li>
        <li class="breadcrumb-item active">Listar</li>
    </ol>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-danger" role="alert">
                {{session('message')}}
            </div>

        @endif

        <div class="row">

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-list"></i> Lista de Fechamentos Mensais</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="fechamento-mensal-table">
                            <thead>
                            <tr>
                                <th>Data Inicial</th>
                                <th>Data Final</th>
                                <th>Finalizado</th>
                                <th>Ações</th>
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
                                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-filter"></i>
                                    Filtrar
                                </button>
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
            $(function () {
                let table = $('#fechamento-mensal-table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    language: {
                        "url": "{{ asset('js/dataTables-pt-br.json') }}"
                    },
                    ajax: {
                        url: '{!! route('fechamento-mensal.lista') !!}',
                        data: function (d) {
                            d.data_inicial = $('input[name="data_inicial"]').val();
                            d.data_final = $('input[name="data_final"]').val();
                        }
                    },
                    columns: [
                        {data: 'data_inicial', name: 'data_inicial'},
                        {data: 'data_final', name: 'data_final'},
                        {
                            data: 'finalizado', name: 'finalizado', render: function (data) {
                                return data == 0 ?
                                    'Não' :
                                    'Sim';
                            }
                        },
                        {data: 'action', name: 'action', orderable: false}
                    ]
                });

                $('#filtro-form').on('submit', function (e) {
                    e.preventDefault();
                    table.draw();
                });

            });
        });
    </script>
@endsection
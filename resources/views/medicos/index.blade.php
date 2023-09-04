@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Médicos</li>
        <li class="breadcrumb-item active">Listar</li>
    </ol>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="row">

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-list"></i> Lista de Médicos</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="medicos-table">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CRM</th>
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
                                    <label for="nome">Nome</label>
                                    {!! Form::text('nome', null, ['placeholder' => 'Nome','class' => "form-control"]) !!}
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="cns">CRM</label>
                                    {!! Form::text('crm', null, ['placeholder' => 'CRM','class' => "form-control"]) !!}
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
            let table = $('#medicos-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                language: {
                    "url": "{{ asset('js/dataTables-pt-br.json') }}"
                },
                ajax: {
                    url: '{!! route('medicos.lista') !!}',
                    data: function (d) {
                        d.nome = $('input[name="nome"]').val();
                        d.crm = $('input[name="crm"]').val();
                    }
                },
                columns: [
                    {data: 'nome', name: 'nome'},
                    {data: 'crm', name: 'crm', orderable: false},
                    {data: 'action', name: 'action', orderable: false}
                ]
            });

            $('#filtro-form').on('submit', function (e) {
                e.preventDefault();
                table.draw();
            });

        });
    </script>
@endsection
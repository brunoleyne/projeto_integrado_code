@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Avaliações</li>
        <li class="breadcrumb-item active">Lista</li>
    </ol>
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @endif

        <div class="row">

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <strong><i class="fa fa-list"></i> Lista de Avaliações</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="avaliacoes-table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Data Avaliação</th>
                                <th>Paciente</th>
                                <th>Fisioterapeuta</th>
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
                                    <label for="paciente_id">Paciente</label>
                                    {!! Form::select('paciente_id', [], null, ['class' => "form-control"])!!}
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fisioterapeuta_id">Fisioterapeuta</label>
                                    {!! Form::select('fisioterapeuta_id', [], null, ['class' => "form-control"])!!}
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="cns">Data Avaliação</label>
                                    {!! Form::text('data_avaliacao', null, ['placeholder' => 'Data Avaliação','class' => "date form-control"]) !!}
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

    <script id="details-template" type="text/x-handlebars-template">
        <h4>Evoluções Diárias</h4>
        <table class="table" id="avaliacao-@{{id}}">
            <thead>
            <tr>
                <th>Noº</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Entrada</th>
                <th>Ações</th>
            </tr>
            </thead>
        </table>
    </script>

    <div class="modal fade" id="modalRemoverEvolucao" tabindex="-1" role="dialog" aria-labelledby="Remover Evolução"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remover Evoluçao Diaria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger btn-remover-evolucao">Remover</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalMarcarInfrequente" tabindex="-1" role="dialog" aria-labelledby="Marcar Infrequente"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Marcar infrequente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja marcar como infrequente e remover as evoluções diárias não completadas?</p>
                    <p style="color: red;"><b>Obs: Não se esqueça de alterar data de alta para o paciente na avaliação.</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-danger btn-marcar-infrequente">Sim</button>
                </div>
            </div>
        </div>
    </div>

    @include('avaliacoes.modal-alterar-fisioterapeuta')
    @include('avaliacoes.modal-pausar-tratamento')
    @include('avaliacoes.modal-retomar-tratamento')
    @include('avaliacoes.modal-adicionar-sessoes')

@endsection
@section('script')
    <script type="text/javascript" defer>
        $(function () {
            window.detailTables = new Array();

            let template = Handlebars.compile($("#details-template").html());

            let table = $('#avaliacoes-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                language: {
                    "url": "{{ asset('js/dataTables-pt-br.json') }}"
                },
                ajax: {
                    url: '{!! route('avaliacoes.lista') !!}',
                    data: function (d) {
                        d.paciente_id = $('select[name="paciente_id"]').val();
                        d.fisioterapeuta_id = $('select[name="fisioterapeuta_id"]').val();
                        d.data_avaliacao = $('input[name="data_avaliacao"]').val();
                    }
                },
                columns: [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '<i class="fa fa-plus" aria-hidden="true"></i>'
                    },
                    {data: 'data_avaliacao', name: 'data_avaliacao'},
                    {data: 'paciente', name: 'paciente', orderable: false},
                    {data: 'fisioterapeuta', name: 'fisioterapeuta', orderable: false},
                    {data: 'action', name: 'action', orderable: false}
                ]
            });

            $('#avaliacoes-table').on('click', 'td.details-control', function () {
                let tr = $(this).closest('tr');
                let row = table.row(tr);
                let tableId = 'avaliacao-' + row.data().id;

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    tr.find('td').first().html('<i class="fa fa-plus" aria-hidden="true"></i>');
                } else {
                    row.child(template(row.data())).show();
                    initTable(tableId, row.data());
                    tr.addClass('shown');
                    tr.find('td').first().html('<i class="fa fa-minus" aria-hidden="true"></i>');
                }
            });

            function initTable(tableId, data) {
                detailTable = $('#' + tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    paging: false,
                    searching: false,
                    ordering: false,
                    bInfo: false,
                    ajax: data.details_url,
                    columns: [
                        {data: 'numero_evolucao', name: 'numero_evolucao'},
                        {data: 'data', name: 'data'},
                        {data: 'descricao', name: 'descricao'},
                        {
                            data: 'completa', name: 'completa', render: function (data) {
                                return data == 0 ?
                                    'Não' :
                                    'Sim';
                            }
                        },
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                })

                window.detailTables.push(detailTable);
            }

            $('#filtro-form').on('submit', function (e) {
                e.preventDefault();
                table.draw();
            });

            $(".btn-remover-evolucao").click(function () {
                let id = window.id;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax(
                    {
                        url: "evolucoesdiarias/" + id,
                        type: 'delete',
                        dataType: "JSON",
                        data: {
                            "id": id
                        },
                        success: function (response) {
                            for (var i = 0; i < window.detailTables.length; i++) {
                                window.detailTables[i].ajax.reload();
                            }
                            $('#modalRemoverEvolucao').modal('hide');
                        },
                        error: function (xhr) {
                            for (var i = 0; i < window.detailTables.length; i++) {
                                window.detailTables[i].ajax.reload();
                            }
                            console.error('Houve um erro na requisiçao')
                        }
                    });
            });

            $('#modalRemoverEvolucao, #modalMarcarInfrequente').on('show.bs.modal', function (e) {
                window.id = $(e.relatedTarget).data('id');
            });

            $(".btn-marcar-infrequente").click(function () {
                let id = window.id;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax(
                    {
                        url: "avaliacoes/" + id +"/marcar-infrequente/",
                        type: 'get',
                        success: function (response) {
                            table.ajax.reload();
                            $('#modalMarcarInfrequente').modal('hide');
                        },
                        error: function (xhr) {
                            table.ajax.reload();
                            console.error('Houve um erro na requisiçao')
                        }
                    });
            });
        });
    </script>
@endsection
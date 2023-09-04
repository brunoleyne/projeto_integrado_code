@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        @if (Auth::user()->hasRole(['admin']))
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h4 class="card-title mb-0">Sessões Diária</h4>
                                <div class="small text-muted">{{strftime('%A, %d de %B de %Y', strtotime(date('Y-m-d')))}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                <div class="text-muted">Total</div>
                                <strong>{{$sessoes->total}}</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%"
                                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                <div class="text-muted">Realizadas</div>
                                <strong>{{$sessoes->realizadas}}</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 20%"
                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                <div class="text-muted">Não Realizadas</div>
                                <strong>{{$sessoes->naoRealizadas}}</strong>
                                <div class="progress progress-xs mt-2">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 60%"
                                         aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h4 class="card-title mb-0">Ausentes</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <table class="table table-sm">
                            <caption>Lista de ausentes de {{strftime('%B', strtotime(date('Y-m-d')))}}</caption>
                            <thead>
                            <tr class="table-active">
                                <th scope="col">Nome</th>
                                <th scope="col">Faltas</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($faltas as $falta)
                                <tr>
                                    <th scope="row">{{$falta->nome}}</th>
                                    <td>{{$falta->faltas}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PacienteFalta;
use App\FechamentoMensal;;
use App\EvolucaoDiaria;
use App\RelatorioEvolucoes;
use App\Helpers\Util;
use Yajra\Datatables\Datatables;

class RelatorioController extends Controller
{
    public function getPacientesAusentes() {
        $fechamentos = FechamentoMensal::select('data_inicial','data_final', 'id')->latest()->get();

        return view('relatorios.pacientes-ausentes', compact('fechamentos'));
    }

    public function getPacientesAusentesList(Request $request)
    {
        $pacientes = PacienteFalta::listaPacientesAusentes();

        return Datatables::of($pacientes)
            ->filter(function ($query) use ($request) {
                if (!empty($request->nome)) {
                    $query->where('nome', 'like', "%$request->nome%");
                }
                if (!empty($request->dataInicial) && !empty($request->dataFinal)) {
                    $query->whereBetween('data', [Util::convertDateMySql($request->dataInicial), Util::convertDateMySql($request->dataFinal)]);
                }
            })
            ->make(true);
    }

    public function getRelatorioMensal(Request $request)
    {
        $sessoes = new \StdClass;
        if (isset($request->data_inicial)) {
            $request->validate([
                'data_inicial' => 'required|data',
                'data_final' => 'required|data',
            ]);
            $dataInicial = Util::convertDateMySql($request->data_inicial);
            $dataFinal = Util::convertDateMySql($request->data_final);

            $sessoes->total = RelatorioEvolucoes::whereBetween('data_evolucao', [ $dataInicial, $dataFinal])->count();

            $sessoes->realizadas = RelatorioEvolucoes::whereBetween('data_evolucao', [ $dataInicial, $dataFinal])->where(['evolucao_completa' => 1])->get();
            $sessoes->naoRealizadas = RelatorioEvolucoes::whereBetween('data_evolucao', [ $dataInicial, $dataFinal])->where(['evolucao_completa' => 0])->get();
            $sessoes->tipoM = RelatorioEvolucoes::whereBetween('data_evolucao', [ $dataInicial, $dataFinal])->where(['evolucao_completa' => 1, 'tipo_cid' => 'M' ])->count();
            $sessoes->tipoS = RelatorioEvolucoes::whereBetween('data_evolucao', [ $dataInicial, $dataFinal])->where(['evolucao_completa' => 1, 'tipo_cid' => 'S' ])->count();

        }
        return view('relatorios.mensal', compact('sessoes'));
    }
}

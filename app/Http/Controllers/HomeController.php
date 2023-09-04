<?php

namespace App\Http\Controllers;

use App\RelatorioEvolucoes;
use Illuminate\Http\Request;
use Auth;
use App\FechamentoMensal;
use App\PacienteFalta;
use App\EvolucaoDiaria;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Relatorio Pacientes Diario
        $sessoes = new \StdClass;
        $dataAtual = date('Y-m-d');
        $sessoes->total = RelatorioEvolucoes::where(['data_evolucao' => $dataAtual])->count();
        $sessoes->realizadas = RelatorioEvolucoes::where(['data_evolucao' => $dataAtual, 'evolucao_completa' => 1])->count();
        $sessoes->naoRealizadas = RelatorioEvolucoes::where(['data_evolucao' => $dataAtual, 'evolucao_completa' => 0])->count();

        // Faltas (Ausentes do mes)
        $faltas = PacienteFalta::join('pacientes', 'paciente_faltas.paciente_id', '=', 'pacientes.id')
            ->whereYear('paciente_faltas.data', date("Y"))
            ->whereMonth('paciente_faltas.data', date("m"))
            ->groupBy('paciente_faltas.paciente_id', 'pacientes.nome')
            ->select( 'pacientes.nome', DB::raw('count(*) as faltas'))
            ->get();

        return view('home', compact('sessoes', 'faltas' ));
    }
}

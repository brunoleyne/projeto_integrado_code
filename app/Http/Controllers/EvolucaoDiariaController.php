<?php

namespace App\Http\Controllers;

use App\Avaliacao;
use App\FechamentoMensal;
use App\Helpers\Util;
use App\Paciente;
use Illuminate\Http\Request;
use App\EvolucaoDiaria;
use App\Helpers\Carbon;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Support\Facades\DB;

class EvolucaoDiariaController extends Controller
{
    /**
     * Registrar entrada diaria de um paciente
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function registrarEntrada(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required'
        ]);

        $evolucaoCollection = DB::table('evolucoes_diarias')->select('evolucoes_diarias.id')->where('evolucoes_diarias.data', Carbon::now()->toDateString())
            ->whereIn('avaliacao_id', function ($query) use ($request) {
                $query->select('avaliacoes.id')->from('avaliacoes')->where('paciente_id', $request->paciente_id);
            })->get();

        if ($evolucaoCollection->count() == 0) {
            return back()->withErrors(['Não foi encontrada terapia para o paciente no dia de hoje! Favor rever ficha do paciente.']);
        }

        foreach ($evolucaoCollection as $evolucaoId) {
            $evolucao = EvolucaoDiaria::find($evolucaoId->id);
            $evolucao->completa = 1;

            //Verificar se existe uma pré-avaliação para o dia
            if (array_search($evolucao->numero_evolucao, EvolucaoDiaria::$condutaMantida) !== false) {
                $evolucao->descricao = 'Conduta Mantida';
            }

            $evolucao->save();
        }

        return redirect()->route('registrar.entrada')
            ->with('success', 'Entrada registrada com sucesso!');
    }

    /**
     * Registrar entrada diaria de um paciente
     *
     * @return \Illuminate\Http\Response
     */
    public function selecionarPacienteEntrada()
    {
        $pacienteSelect = array();
        return view('evolucoes_diarias.index', compact('pacienteSelect'));
    }

    /**
     * Carrega digitais do dia
     *
     * @return \Illuminate\Http\Response
     */
    public function carregarDigitaisPacientes(Request $request)
    {
        $fingerPrint = Paciente::find($request->paciente_id)->fingerprint;
        return response()->json(['digitais' => $fingerPrint]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evolucao = EvolucaoDiaria::find($id);
        $fechamentos = FechamentoMensal::pluck('data_final', 'id');
        return view('evolucoes_diarias.editar', compact('evolucao', 'fechamentos'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'data' => 'required|data',
            'descricao' => 'max:240',
            'fechamento_id' => 'required',
            'completa' => 'required|boolean',
        ]);

        $evolucao = EvolucaoDiaria::find($id);
        $evolucao->update([
            'data' => $request->data,
            'descricao' => $request->descricao,
            'fechamento_id' => $request->fechamento_id,
            'completa' => $request->completa,
        ]);
        return back()->with('success', 'Evolução Diária atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evolucao = EvolucaoDiaria::find($id);
        $evolucao->delete();
        return response()->json([
            'success' => 'Record has been deleted successfully!'
        ]);
    }

    /**
     * Adiciona Evoluções
     *
     * @param String $id
     * @return \Illuminate\Http\Response
     */
    public function adicionarEvolucao(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataSessao = Util::convertDateMySql($request->data_sessao);
            $dataSessao = new Carbon($dataSessao);

            $dataSeguinte = $dataSessao->addDays(1)->toDateString();
            $dataSeguinte = Util::convertDatePtBr($dataSeguinte);

            $dataAvaliacoes = AvaliacaoController::calcularDiasAvaliacao($request->numero_avaliacoes - 2, $dataSeguinte, $request->dias_semana);

            if (isset($dataAvaliacoes[0])) {
                $fechamentoMensal = FechamentoMensal::where('data_final', '>=', $dataAvaliacoes[0])->orderBy('data_final', 'asc')->first();
            } else {
                $fechamentoMensal = FechamentoMensal::where('data_final', '>=', $dataSessao)->orderBy('data_final', 'asc')->first();
            }

            if (!$fechamentoMensal) {
                return back()->with('error', "Não existe uma Data de Fechamento pré-cadastrada. Favor cadastrar um fechamento mensal para o dia {$request->data_sessao}");
            }

            $ultimaEvolucao = EvolucaoDiaria::where('avaliacao_id', $request->avaliacao_id)->orderBy('numero_evolucao', 'desc')->first();
            $numeroUltimaEvolucao = $ultimaEvolucao->numero_evolucao;
            $fisioterapeutaId = $ultimaEvolucao->fisioterapeuta_id;
            $dataInicial = Util::convertDateMySql($request->data_sessao);
            $dataCalculada = new Carbon($dataInicial);

            EvolucaoDiaria::create([
                'avaliacao_id' => $request->avaliacao_id,
                'fechamento_id' => $fechamentoMensal->id,
                'fisioterapeuta_id' => $fisioterapeutaId,
                'numero_evolucao' => $numeroUltimaEvolucao + 1,
                'data' => $dataCalculada,
                'completa' => 0,
            ]);

            $numeroLoops = $request->numero_avaliacoes - 1;
            if ($numeroLoops > 0) {
                for ($x = 0; $x < $numeroLoops; $x++) {
                    EvolucaoDiaria::create([
                        'avaliacao_id' => $request->avaliacao_id,
                        'fechamento_id' => $fechamentoMensal->id,
                        'fisioterapeuta_id' => $fisioterapeutaId,
                        'numero_evolucao' => $numeroUltimaEvolucao + 2 + $x,
                        'data' => $dataAvaliacoes[$x],
                        'completa' => 0,
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Sessões adicionadas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Houveu um erro! {$e->getMessage()}");
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\EvolucaoDiaria;
use App\FechamentoMensal;
use App\Medico;
use App\Paciente;
use App\User;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests\StoreAvaliacao;
use App\Http\Requests\UpdateAvaliacao;
use App\Avaliacao;
use App\Helpers\Util;
use App\Helpers\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fisioterapeutaSelect = array();
        return view('avaliacoes.index',  compact('fisioterapeutaSelect'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Tratamento recuperar opção selecionada select2
        $oldInput = Session::getOldInput();
        $pacienteSelect = array();
        $medicoSelect = array();
        $fisioterapeutaSelect = array();

        if (isset($oldInput['paciente_id'])) {
            $paciente = Paciente::find($oldInput['paciente_id']);
            $pacienteSelect = [$paciente->id => $paciente->nome];
        }

        if (isset($oldInput['medico_id'])) {
            $medico = Medico::find($oldInput['medico_id']);
            $medicoSelect = [$medico->id => $medico->nome];
        }

        if (isset($oldInput['fisioterapeuta_id'])) {
            $fisioterapeuta = User::find($oldInput['fisioterapeuta_id']);
            $fisioterapeutaSelect = [$fisioterapeuta->id => $fisioterapeuta->name];
        }

        // Popular Selects Simples
        $enumSituacao = Avaliacao::$enumSituacao;

        return view('avaliacoes.criar', compact('pacienteSelect', 'medicoSelect', 'fisioterapeutaSelect',
                'enumSituacao'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvaliacao $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                "paciente_id" => $request->paciente_id,
                "medico_id" => $request->medico_id,
                "fisioterapeuta_id" => $request->fisioterapeuta_id,
                "data_avaliacao" => $request->data_avaliacao,
                "origem" => $request->origem,
                "cmc" => $request->cmc
            ];
            if (isset($request->origem_outros)) {
                $data['origem_outros'] =  $request->origem_outros;
            }
            $avaliacao = Avaliacao::create($data);

            $dataAvaliacoes = self::calcularDiasAvaliacao($request->numero_avaliacoes, $request->data_avaliacao, $request->dias_semana);

            // Primeira guia de 20 terapias
            $fechamentoMensal = FechamentoMensal::where('data_final', '>=', $dataAvaliacoes[19])
                ->orderBy('data_final', 'asc')->first();
            if (!$fechamentoMensal) {
                return back()->withErrors(["Não existe uma Data de Fechamento pré-cadastrada. Favor cadastrar um fechamento mensal para o dia " . Util::convertDateTimePtBr($dataAvaliacoes[19])]);
            }

            EvolucaoDiaria::create([
                'avaliacao_id' => $avaliacao->id,
                'fechamento_id' => $fechamentoMensal->id,
                'fisioterapeuta_id' => $request->fisioterapeuta_id,
                'numero_evolucao' => 1,
                'data' => $dataAvaliacoes[0],
                'completa' => 1,
                'descricao' => 'Avaliação',
            ]);

            for ($x = 2; $x <= 20; $x++) {
                EvolucaoDiaria::create([
                    'avaliacao_id' => $avaliacao->id,
                    'fechamento_id' => $fechamentoMensal->id,
                    'fisioterapeuta_id' => $request->fisioterapeuta_id,
                    'numero_evolucao' => $x,
                    'data' => $dataAvaliacoes[$x - 1],
                    'completa' => 0,
                ]);
            }

            // Segunda guia de 40 terapias
            if (isset($dataAvaliacoes[39])) {
                $segundoFechamentoMensal = FechamentoMensal::where('data_final', '>=', $dataAvaliacoes[39])
                    ->orderBy('data_final', 'asc')->first();

                if (!$segundoFechamentoMensal) {
                    return back()->withErrors(["Não existe uma Data de Fechamento pré-cadastrada. Favor cadastrar um fechamento mensal para o dia " . Util::convertDateTimePtBr($dataAvaliacoes[39])]);
                }

                for ($x = 21; $x <= 40; $x++) {
                    EvolucaoDiaria::create([
                        'avaliacao_id' => $avaliacao->id,
                        'fechamento_id' => $segundoFechamentoMensal->id,
                        'fisioterapeuta_id' => $request->fisioterapeuta_id,
                        'numero_evolucao' => $x,
                        'data' => $dataAvaliacoes[$x - 1],
                        'completa' => 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('avaliacoes.index')
                ->with('success', 'Avaliação cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    public static function calcularDiasAvaliacao($numeroAvaliacoes, $dataInicial, $diasSemana)
    {
        $dataInicial = Util::convertDateMySql($dataInicial);
        $dataCalculada = new Carbon($dataInicial);
        $listDatasCalculadas[] = $dataCalculada->copy();

        $listDatasCalculadas = [];
        while (count($listDatasCalculadas) <= $numeroAvaliacoes) {
            $diaDaSemana = $dataCalculada->dayOfWeek;

            if ((array_search($diaDaSemana, $diasSemana) !== false) && $dataCalculada->copy()->isHoliday() === false) {
                $listDatasCalculadas[] = $dataCalculada->copy();
            }
            $dataCalculada->addDays(1);
        }

        return $listDatasCalculadas;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $avaliacao = Avaliacao::find($id);
        if ($avaliacao->fisioterapeuta_id != Auth::user()->id && !Auth::user()->hasRole(['admin'])) {
            return redirect()->route('avaliacoes.index')
                ->with('success', 'Você não possui permissão!');
        }
        // Popular Selects Simples
        $enumAtividades = Avaliacao::$enumAtividades;
        $enumSituacao = Avaliacao::$enumSituacao;
        $enumDor = Avaliacao::$enumDor;
        $enumForcaMuscular = Avaliacao::$enumForcaMuscular;
        $enumEdema = Avaliacao::$enumEdema;

        return view('avaliacoes.editar', compact(
                'enumAtividades', 'enumSituacao', 'enumDor', 'enumForcaMuscular', 'avaliacao', 'enumEdema'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvaliacao $request, $id)
    {

        $avaliacao = Avaliacao::find($id);

        if ($avaliacao->fisioterapeuta_id != Auth::user()->id && !Auth::user()->hasRole(['admin'])) {
            return redirect()->route('avaliacoes.index')
                ->with('success', 'Você não possui permissão!');
        }

        $avaliacao->diagnostico = $request->input('diagnostico');
        $avaliacao->queixas = $request->input('queixas');
        $avaliacao->anamnese = $request->input('anamnese');
        $avaliacao->dor = $request->input('dor');
        $avaliacao->codigo = $request->input('codigo');
        $avaliacao->localizacao_dor = $request->input('localizacao_dor');
        $avaliacao->evas = $request->input('evas');
        $avaliacao->edema = $request->input('edema');
        $avaliacao->localizacao_edema = $request->input('localizacao_edema');
        $avaliacao->medidas_adm = $request->input('medidas_adm');
        $avaliacao->forca_muscular = $request->input('forca_muscular');
        $avaliacao->escala_fm = $request->input('escala_fm');
        $avaliacao->descricao = $request->input('descricao');
        $avaliacao->atividades_domesticas = $request->input('atividades_domesticas');
        $avaliacao->atividades_comunidade = $request->input('atividades_comunidade');
        $avaliacao->auto_cuidado = $request->input('auto_cuidado');
        $avaliacao->marcha = $request->input('marcha');
        $avaliacao->tratamento_realizado = $request->input('tratamento_realizado');
        $avaliacao->condicoes_alta = $request->input('condicoes_alta');
        $avaliacao->data_alta = $request->input('data_alta');
        $avaliacao->situacao = $request->input('situacao');
        $avaliacao->cid = $request->input('cid');

        // Regra Negocio Tipo CID S ou M
        $ultimosCharsCodigo = substr($request->input('codigo'), -2);
        $tipo_cid = 'M';
        if ($ultimosCharsCodigo === '19') {
            $tipo_cid = 'S';
        }
        $avaliacao->tipo_cid = $tipo_cid;

        $avaliacao->save();
        return redirect()->route('avaliacoes.index')
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Process datatables ajax request.
     *
     * @throws \Exception if the code is invalid PHP
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvaliacoesList(Request $request)
    {
        $avaliacoes = Avaliacao::ForDataTables();

        if (Auth::user()->hasRole(['fisioterapeuta'])) {
            $avaliacoes->where('avaliacoes.fisioterapeuta_id', '=', Auth::user()->id);
        }
        return Datatables::of($avaliacoes)
            ->addColumn('details_url', function ($avaliacao) {
                return url('lista/evolucoes/' . $avaliacao->id);
            })
            ->addColumn('action', function ($avaliacao) {
                //$acoes = '<a href="' . route("avaliacoes.show", $avaliacao->id) . '" target="_blank" class="btn btn-xs btn-primary acao-btn"><i class="glyphicon glyphicon-edit"></i> Visualizar</a>';
                $acoes = '';
                $acoes .= '<a href="' . route("avaliacoes.edit", $avaliacao->id) . '" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i></a>';
                if ((Auth::user()->hasRole(['admin']))) {
                    $acoes .= '<button type="button" class="btn btn-danger btn-margin-left" data-toggle="modal" data-target="#modalMarcarInfrequente" data-id="' . $avaliacao->id . '" data-toggle="tooltip" data-placement="top" title="Marcar como Infrequente"><i class="fa fa-remove"></i></button>';
                    $acoes .= '<button type="button" class="btn btn-success btn-margin-left" data-toggle="modal" data-target="#modalAlterarFisioterapeuta" data-id="' . $avaliacao->id . '" data-toggle="tooltip" data-placement="top" title="Alterar Fisioterapeuta"><i class="fa fa-address-book-o"></i></button>';
                    if ($avaliacao->pausa == 0) {
                        $acoes .= '<button type="button" class="btn btn-warning btn-margin-left" data-toggle="modal" data-target="#modalPausarTratamento" data-id="' . $avaliacao->id . '" data-toggle="tooltip" data-placement="top" title="Pausar Tratamento"><i class="fa fa-pause"></i></button>';
                    } else {
                        $acoes .= '<button type="button" class="btn btn-warning btn-margin-left" data-toggle="modal" data-target="#modalRetomarTratamento" data-id="' . $avaliacao->id . '" data-toggle="tooltip" data-placement="top" title="Retomar Tratamento"><i class="fa fa-play"></i></button>';
                    }
                    $acoes .= '<button type="button" class="btn btn-dark btn-margin-left" data-toggle="modal" data-target="#modalAdicionarSessoes" data-id="' . $avaliacao->id . '" data-toggle="tooltip" data-placement="top" title="Adicionar Evoluções"><i class="fa fa-plus"></i></button>';
                }
                return $acoes;
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->paciente_id)) {
                    $query->where('paciente_id', $request->paciente_id);
                }
                if (!empty($request->fisioterapeuta_id)) {
                    $query->where('fisioterapeuta_id', $request->fisioterapeuta_id);
                }
                if (!empty($request->data_avaliacao)) {
                    $query->whereDate('data_avaliacao', '=', Util::convertDateMySql($request->data_avaliacao));
                }
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request.
     *
     * @throws \Exception if the code is invalid PHP
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvolucoesList($avaliacaoId)
    {
        $evolucoes = EvolucaoDiaria::where('avaliacao_id', $avaliacaoId)->select(['id', 'numero_evolucao', 'data', 'descricao', 'completa'])->orderBy('numero_evolucao');

        if (Auth::user()->hasRole(['fisioterapeuta'])) {
            $evolucoes->where('completa', 1);
        }

        return Datatables::of($evolucoes)
            ->addColumn('action', function ($evolucao) {
                $acoes = '<a href="' . route("evolucoesdiarias.edit", $evolucao->id) . '" target="_blank" class="btn btn-info"><i class="fa fa-edit"></i></a>';
                $acoes .= '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalRemoverEvolucao" data-id="' . $evolucao->id . '"><i class="fa fa-eraser"></button>';

                return $acoes;
            })
            ->make(true);
    }

    public function marcarInfrequente($avaliacaoId)
    {
        EvolucaoDiaria::where([
            'avaliacao_id' => $avaliacaoId,
            'completa' => 0,
        ])->delete();

        return response()->json([
            'success' => 'Evoluções Removidas'
        ]);

    }

    /**
     * Altera Fisioterapeuta
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function alterarFisioterapeuta(Request $request)
    {
        $id =  $request->input('avaliacao_id');
        $avaliacao = Avaliacao::find($id);
        $avaliacao->fisioterapeuta_id = $request->input('fisioterapeuta_id');
        $avaliacao->save();
        return redirect()->route('avaliacoes.index')
            ->with('success', 'Alteração feita com sucesso!');
    }

    /**
     * Pausar Tratamento de uma Avaliação
     *
     * @param  String $id
     * @return \Illuminate\Http\Response
     */
    public function pausarTratamento($id)
    {
        $avaliacao = Avaliacao::find($id);
        $avaliacao->pausa = 1;
        $avaliacao->save();

        DB::table('evolucoes_diarias')
            ->where('avaliacao_id', $id)
            ->where('completa', 0)
            ->where('pausa', 0)
            ->update(['pausa' => 1]);

        return response()->json([
            'success' => 'Tratamento Pausado com sucesso!'
        ]);
    }

    /**
     * Retomar Tratamento de uma Avaliação
     *
     * @param  String $id
     * @return \Illuminate\Http\Response
     */
    public function retomarTratamento($id)
    {
        $avaliacao = Avaliacao::find($id);
        $avaliacao->pausa = 0;
        $avaliacao->save();

        DB::table('evolucoes_diarias')
            ->where('avaliacao_id', $id)
            ->where('completa', 0)
            ->where('pausa', 1)
            ->update(['pausa' => 0]);

        return response()->json([
            'success' => 'Tratamento Retomado com sucesso!'
        ]);
    }

}

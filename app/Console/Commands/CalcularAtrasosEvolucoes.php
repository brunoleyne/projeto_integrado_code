<?php

namespace App\Console\Commands;

use App\Avaliacao;
use App\EvolucaoDiaria;
use App\PacienteFalta;
use App\Helpers\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalcularAtrasosEvolucoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calcular:evolucoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcula falta de pacientes e atrasos nas Evoluçoes Diarias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            //Deletar Evoluções Diárias incompletas de pacientes que tiveram alta
            $avaliacoesCompletas = Avaliacao::where('data_alta', Carbon::now()->toDateString())
                ->get();

            foreach ($avaliacoesCompletas as $avaliacao) {
                $evolucoesIncompletas = $avaliacao->evolucoes->filter(function($item) {
                    return $item->completa == 0;
                })->all();
                foreach ($evolucoesIncompletas as $removerEvolucao)
                    $removerEvolucao->delete();
            }

            // Pegar Evoluçoes ausentes do dia
            $evolucoesAusentes = EvolucaoDiaria::where('data', Carbon::now()->toDateString())->where('completa', 0)
                ->where('completa', 0)
                ->get();

            foreach ($evolucoesAusentes as $evolAusente) {
                // Pegar a lista de todas as evoluçoes de determinada avaliacao
                $evolucoes = EvolucaoDiaria::where('avaliacao_id', $evolAusente->avaliacao_id)
                    ->where('numero_evolucao', '>', $evolAusente->numero_evolucao)->orderBy('numero_evolucao')->get();
                $ultimaEvolucao = $evolAusente->numero_evolucao;
                $dataUltimaEvolucao = $evolAusente->data;

                // Trocar numero de evoluçao
                foreach ($evolucoes as $evol) {
                    $evol->numero_evolucao -= 1;
                    $evol->save();
                    $ultimaEvolucao = $evol->numero_evolucao;
                    $dataUltimaEvolucao = $evol->data;
                }

                // Alterar data evolucao ausente para proximo dia util
                $dataUltimaEvolucaoCarbon = Carbon::createFromFormat('d/m/Y', $dataUltimaEvolucao);
                $proximaDataUtil = $dataUltimaEvolucaoCarbon->proximoDiaUtil();

                $evolAusente->numero_evolucao = $ultimaEvolucao + 1;
                $evolAusente->data = $proximaDataUtil;
                $evolAusente->save();

                //Adicionar Falta
                PacienteFalta::create([
                    'paciente_id' => $evolAusente->avaliacao->paciente_id,
                    'data' => Carbon::now(),
                ]);
            }
            DB::commit();
            $this->info('Rotina calculo de evolucoes completo.');
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Avaliacao;
use App\EvolucaoDiaria;
use App\PacienteFalta;
use App\Helpers\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixSequenciaNumeroEvolucoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:sequeciaEvolucoes';

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
            $avaliacoes = Avaliacao::all();

            foreach ($avaliacoes as $avaliacao) {
                $evolucoes = $avaliacao->evolucoes()->orderBy('data')->get();
                $numero = 1;
                foreach ($evolucoes as $evolucao) {
                    $evolucao->numero_evolucao = $numero;
                    $evolucao->save();
                    $numero++;
                }
            }
            DB::commit();
            $this->info('Executado com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}

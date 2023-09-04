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

class APIDigitalController extends Controller
{
    /**
     * Output fingerprints json
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //key=g3KmDDTaD1
        $listaFingerprints = EvolucaoDiaria::carregarListaDiariaDigitaisPacientes();

        return response()->json([
            'digitais' => $listaFingerprints
        ]);
    }
}

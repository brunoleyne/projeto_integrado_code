<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreUpdatePaciente;
use App\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pacientes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pacientes.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdatePaciente  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdatePaciente $request)
    {
        Paciente::create($request->all());
        return redirect()->route('pacientes.index')
            ->with('success','Paciente cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Paciente $paciente)
    {
        return view('pacientes.editar',compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdatePaciente  $request
     * @param  \App\Paciente
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePaciente $request, Paciente $paciente)
    {
        $paciente->update($request->all());
        return redirect()->route('pacientes.index')
            ->with('success','Paciente atualizado com sucesso!');
    }


    /**
     * Process datatables ajax request.
     *
     * @throws \Exception if the code is invalid PHP
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPacientesList(Request $request)
    {
        $pacientes = Paciente::select(['id', 'nome', 'cns', 'telefone']);

        return Datatables::of($pacientes)
            ->addColumn('action', function ($paciente) {
                return '<a href="'.route("pacientes.edit",$paciente->id).'" class="btn btn-info"><i class="fa fa-edit"></i></a>';
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->nome)) {
                    $query->where('nome', 'like', "%$request->nome%");
                }
                if (!empty($request->cns)) {
                    $query->where('cns', $request->cns);
                }
            })
            ->make(true);
    }

    /**
     * Cria uma lista AutoComplete para pacientes.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAutoCompletePacientes(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $pacientes = Paciente::where('nome','LIKE',"%$term%")->limit(5)->get();

        $formatted_tags = [];

        foreach ($pacientes as $row) {
            $formatted_tags[] = ['id' => $row->id, 'text' => $row->nome];
        }

        return \Response::json($formatted_tags);
    }
}

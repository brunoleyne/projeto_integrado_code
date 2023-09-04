<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreUpdateMedico;
use App\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('medicos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medicos.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateMedico
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateMedico $request)
    {
        Medico::create($request->all());
        return redirect()->route('medicos.index')
            ->with('success','Médico cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medico $medico
     * @return \Illuminate\Http\Response
     */
    public function edit(Medico $medico)
    {
        return view('medicos.editar',compact('medico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateMedico
     * @param  \App\Medico $medico
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateMedico $request, Medico $medico)
    {
        $medico->update($request->all());
        return redirect()->route('medicos.index')
            ->with('success','Médico atualizado com sucesso!');
    }

    /**
     * Process datatables ajax request.
     *
     * @throws \Exception if the code is invalid PHP
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMedicosList(Request $request)
    {
        $medicos = Medico::select(['id', 'nome', 'crm']);

        return Datatables::of($medicos)
            ->addColumn('action', function ($medico) {
                return '<a href="'.route("medicos.edit",$medico->id).'" class="btn btn-info"><i class="fa fa-edit"></i></a>';
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->nome)) {
                    $query->where('nome', 'like', "%$request->nome%");
                }
                if (!empty($request->crm)) {
                    $query->where('crm', $request->crm);
                }
            })
            ->make(true);
    }

    /**
     * Cria uma lista AutoComplete para Médicos.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAutoCompleteMedicos(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $medicos = Medico::where('nome','LIKE',"%$term%")->limit(5)->get();

        $formatted_tags = [];

        foreach ($medicos as $row) {
            $formatted_tags[] = ['id' => $row->id, 'text' => $row->nome];
        }

        return \Response::json($formatted_tags);
    }
}

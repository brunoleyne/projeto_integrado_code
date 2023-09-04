<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FechamentoMensal;
use App\Http\Requests\StoreUpdateFechamentoMensal;
use Yajra\Datatables\Datatables;
use App\Helpers\Util;

class FechamentoMensalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fechamento_mensal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fechamento_mensal.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateFechamentoMensal $request)
    {
        FechamentoMensal::create($request->all());
        return redirect()->route('fechamento-mensal.index')
            ->with('success','Fechamento Mensal registrado com sucesso!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fechamentoMensal = FechamentoMensal::find($id);
        return view('fechamento_mensal.editar',compact('fechamentoMensal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fechamentoMensal = FechamentoMensal::find($id);
        $fechamentoMensal->update($request->all());
        return redirect()->route('fechamento-mensal.index')
            ->with('success','Fechamento Mensal Atualizado com sucesso!');
    }

    /**
     * Process datatables ajax request.
     *
     * @throws \Exception if the code is invalid PHP
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFechamentoMensalList(Request $request)
    {
        $fechamentos = FechamentoMensal::select(['id', 'data_inicial', 'data_final', 'finalizado']);

        return Datatables::of($fechamentos)
            ->addColumn('action', function ($fechamento) {
                return '<a href="'.route("fechamento-mensal.edit",$fechamento->id).'" class="btn btn-info"><i class="fa fa-edit"></i></a>';
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->data_inicial)) {
                    $query->whereDate('data_inicial', Util::convertDateMySql($request->data_inicial));
                }
                if (!empty($request->data_final)) {
                    $query->whereDate('data_final', Util::convertDateMySql($request->data_final));
                }
            })
            ->make(true);
    }

}

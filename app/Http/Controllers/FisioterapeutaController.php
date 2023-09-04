<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Requests\StoreFisioterapeuta;
use Yajra\Datatables\Datatables;

class FisioterapeutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fisioterapeutas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fisioterapeutas.criar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFisioterapeuta  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFisioterapeuta $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'crefito' => $request->crefito,
        ]);


        $user->assignRole($request->role);
        return redirect()->route('fisioterapeutas.index')
            ->with('success','Fisioterapeuta cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $fisioterapeuta)
    {
        return view('fisioterapeutas.editar',compact('fisioterapeuta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $fisioterapeuta)
    {
        $request->validate([
            'crefito' => 'max:15'
        ]);

        $fisioterapeuta->crefito = $request->crefito;

        if ($request->has('password')) {
            $fisioterapeuta->password = Hash::make($request->password);
        }

        $fisioterapeuta->save();
        return redirect()->route('fisioterapeutas.index')
            ->with('success','Fisioterapeuta atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Process datatables ajax request.
     *
     * @throws \Exception if the code is invalid PHP
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFisioterapeutaList(Request $request)
    {
        $fisioterapeutas= User::select(['id', 'name', 'email', 'crefito']);

        return Datatables::of($fisioterapeutas)
            ->addColumn('action', function ($fisioterapeutas) {
                return '<a href="'.route("fisioterapeutas.edit",$fisioterapeutas->id).'" class="btn btn-info"><i class="fa fa-edit"></i></a>';
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->name)) {
                    $query->where('name', 'like', "%$request->name%");
                }
                if (!empty($request->email)) {
                    $query->where('email', $request->email);
                }
                if (!empty($request->crefito)) {
                    $query->where('crefito', $request->crefito);
                }
            })
            ->make(true);
    }

    /**
     * Cria uma lista AutoComplete para Fisioterapeutas.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAutoCompleteFisioterapeutas(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $pacientes = User::where('name','LIKE',"%$term%")->limit(5)->get();

        $formatted_tags = [];

        foreach ($pacientes as $row) {
            $formatted_tags[] = ['id' => $row->id, 'text' => $row->name];
        }

        return \Response::json($formatted_tags);
    }
}

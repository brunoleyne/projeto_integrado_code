<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile()
    {
        $user = Auth::user();
        return view('configuracoes.minha-conta',compact('user' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = Auth::user();
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->save();

        return back()->with('success','Conta atualizada com sucesso!');
    }
}

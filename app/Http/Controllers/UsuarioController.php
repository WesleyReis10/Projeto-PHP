<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //

    public function home()
    {
        $usuarios = Usuario::all();
        return view('usuario.home', compact('usuarios'));
    }

    public function adicionar()
    {
        return view('usuario.adicionar');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'password' => 'required',
            'empresaid' => 'required',
            'nivel_acesso' => 'required',
        ]);

        $usuario = new Usuario([
            //'nome' =>  $request->get('nome'),
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'empresaid' => $request->empresaid,
            'nivel_acesso' => $request->nivel_acesso,
        ]);

        if ($usuario->save()) {
            return redirect()->route('usuariohome')->with('create', 'Usuario criado.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Não foi possível criar este usuario. Tente novamente.');
        }
    }

    public function editar($id)
    {
        $usuario = Usuario::find($id);

        if ($usuario) {
            return view('usuario.editar', compact('usuario'));
        } else {
            return redirect()->route('usuariohome')->with('error', 'Usuario não encontrado. Tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'password' => 'required',
            'empresaid' => 'required',
            'nivel_acesso' => 'required',
        ]);

        $usuario = Usuario::find($id);

        if ($usuario) {
            $usuario->nome = $request->nome;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request['password']);
            $usuario->empresaid = $request->empresaid;
            $usuario->nivel_acesso = $request->nivel_acesso;
            $usuario->save();
            return redirect()->route('usuariohome')->with('update', 'Usuario alterado.');
        } else {
            return redirect()->route('usuariohome')->with('error', 'Não foi possível alterar este usuario. Tente novamente.');
        }
    }

    public function delete(Request $request)
    {
        $id = $request['usuario_id'];
        $usuario = Usuario::find($id);

        if ($usuario) {
            $usuario->delete();
            return redirect()->route('usuariohome')->with('delete', 'Usuario deletado.');
        } else {
            return redirect()->route('usuariohome')->with('error', 'Não foi possível deletar este usuario. Tente novamente.');
        }
    }
}

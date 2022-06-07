<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function home()
    {
        $categorias = Categoria::all();
        return view('categoria.home', compact('categorias'));
    }

    public function adicionar()
    {
        return view('categoria.adicionar');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $categoria = new Categoria([
            //'nome' =>  $request->get('nome'),
            'nome' => $request->nome,
        ]);

        if ($categoria->save()) {
            return redirect()->route('categoriahome')->with('create', 'Categoria criada.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Não foi possível criar esta categoria. Tente novamente.');
        }
    }

    public function editar($id)
    {
        $categoria = Categoria::find($id);

        if ($categoria) {
            return view('categoria.editar', compact('categoria'));
        } else {
            return redirect()->route('categoriahome')->with('error', 'Categoria não encontrada. Tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $categoria = Categoria::find($id);

        if ($categoria) {
            $categoria->nome = $request->nome;
            $categoria->save();
            return redirect()->route('categoriahome')->with('update', 'Categoria alterada.');
        } else {
            return redirect()->route('categoriahome')->with('error', 'Não foi possível alterar esta categoria. Tente novamente.');
        }
    }

    public function delete(Request $request)
    {
        $id = $request['categoria_id'];
        $categoria = Categoria::find($id);

        if ($categoria) {
            $categoria->delete();
            return redirect()->route('categoriahome')->with('delete', 'Categoria deletada.');
        } else {
            return redirect()->route('categoriahome')->with('error', 'Não foi possível deletar esta categoria. Tente novamente.');
        }
    }
}

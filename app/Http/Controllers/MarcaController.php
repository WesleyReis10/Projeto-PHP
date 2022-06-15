<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function home()
    {
        $marcas = Marca::all();
        return view('marca.home', compact('marcas'));
    }

    public function adicionar()
    {
        return view('marca.adicionar');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $marca = new Marca([
            //'nome' =>  $request->get('nome'),
            'nome' => $request->nome,
        ]);

        if ($marca->save()) {
            return redirect()->route('marcahome')->with('create', 'Marca criada.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Não foi possível criar esta Marca. Tente novamente.');
        }
    }

    public function editar($id)
    {
        $marca = Marca::find($id);
        if ($marca) {
            return view('marca.editar', compact('marca'));
        } else {
            return redirect()->route('marcahome')->with('error', 'Marca não encontrada. Tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $marca = Marca::find($id);

        if ($marca) {
            $marca->nome = $request->nome;
            $marca->save();
            return redirect()->route('marcahome')->with('update', 'Marca alterada.');
        } else {
            return redirect()->route('marcahome')->with('error', 'Não foi possível alterar esta marca. Tente novamente.');
        }
    }

    public function delete(Request $request)
    {
        $id = $request['marca_id'];
        $marca = Marca::find($id);
        if ($marca) {
            $marca->delete();
            return redirect()->route('marcahome')->with('delete', 'Marca deletada.');
        } else {
            return redirect()->route('Marcahome')->with('error', 'Não foi possível deletar esta Marca. Tente novamente.');
        }
    }
}

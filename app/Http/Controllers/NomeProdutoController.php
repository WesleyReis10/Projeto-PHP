<?php

namespace App\Http\Controllers;

use App\Models\NomeProduto;
use Illuminate\Http\Request;

class NomeProdutoController extends Controller
{
    //

    public function home()
    {
        $nomeprodutos = NomeProduto::all();
        return view('nomeproduto.home', compact('nomeprodutos'));
    }

    public function adicionar()
    {
        return view('nomeproduto.adicionar');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $nomeproduto = new NomeProduto([
            'nome' => $request->nome,
        ]);

        if ($nomeproduto->save()) {
            return redirect()->route('nomeprodutohome')->with('create', 'Nome do produto foi cadastrado.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Não foi possível cadastrar produto. Tente novamente.');
        }
    }

    public function editar($id)
    {
        $nomeproduto = NomeProduto::find($id);

        if ($nomeproduto) {
            return view('nomeproduto.editar', compact('nomeproduto'));
        } else {
            return redirect()->route('nomeprodutohome')->with('error', 'Nome do produto não encontrado. Tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $nomeproduto = NomeProduto::find($id);

        if ($nomeproduto) {
            $nomeproduto->nome = $request->nome;
            $nomeproduto->save();
            return redirect()->route('nomeprodutohome')->with('update', 'Nome do produto alterado.');
        } else {
            return redirect()->route('nomeprodutohome')->with('error', 'Não foi possível alterar este nomeproduto. Tente novamente.');
        }
    }

    public function delete(Request $request)
    {
        $id = $request['nomeproduto_id'];
        $nomeproduto = NomeProduto::find($id);

        if ($nomeproduto) {
            $nomeproduto->delete();
            return redirect()->route('nomeprodutohome')->with('delete', 'Nome do produto deletado.');
        } else {
            return redirect()->route('nomeprodutohome')->with('error', 'Não foi possível deletar este nomeproduto. Tente novamente.');
        }
    }
}

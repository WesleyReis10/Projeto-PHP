<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ItensVenda;
use App\Models\Pagamento;
use App\Models\Produto;
use App\Models\Venda;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VendaController extends Controller
{
    public function home(){
        $empresaid = Session::get('empresa');
        $vendas = Venda::where('empresaid', $empresaid)->get();
        return view('venda.home', compact('vendas'));
    }


    public function create(Request $request)
    {
        $venda = new Venda([
            'usuarioid' => Auth::user()->id,
            'empresaid' => Session::get('empresa'),
            'status' => 'Iniciada'
        ]);
            
        
        if ($venda->save()) {
            return redirect()->route('vendacarrinho',  ['id' => $venda->id]);
        } else {
            return redirect()->back()->withInput()->with('error', 'Não foi possível criar esta venda. Tente novamente.');
        }
    }

    public function carrinho($id){
        $empresaid = Session::get('empresa');
        $venda = Venda::where('empresaid', $empresaid)->find($id);
        if ($venda) {
            if ($venda->status == 'Iniciada') {
                $clientes = Cliente::where('empresaid', $empresaid)->get();
                $produtos = Produto::where('empresaid', $empresaid)->get();
                $itensvendidos = ItensVenda::wherein('produtoid', $produtos->pluck('id'))->pluck('produtoid');
                $produtos = Produto::wherenotin('id', $itensvendidos)->get();
                $itensvendas = ItensVenda::where('vendaid', $id)->get();
                $total = $this->calcularValorTotalCarrinho($itensvendas);
                return view('venda.carrinho', compact('venda', 'itensvendas', 'produtos', 'total', 'clientes'));
            }
            if($venda->status == 'Pagamento'){
                return redirect('/pagamento/venda/'.$venda->id);
            }
        } else {
            return redirect()->route('vendahome')->with('error', 'Não foi possível acessar esta venda. Tente novamente.');
        }
    }


    public function adicionarprodutovenda(Request $request){
        $request->validate([
            'codigo' => 'required|numeric|min:1',
            'venda' => 'required|numeric|min:1',
        ]);
        $venda = Venda::where('empresaid', Session::get('empresa'))->find($request->venda);
        if ($venda) {
            $produto = Produto::where('empresaid', Session::get('empresa'))->where('codigodebarraunico', $request->codigo)->first();
            if ($produto) {
                if(ItensVenda::where('produtoid', $produto->id)->count() > 0){
                    return response('Produto não disponivel', 404);
                }
                $item = new ItensVenda([
                    'produtoid' => $produto->id,
                    'valor' => $produto->valorvenda,
                    'vendaid' => $request->venda
                ]);
                $item->save();
                $itensvendas = ItensVenda::where('vendaid', $request->venda)->get();
                return response([ 'view' => view('venda.tr-tableprodutos')->with(['item'=> $item, 'venda'=> $venda, 'produto' => $produto])->render(), 'total' => $this->calcularValorTotalCarrinho($itensvendas)], 202);
            } else {
                return response('Produto não encontrado', 404);
            }
        }else{
            return response('Venda não encontrada', 404);
        }
    }

    public function removerprodutovenda(Request $request){
        $request->validate([
            'produto' => 'required|numeric|min:1',
            'venda' => 'required|numeric|min:1',
        ]);
        $venda = Venda::where('empresaid', Session::get('empresa'))->find($request->venda);
        if ($venda) {
            $itemvenda = ItensVenda::where('vendaid', $venda->id)->where('produtoid', $request->produto)->first();
            if ($itemvenda) {
                $itemvenda->delete();
                $itensvenda = ItensVenda::where('vendaid', $venda->id)->get();
                return response(['id' => $request->produto, 'total' => $this->calcularValorTotalCarrinho($itensvenda)], 200);
            } else {
                return response('Produto não encontrado', 404);
            }
        }else{
            return response('Venda não encontrada', 404);
        }
    }

    private function calcularValorTotalCarrinho($itensvendas){
        $valor = 0;
        foreach($itensvendas as $item){
            $valor += $item->valor;
        }
        return number_format($valor, 2, ",", ".");
    }

    public function finalizarvenda($id){
        $empresaid = Session::get('empresa');
        $venda = Venda::where('empresaid', $empresaid)->find($id);
        if ($venda && $venda->status == 'Iniciada') {
            $venda->status = 'Pagamento';
            if($venda->save()){
                return redirect()->route('pagamento',  ['id' => $venda->id]);
            }else{
                return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
            }
        }else{
            return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
        }
    }

    private function calcularPagamento($pagametos, $itensvenda){
        $valorP = 0;
        $valorIv = 0;
        foreach($pagametos as $item){
            $valorP += $item->valor;
        }
        foreach($itensvenda as $item){
            $valorIv += $item->valor;
        }
        $troco = ($valorP > $valorIv) ? number_format($valorP - $valorIv, 2, ",", ".") :  number_format(0, 2, ",", ".") ;
        $valorRestante = ($valorIv > $valorP) ? number_format($valorIv - $valorP, 2, ",", ".") :  number_format(0, 2, ",", ".") ;
        $finalizar = false;
        if(($valorP > $valorIv)  || ($valorIv > $valorP) <= 0){
            $finalizar = true;
        }
        return ['valorRestante' => $valorRestante, 'subtotal' => number_format($valorIv, 2, ",", "."), 'troco' => $troco, 'finalizar' => $finalizar];
    }

    public function pagamento($id){
        $empresaid = Session::get('empresa');
        $venda = Venda::where('empresaid', $empresaid)->find($id);
        if ($venda && $venda->status == 'Pagamento') {
            $itensvenda = $venda->itens_vendas;
            $pagametos = $venda->pagamentos;
            $valores = $this->calcularPagamento($pagametos,$itensvenda);
            return view('venda.pagamento', compact('venda', 'itensvenda', 'pagametos', 'valores'));
        }else{
            return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
        }
    }

    public function adicionarPagamento(Request $request){
        $request->validate([
            'venda' => 'required|numeric|min:1',
            'formadepagamento' => 'required',
            'valor' => 'required|min:0',
        ]);

        $venda = Venda::where('empresaid', Session::get('empresa'))->find($request->venda);
        if ($venda && $venda->status == 'Pagamento') {
            $pagamento = new Pagamento([
                'forma_de_pagamento' => $request->formadepagamento,
                'valor' => str_replace(',', '.', str_replace('.', '', $request->valor)),
                'vendaid' => $request->venda
            ]);
            $pagamento->save();
            
            return redirect('/pagamento/venda/'.$venda->id);

            
        }else{
            return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
        }
        
    }

    public function removerPagamento($id){
        $pagamento = Pagamento::find($id);
        if($pagamento && Venda::where('empresaid', Session::get('empresa'))->find($pagamento->vendaid)){
            $venda = Venda::where('empresaid', Session::get('empresa'))->find($pagamento->vendaid);
            if($venda->status == 'Pagamento'){
                $pagamento->delete();
                return redirect('/pagamento/venda/'.$venda->id);
            }else{
                return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
            }
        }else{
            return 'NÃO ENCONTRADO';
        }
    }

    public function finalizarPagamento($id){
        $empresaid = Session::get('empresa');
        $venda = Venda::where('empresaid', $empresaid)->find($id);
        if ($venda && $venda->status == 'Pagamento') {
            $itensvenda = $venda->itens_vendas;
            $pagametos = $venda->pagamentos;
            $valores = $this->calcularPagamento($pagametos,$itensvenda);
            if($valores['finalizar']){
                $venda->status = 'Finalizada';
                if($venda->save()){
                    return redirect('/venda'); 
                }else{
                    return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
                }
            }else{
                return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
            }
            if($venda->save()){
                return redirect()->route('pagamento',  ['id' => $venda->id]);
            }else{
                return redirect()->back()->withInput()->with('error', 'Não foi possivel realizar essa operação');
            }
        }
    }

    public function alterarvalor(Request $request){
        $request->validate([
            'id' => 'required|numeric|min:1',
            'valor' => 'required|min:0',
            'empresa' => 'required|numeric|min:1',
        ]);
        
        $produtolista = ItensVenda::find($request->id);
        if($produtolista->count() > 0 && $produtolista->produto->empresaid == Session('empresa')){
            $produtolista->valor = $request->valor;
            $produtolista->save();
            return response(['total' =>  $this->calcularValorTotalCarrinho(ItensVenda::where('vendaid', $produtolista->vendaid)->get())], 200);
        }

    }
}

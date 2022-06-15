<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\ComprasProdutoTemporario;
use App\Models\ItensCompra;
use App\Models\Marca;
use App\Models\NomeProduto;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class CompraController extends Controller
{

    public function home()
    {

        $compras = Compra::all();
        return view('compra.home', compact('compras'));
    }
    public function adicionar()
    {
        return view('compra.criar');
    }

    public function create(Request $request)
    {

        $request->validate([
            'descricao' => 'required',
        ]);

        $compra = new Compra([
            'descricao' => $request->descricao,
            'status' => 'Aberta',
            'usuarioid' => Auth::user()->id,
        ]);

        if ($compra->save()) {
            return redirect()->route('comprahome')->with('create', 'Compra criada.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Não foi possível criar esta compra. Tente novamente.');
        }
    }
    public function carrinho($id)
    {
        $compra = Compra::find($id);
        if ($compra && $compra->status != 'Finalizada') {
            $marcas = Marca::all();
            $categorias = Categoria::all();
            $itenscompras = ComprasProdutoTemporario::where('compraid', $id)->get();
            $produtos = NomeProduto::all();
            $total = $this->calcularValorTotalCarrinho($id);
            return view('compra.carrinho', compact('compra', 'itenscompras', 'produtos', 'categorias', 'marcas', 'total'));
        } else {
            return redirect()->route('comprahome')->with('error', 'Não foi possível acessar esta compra. Tente novamente.');
        }
    }

    public function relatoriocompra($id){
        $compra = Compra::find($id);
        if($compra->count() > 0 ){
            $produtosx = DB::select("select p.nome, p.valorcompra, p.codigodebarraunico, count(*) as quantidade from itens_compras
            INNER JOIN produtos p on itens_compras.produtoid = p.id
            where itens_compras.compraid = $id and codigodebarraunico is null
            group by p.nome, p.valorcompra
            order by p.nome");

            $produtosy = DB::select("select p.nome, p.valorcompra, p.codigodebarraunico from itens_compras
            INNER JOIN produtos p on itens_compras.produtoid = p.id
            where itens_compras.compraid = $id and (p.codigodebarraunico is not null or p.codigodebarraunico <> '')
            order by p.nome");

            return view('relatorio.compra.basico')->with(['produtosx' => $produtosx, 'produtosy' => $produtosy, 'compra' => $compra, 'subtotal' => 0]);
        }else{
            return redirect()->route('comprahome')->with('error', 'Não foi possível acessar esta compra. Tente novamente.');
        }
    }

    public function adicionarprodutocompra(Request $request){
        $request->validate([
            'produto' => 'required|numeric',
            'valor' => 'required|numeric|min:0',
            'quantidade' => 'required|numeric|min:1',
            'compra' => 'required|numeric|min:1',
            'serialnumber' => 'nullable|numeric|min:5',
            'valorvenda' => 'required|numeric|min:0'
        ]);

        if(NomeProduto::find($request->produto) && Compra::find($request->compra)){
            if($request->serialnumber != ''){
                $produtonocarrinhoexiste = ComprasProdutoTemporario::where('codigodebarra',$request->serialnumber)->count();
                $produtoexiste = Produto::where('codigodebarraunico',$request->serialnumber)->count();
                if($produtonocarrinhoexiste > 0 || $produtoexiste > 0){
                    return response('Produto com esse Codigo Serial já cadastrado na base de dados', 409);
                }else{
                    $produtocarrinho = new ComprasProdutoTemporario([
                        'nomeprodutoid' => $request->produto,
                        'valor' => $request->valor,
                        'quantidade' => 1,
                        'codigodebarra' => $request->serialnumber,
                        'compraid' => $request->compra,
                        'valorvenda' => $request->valorvenda
                    ]);
                    $produtocarrinho->save();
                    return response([ 'view' => view('compra.tr-tableprodutos')->with('produto',  $produtocarrinho)->render(), 'total' => $this->calcularValorTotalCarrinho($request->compra)], 202);
                }
            }else{
                $produtonocarrinhoexiste = ComprasProdutoTemporario::where('nomeprodutoid', $request->produto)->where('valor', $request->valor)->where('compraid', $request->compra)->where('codigodebarra', null)->count();
                if($produtonocarrinhoexiste > 0){
                    return response('Produto já adicionado nesse carrinho', 409);
                }else{
                    $produtocarrinho = new ComprasProdutoTemporario([
                        'nomeprodutoid' => $request->produto,
                        'valor' => $request->valor,
                        'quantidade' => $request->quantidade,
                        'codigodebarra' => null,
                        'compraid' => $request->compra,
                        'valorvenda' => $request->valorvenda
                    ]);
                    $produtocarrinho->save();
                    return response([ 'view' => view('compra.tr-tableprodutos')->with('produto',  $produtocarrinho)->render(), 'total' => $this->calcularValorTotalCarrinho($request->compra)], 202);
                }
            }



        }
    }

    public function removerprodutocompra(Request $request){
        $request->validate([
            'id' => 'required',
            'compra' => 'required|numeric|min:1',
        ]);
        if(Compra::find($request->compra)) {
            $produto = ComprasProdutoTemporario::find($request->id);
            if($produto){
                $produto->delete();
                return response(['id' => $request->id, 'total' => $this->calcularValorTotalCarrinho($request->compra)], 200);
            }else{
                return response('Produto não encontrado', 404);
            }
        }
        else{
            return response('Compra não encontrada', 404);
       }
    }

    public function adicionarquantidadeproduto(Request $request){
        $request->validate([
            'id' => 'required',
            'compra' => 'required|numeric|min:1',
        ]);
        if(Compra::find($request->compra)) {
            $produto = ComprasProdutoTemporario::find($request->id);
            if($produto){
                $produto->quantidade += 1;
                $produto->save();
                return response(['quantidade' => $produto->quantidade, 'total' => $this->calcularValorTotalCarrinho($request->compra)], 200);
            }else{
                return response('Produto não encontrado', 404);
            }
        }
        else{
            return response('Compra não encontrada', 404);
       }
    }

    public function removerquantidadeproduto(Request $request){
        $request->validate([
            'id' => 'required',
            'compra' => 'required|numeric|min:1',
        ]);
        if(Compra::find($request->compra)) {
            $produto = ComprasProdutoTemporario::find($request->id);
            if($produto){
                $produto->quantidade -= 1;
                if($produto->quantidade <= 0){
                    $produto->delete();
                }else{
                    $produto->save();
                }
                return response(['quantidade' => $produto->quantidade, 'total' => $this->calcularValorTotalCarrinho($request->compra)], 200);
            }else{
                return response('Produto não encontrado', 404);
            }
        }
        else{
            return response('Compra não encontrada', 404);
       }
    }

    public function dataAjax(Request $request)
    {
        $data = Produto::all();

        if ($request->has('q')) {
            $search = $request->q;
            $data = Produto::select("id", "nome")
                ->where('nome', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }

    private function calcularValorTotalCarrinho($compraid){
        $compra = ComprasProdutoTemporario::where('compraid', $compraid)->get();
        $valor = 0;
        foreach($compra as $produto){
            $valor += $produto->quantidade * $produto->valor;
        }
        return number_format($valor, 2, ",", ".");
    }

    public function finalizarcompra($id){
        $compra = Compra::find($id);
        if ($compra && $compra->status != 'Finalizado') {
            $compras = ComprasProdutoTemporario::where('compraid', $id)->get();

            if($compras->count() > 0){
                $serialnumbers = $compras->pluck('codigodebarra')->toArray();
                if(Produto::wherein('codigodebarraunico', $serialnumbers)->count() > 0){
                    $produtosadicionados = Produto::wherein('codigodebarraunico', $serialnumbers)->get();
                    $string = 'Produtos: ';
                    foreach($produtosadicionados as $produto){
                        $string.=$produto->nome.'; ';
                    }
                    return redirect()->route('comprahome')->with('error', 'Produto com numero serial já adicionado na base de dados: '.$string);
                }
                $codigos = Produto::pluck('codigodebarraunico');
                $codigos = $codigos->toArray();

                foreach($compras as $produto){
                    DB::beginTransaction();
                    try {
                        for ($i = 0; $i < $produto->quantidade; $i++) {
                            $produtonovo = new Produto([
                            'valorcompra' => $produto->valor,
                            'nome' => $produto->produto->nome,
                            'categoriaid' => $produto->produto->categoriaid,
                            'marcaid' => $produto->produto->marcaid,
                            'codigodebarraunico' => $produto->codigodebarra ?? null,
                            'valorvenda' => $produto->valorvenda
                        ]);
                            $produtonovo->save();
                            if ($produtonovo) {
                                $itens_compras = new ItensCompra([
                            'valor' => $produtonovo->valorcompra,
                            'compraid' => $id,
                            'produtoid' => $produtonovo->id,
                            ]);
                                if($produtonovo->codigodebarraunico == null){
                                    do{
                                        $produtonovo->codigodebarraunico = $produtonovo->gerarCodigo();
                                    }while(in_array($produtonovo->codigodebarraunico, $codigos) != false);
                                    $produtonovo->save();
                                    array_push($codigos, $produtonovo->codigodebarraunico);
                                }
                                $itens_compras->save();
                            }
                        }
                        DB::commit();
                    } catch (\Exception $ex) {
                        DB::rollback();
                        return $ex;
                        return redirect()->route('comprahome')->with('error', 'Não foi possível finalizar esta compra. Tente novamente. [Rollback]');
                    }
                }
                $compra->status = 'Finalizada';
                $compra->save();
                return redirect()->route('comprahome')->with('create', 'Compra finalizada.');
            }else{
                return redirect()->route('comprahome')->with('error', 'Não foi possível finalizar esta compra. Tente novamente.');
            }
        } else {
            return redirect()->route('comprahome')->with('error', 'Não foi possível acessar esta compra. Tente novamente.');
        }
    }
}

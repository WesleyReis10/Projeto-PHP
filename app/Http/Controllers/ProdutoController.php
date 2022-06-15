<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function home()
    {
        $produtos = Produto::all();
        return view('produto.home', compact('produtos'));
    }


}

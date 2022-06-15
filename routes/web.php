<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@home')->name('home');

    //TOMAMOS COMO PADRÃO O ->NAME(''); O NOME DO CONTROLADOR/METODO
    Route::get('/categoria', 'CategoriaController@home')->name('categoriahome');
    Route::get('/categoria/nova', 'CategoriaController@adicionar')->name('categoriaadicionar');
    Route::post('/categoria/nova', 'CategoriaController@create')->name('categoriacreate');
    Route::get('/categoria/editar/{id}', 'CategoriaController@editar')->name('categoriaeditar');
    Route::patch('categoria/editar/{id}', 'CategoriaController@update')->name('categoriaupdate');
    Route::delete('/categoria/deletar', 'CategoriaController@delete')->name('categoriadelete');

    Route::get('/marca', 'MarcaController@home')->name('marcahome');
    Route::get('/marca/nova', 'MarcaController@adicionar')->name('marcaadicionar');
    Route::post('/marca/nova', 'MarcaController@create')->name('marcacreate');
    Route::get('/marca/editar/{id}', 'MarcaController@editar')->name('marcaeditar');
    Route::patch('marca/editar/{id}', 'MarcaController@update')->name('marcaupdate');
    Route::delete('/marca/deletar', 'MarcaController@delete')->name('marcadelete');

    Route::get('/usuario', 'UsuarioController@home')->name('usuariohome');
    Route::get('/usuario/nova', 'UsuarioController@adicionar')->name('usuarioadicionar');
    Route::post('/usuario/nova', 'UsuarioController@create')->name('usuariocreate');
    Route::get('/usuario/editar/{id}', 'UsuarioController@editar')->name('usuarioeditar');
    Route::patch('usuario/editar/{id}', 'UsuarioController@update')->name('usuarioupdate');
    Route::delete('/usuario/deletar', 'UsuarioController@delete')->name('usuariodelete');

    Route::get('/nomeproduto', 'NomeProdutoController@home')->name('nomeprodutohome');
    Route::get('/nomeproduto/nova', 'NomeProdutoController@adicionar')->name('nomeprodutoadicionar');
    Route::post('/nomeproduto/nova', 'NomeProdutoController@create')->name('nomeprodutocreate');
    Route::get('/nomeproduto/editar/{id}', 'NomeProdutoController@editar')->name('nomeprodutoeditar');
    Route::patch('nomeproduto/editar/{id}', 'NomeProdutoController@update')->name('nomeprodutoupdate');
    Route::delete('/nomeproduto/deletar', 'NomeProdutoController@delete')->name('nomeprodutodelete');

    Route::get('/compra', 'CompraController@home')->name('comprahome');
    Route::get('/compra/nova', 'CompraController@adicionar')->name('compraadicionar');
    Route::post('/compra/nova', 'CompraController@create')->name('compraareate');
    Route::get('/compra/carrinho/{id}', 'CompraController@carrinho')->name('compracarrinho');
    Route::get('/select2-autocomplete-ajaxcompra', 'CompraController@dataAjax')->name('compradataajax');
    Route::post('/adicionarproduto/compra', 'CompraController@adicionarprodutocompra')->name('adicionarprodutocompra');
    Route::post('/removerproduto/compra', 'CompraController@removerprodutocompra')->name('removerrprodutocompra');
    Route::post('/adicionarquantidadeproduto/compra', 'CompraController@adicionarquantidadeproduto')->name('adicionarquantidadeproduto');
    Route::post('/removerquantidadeproduto/compra', 'CompraController@removerquantidadeproduto')->name('removerquantidadeproduto');
    Route::get('/finalizar/compra/{id}', 'CompraController@finalizarcompra')->name('finalizarcompra');
    Route::get('/relatorio/compra/{id}', 'CompraController@relatoriocompra')->name('relatoriocompra');

    Route::get('/venda', 'VendaController@home')->name('vendahome');
    Route::get('/venda/nova', 'VendaController@create')->name('vendacreate');
    Route::get('/venda/carrinho/{id}', 'VendaController@carrinho')->name('vendacarrinho');
    Route::post('/adicionarproduto/venda', 'VendaController@adicionarprodutovenda')->name('adicionarprodutovenda');
    Route::post('/removerproduto/venda', 'VendaController@removerprodutovenda')->name('removerrprodutovenda');
    Route::get('/finalizar/venda/{id}', 'VendaController@finalizarvenda')->name('finalizarvenda');
    Route::get('/pagamento/venda/{id}', 'VendaController@pagamento')->name('pagamento');
    Route::post('/adicionar/pagamento', 'VendaController@adicionarPagamento')->name('adicionarPagamento');
    Route::get('/remover/pagamento/{id}', 'VendaController@removerPagamento')->name('removerPagamento');
    Route::get('/finalizar/pagamento/{id}', 'VendaController@finalizarPagamento')->name('finalizarPagamento');
    Route::get('/mudar/empresa/{id}', 'EmpresaController@mudarEmpresa');
    Route::post('/alterarvalor/compra', 'VendaController@alterarvalor');

    Route::get('/produto', 'ProdutoController@home')->name('produtohome');

});

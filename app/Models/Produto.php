<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Produto
 *
 * @property int $id
 * @property float|null $valorcompra
 * @property float|null $valorvenda
 * @property string|null $nome
 * @property int|null $categoriaid
 * @property int|null $marcaid
 *
 * @property Categoria|null $categoria
 * @property Marca|null $marca
 * @property ItensCompra $itens_compra
 * @property Collection|ItensVenda[] $itens_vendas
 *
 * @package App\Models
 */
class Produto extends Model
{

    use SoftDeletes;
	protected $table = 'produtos';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
        'id' => 'int',
        'valorcompra' => 'float',
        'valorvenda' => 'float',
        'categoriaid' => 'int',
        'marcaid' => 'int',
        'codigodebarraunico',
	];

	protected $fillable = [
        'valorcompra',
        'valorvenda',
        'nome',
        'categoriaid',
        'marcaid',
        'codigodebarraunico',
	];

	public function categoria()
	{
		return $this->belongsTo(Categoria::class, 'categoriaid');
	}

	public function marca()
	{
		return $this->belongsTo(Marca::class, 'marcaid');
	}

	public function itens_compra()
	{
		return $this->hasOne(ItensCompra::class, 'produtoid');
	}

	public function itens_vendas()
	{
		return $this->hasMany(ItensVenda::class, 'produtoid');
	}

    public function gerarCodigo()
    {
        return mt_rand(00000001, mt_getrandmax());
    }
}

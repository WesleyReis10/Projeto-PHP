<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Categoria|null $categoria
 * @property Marca|null $marca
 * @property Collection|ItensVenda[] $itens_vendas
 *
 * @package App\Models
 */
class Produto extends Model
{
	use SoftDeletes;
	protected $table = 'produtos';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'valorcompra' => 'float',
		'valorvenda' => 'float',
		'categoriaid' => 'int',
		'marcaid' => 'int'
	];

	protected $fillable = [
		'valorcompra',
		'valorvenda',
		'nome',
		'categoriaid',
		'marcaid'
	];

	public function categoria()
	{
		return $this->belongsTo(Categoria::class, 'categoriaid');
	}

	public function marca()
	{
		return $this->belongsTo(Marca::class, 'marcaid');
	}

	public function itens_vendas()
	{
		return $this->hasMany(ItensVenda::class, 'produtoid');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ItensCompra
 *
 * @property int|null $id
 * @property int|null $compraid
 * @property int|null $produtoid
 * @property float|null $valor
 *
 * @property Compra|null $compra
 * @property Produto|null $produto
 *
 * @package App\Models
 */
class ItensCompra extends Model
{
	use SoftDeletes;
	protected $table = 'itens_compras';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'id' => 'int',
		'compraid' => 'int',
		'produtoid' => 'int',
		'valor' => 'float'
	];

	protected $fillable = [
		'id',
		'compraid',
		'produtoid',
		'valor'
	];

	public function compra()
	{
		return $this->belongsTo(Compra::class, 'compraid');
	}

	public function produto()
	{
		return $this->belongsTo(Produto::class, 'produtoid');
	}
}

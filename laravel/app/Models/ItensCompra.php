<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ItensCompra
 * 
 * @property int|null $id
 * @property int|null $compraid
 * @property int|null $produtoid
 * @property float|null $valor
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Compra|null $compra
 *
 * @package App\Models
 */
class ItensCompra extends Model
{
	use SoftDeletes;
	protected $table = 'itens_compras';
	public $incrementing = false;

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
}

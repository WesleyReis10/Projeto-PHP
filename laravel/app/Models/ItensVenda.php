<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ItensVenda
 * 
 * @property int $id
 * @property int|null $produtoid
 * @property int|null $vendaid
 * @property float|null $valor
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Produto|null $produto
 * @property Venda|null $venda
 *
 * @package App\Models
 */
class ItensVenda extends Model
{
	use SoftDeletes;
	protected $table = 'itens_vendas';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'produtoid' => 'int',
		'vendaid' => 'int',
		'valor' => 'float'
	];

	protected $fillable = [
		'produtoid',
		'vendaid',
		'valor'
	];

	public function produto()
	{
		return $this->belongsTo(Produto::class, 'produtoid');
	}

	public function venda()
	{
		return $this->belongsTo(Venda::class, 'vendaid');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ItensVenda
 * 
 * @property int $id
 * @property int|null $produtoid
 * @property int|null $vendaid
 * @property float|null $valor
 * 
 * @property Produto|null $produto
 * @property Venda|null $venda
 *
 * @package App\Models
 */
class ItensVenda extends Model
{
	protected $table = 'itens_vendas';
	public $incrementing = false;
	public $timestamps = false;

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

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comprasprodutotemporario
 *
 * @property int $id
 * @property int|null $compraid
 * @property int|null $nomeprodutoid
 * @property string|null $codigodebarra
 * @property float|null $valor
 * @property int|null $quantidade
 *
 * @property Nomeproduto|null $nomeproduto
 * @property Compra|null $compra
 *
 * @package App\Models
 */
class Comprasprodutotemporario extends Model
{
    use SoftDeletes;
	protected $table = 'comprasprodutotemporario';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'id' => 'int',
		'compraid' => 'int',
		'nomeprodutoid' => 'int',
		'valor' => 'float',
		'valorvenda' => 'float',
		'quantidade' => 'int'
	];

	protected $fillable = [
		'compraid',
		'nomeprodutoid',
		'codigodebarra',
		'valor',
		'valorvenda',
		'quantidade'
	];

	public function nomeproduto()
	{
		return $this->belongsTo(Nomeproduto::class, 'nomeprodutoid');
	}

	public function compra()
	{
		return $this->belongsTo(Compra::class, 'compraid');
	}


    public function produto()
    {
        return $this->belongsTo(NomeProduto::class, 'nomeprodutoid');
    }
}

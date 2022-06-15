<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nomeproduto
 * 
 * @property int $id
 * @property string|null $nome
 * @property int|null $categoriaid
 * @property int|null $marcaid
 * 
 * @property Categoria|null $categoria
 * @property Marca|null $marca
 * @property Collection|Comprasprodutotemporario[] $comprasprodutotemporarios
 *
 * @package App\Models
 */
class Nomeproduto extends Model
{
	protected $table = 'nomeproduto';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'categoriaid' => 'int',
		'marcaid' => 'int'
	];

	protected $fillable = [
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

	public function comprasprodutotemporarios()
	{
		return $this->hasMany(Comprasprodutotemporario::class, 'nomeprodutoid');
	}
}

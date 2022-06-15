<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Marca
 * 
 * @property int $id
 * @property string|null $nome
 * 
 * @property Collection|Nomeproduto[] $nomeprodutos
 * @property Collection|Produto[] $produtos
 *
 * @package App\Models
 */
class Marca extends Model
{
	protected $table = 'marcas';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'nome'
	];

	public function nomeprodutos()
	{
		return $this->hasMany(Nomeproduto::class, 'marcaid');
	}

	public function produtos()
	{
		return $this->hasMany(Produto::class, 'marcaid');
	}
}

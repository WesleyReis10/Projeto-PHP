<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Categoria
 * 
 * @property int $id
 * @property string|null $nome
 * 
 * @property Collection|Nomeproduto[] $nomeprodutos
 * @property Collection|Produto[] $produtos
 *
 * @package App\Models
 */
class Categoria extends Model
{
	protected $table = 'categorias';
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
		return $this->hasMany(Nomeproduto::class, 'categoriaid');
	}

	public function produtos()
	{
		return $this->hasMany(Produto::class, 'categoriaid');
	}
}

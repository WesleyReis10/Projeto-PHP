<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Nomeproduto
 * 
 * @property int $id
 * @property string|null $nome
 * @property int|null $categoriaid
 * @property int|null $marcaid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Categoria|null $categoria
 * @property Marca|null $marca
 *
 * @package App\Models
 */
class Nomeproduto extends Model
{
	use SoftDeletes;
	protected $table = 'nomeproduto';
	public $incrementing = false;

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
}

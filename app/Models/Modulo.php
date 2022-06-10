<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Modulo
 * 
 * @property int $id
 * @property string|null $nome
 * 
 * @property Collection|AcessoModulo[] $acesso_modulos
 *
 * @package App\Models
 */
class Modulo extends Model
{
	protected $table = 'modulos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'nome'
	];

	public function acesso_modulos()
	{
		return $this->hasMany(AcessoModulo::class, 'moduloid');
	}
}

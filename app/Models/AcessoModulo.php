<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AcessoModulo
 * 
 * @property int $id
 * @property int|null $moduloid
 * @property string|null $nome
 * 
 * @property Modulo|null $modulo
 * @property Compra|null $compra
 *
 * @package App\Models
 */
class AcessoModulo extends Model
{
	protected $table = 'acesso_modulos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'moduloid' => 'int'
	];

	protected $fillable = [
		'moduloid',
		'nome'
	];

	public function modulo()
	{
		return $this->belongsTo(Modulo::class, 'moduloid');
	}

	public function compra()
	{
		return $this->belongsTo(Compra::class, 'moduloid');
	}
}

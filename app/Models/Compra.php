<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Compra
 * 
 * @property int $id
 * @property string|null $descricao
 * @property string|null $status
 * @property int|null $usuarioid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Usuario|null $usuario
 * @property Collection|AcessoModulo[] $acesso_modulos
 * @property ItensCompra $itens_compra
 *
 * @package App\Models
 */
class Compra extends Model
{
	use SoftDeletes;
	protected $table = 'compras';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'usuarioid' => 'int'
	];

	protected $fillable = [
		'descricao',
		'status',
		'usuarioid'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuarioid');
	}

	public function acesso_modulos()
	{
		return $this->hasMany(AcessoModulo::class, 'moduloid');
	}

	public function itens_compra()
	{
		return $this->hasOne(ItensCompra::class, 'compraid');
	}
}

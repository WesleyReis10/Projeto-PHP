<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @property string|null $deleted_at
 *
 * @property Usuario|null $usuario
 * @property Collection|Comprasprodutotemporario[] $comprasprodutotemporarios
 * @property ItensCompra $itens_compra
 *
 * @package App\Models
 */
class Compra extends Model
{
    use SoftDeletes;
	protected $table = 'compras';
	public $incrementing = true;
	public $timestamps = true;

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

	public function comprasprodutotemporarios()
	{
		return $this->hasMany(Comprasprodutotemporario::class, 'compraid');
	}

	public function itens_compra()
	{
		return $this->hasMany(ItensCompra::class, 'compraid');
	}
}

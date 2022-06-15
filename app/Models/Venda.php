<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Venda
 * 
 * @property int $id
 * @property string|null $documento
 * @property int|null $usuarioid
 * @property string|null $descricao
 * 
 * @property Usuario|null $usuario
 * @property Collection|ItensVenda[] $itens_vendas
 * @property Collection|Pagamento[] $pagamentos
 *
 * @package App\Models
 */
class Venda extends Model
{
	protected $table = 'venda';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'usuarioid' => 'int'
	];

	protected $fillable = [
		'documento',
		'usuarioid',
		'descricao'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuarioid');
	}

	public function itens_vendas()
	{
		return $this->hasMany(ItensVenda::class, 'vendaid');
	}

	public function pagamentos()
	{
		return $this->hasMany(Pagamento::class, 'vendaid');
	}
}

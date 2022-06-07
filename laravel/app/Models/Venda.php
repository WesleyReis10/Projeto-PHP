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
 * Class Venda
 * 
 * @property int $id
 * @property string|null $documento
 * @property int|null $usuarioid
 * @property int|null $clienteid
 * @property string|null $descricao
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Usuario|null $usuario
 * @property Cliente|null $cliente
 * @property Collection|ItensVenda[] $itens_vendas
 * @property Collection|Pagamento[] $pagamentos
 *
 * @package App\Models
 */
class Venda extends Model
{
	use SoftDeletes;
	protected $table = 'venda';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'usuarioid' => 'int',
		'clienteid' => 'int'
	];

	protected $fillable = [
		'documento',
		'usuarioid',
		'clienteid',
		'descricao'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuarioid');
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'clienteid');
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

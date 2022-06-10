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
 * Class Cliente
 * 
 * @property int $id
 * @property string|null $nome
 * @property string|null $endereço
 * @property string|null $cidade
 * @property string|null $cep
 * @property string|null $cpf
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Pagamento[] $pagamentos
 * @property Collection|Venda[] $vendas
 *
 * @package App\Models
 */
class Cliente extends Model
{
	use SoftDeletes;
	protected $table = 'clientes';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'nome',
		'endereço',
		'cidade',
		'cep',
		'cpf'
	];

	public function pagamentos()
	{
		return $this->hasMany(Pagamento::class, 'clienteid');
	}

	public function vendas()
	{
		return $this->hasMany(Venda::class, 'clienteid');
	}
}

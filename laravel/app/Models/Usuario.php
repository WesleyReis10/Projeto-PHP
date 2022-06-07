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
 * Class Usuario
 * 
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $nome
 * @property string|null $nivel_acesso
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Compra[] $compras
 * @property Collection|Pagamento[] $pagamentos
 * @property Collection|Venda[] $vendas
 *
 * @package App\Models
 */
class Usuario extends Model
{
	use SoftDeletes;
	protected $table = 'usuarios';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'email',
		'password',
		'nome',
		'nivel_acesso'
	];

	public function compras()
	{
		return $this->hasMany(Compra::class, 'usuarioid');
	}

	public function pagamentos()
	{
		return $this->hasMany(Pagamento::class, 'usuarioid');
	}

	public function vendas()
	{
		return $this->hasMany(Venda::class, 'usuarioid');
	}
}

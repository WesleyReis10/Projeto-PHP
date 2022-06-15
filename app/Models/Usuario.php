<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $nome
 * @property string|null $nivel_acesso
 *
 * @property Collection|Compra[] $compras
 * @property Collection|Pagamento[] $pagamentos
 * @property Collection|Venda[] $vendas
 *
 * @package App\Models
 */
class Usuario extends Authenticatable
{
	protected $table = 'usuarios';
	public $incrementing = false;
	public $timestamps = false;

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

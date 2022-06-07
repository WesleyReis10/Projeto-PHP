<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pagamento
 * 
 * @property int $id
 * @property string|null $forma_de_pagamento
 * @property float|null $valor
 * @property int|null $vendaid
 * @property int|null $usuarioid
 * @property int|null $clienteid
 * 
 * @property Usuario|null $usuario
 * @property Cliente|null $cliente
 * @property Venda|null $venda
 *
 * @package App\Models
 */
class Pagamento extends Model
{
	protected $table = 'pagamentos';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'valor' => 'float',
		'vendaid' => 'int',
		'usuarioid' => 'int',
		'clienteid' => 'int'
	];

	protected $fillable = [
		'forma_de_pagamento',
		'valor',
		'vendaid',
		'usuarioid',
		'clienteid'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuarioid');
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'clienteid');
	}

	public function venda()
	{
		return $this->belongsTo(Venda::class, 'vendaid');
	}
}

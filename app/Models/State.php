<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class State extends Model
{
	protected $table = 'states';

	protected $fillable = [
		'name'
	];

	public function requests()
	{
		return $this->hasMany(Request::class);
	}
}

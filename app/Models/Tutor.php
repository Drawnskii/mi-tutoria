<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tutor
 * 
 * @property int $user_id
 * @property string $specialty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Schedule[] $schedules
 *
 * @package App\Models
 */
class Tutor extends Model
{
	protected $table = 'tutors';
	protected $primaryKey = 'user_id';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'specialty'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function schedules()
	{
		return $this->hasMany(Schedule::class);
	}
}

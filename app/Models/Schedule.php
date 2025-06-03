<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * 
 * @property int $id
 * @property int $tutor_id
 * @property Carbon $date
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property bool $available
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Tutor $tutor
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class Schedule extends Model
{
	protected $table = 'schedules';

	protected $casts = [
		'tutor_id' => 'int',
		'date' => 'datetime',
		'start_time' => 'datetime',
		'end_time' => 'datetime',
		'available' => 'bool'
	];

	protected $fillable = [
		'tutor_id',
		'date',
		'start_time',
		'end_time',
		'available'
	];

	public function tutor()
	{
		return $this->belongsTo(Tutor::class, 'tutor_id', 'user_id');
	}

	public function requests()
	{
		return $this->hasMany(Request::class);
	}
}

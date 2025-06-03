<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * 
 * @property int $id
 * @property int $student_id
 * @property int $schedule_id
 * @property int $state_id
 * @property string $subject
 * @property string $reason
 * @property Carbon $request_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Schedule $schedule
 * @property State $state
 * @property Student $student
 * @property Collection|Feedback[] $feedback
 *
 * @package App\Models
 */
class Request extends Model
{
	protected $table = 'requests';

	protected $casts = [
		'student_id' => 'int',
		'schedule_id' => 'int',
		'state_id' => 'int',
		'request_date' => 'datetime'
	];

	protected $fillable = [
		'student_id',
		'schedule_id',
		'state_id',
		'subject',
		'reason',
		'request_date'
	];

	public function schedule()
	{
		return $this->belongsTo(Schedule::class);
	}

	public function state()
	{
		return $this->belongsTo(State::class);
	}

	public function student()
	{
		return $this->belongsTo(Student::class,'student_id', 'user_id');
	}

	public function feedback()
	{
		return $this->hasMany(Feedback::class);
	}
}

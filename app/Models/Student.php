<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Student
 * 
 * @property int $user_id
 * @property string $career
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class Student extends Model
{
	protected $table = 'students';
	protected $primaryKey = 'user_id';
	public $incrementing = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'career'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function requests()
	{
		return $this->hasMany(Request::class);
	}
}

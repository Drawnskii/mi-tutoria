<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * 
 * @property int $id
 * @property int $request_id
 * @property int $rating
 * @property string|null $comments
 * @property Carbon $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Request $request
 *
 * @package App\Models
 */
class Feedback extends Model
{
	protected $table = 'feedback';

	protected $casts = [
		'request_id' => 'int',
		'rating' => 'int',
		'date' => 'datetime'
	];

	protected $fillable = [
		'request_id',
		'rating',
		'comments',
		'date'
	];

	public function request()
	{
		return $this->belongsTo(Request::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuditLog
 * 
 * @property int $id
 * @property int $user_id
 * @property string $affected_entity
 * @property string $event_description
 * @property Carbon $event_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class AuditLog extends Model
{
	protected $table = 'audit_logs';

	protected $casts = [
		'user_id' => 'int',
		'event_date' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'affected_entity',
		'event_description',
		'event_date'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

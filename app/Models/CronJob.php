<?php

namespace App\Models;

use App\Models\Custom\Enums\CronJobEmailMe;
use App\Models\Custom\Enums\CronJobStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Document
 *
 * @property int $id
 * @property int $cron_job_id
 * @property float $execution_time
 * @property string $name
 * @property string $expression
 * @property string $url
 * @property string $log
 * @property string $post
 * @property CronJobStatus $status
 * @property CronJobEmailMe $email_me
 * @property Carbon|null $created_at timestamp of create
 * @property Carbon|null $$updated_at timestamp of update
 * @property Carbon|null $deleted_at timestamp of delete
 *
 * @package App\Models
 */
class CronJob extends Model
{
    use SoftDeletes;

    protected $casts = [
        'email_me' => CronJobEmailMe::class,
        'status' => CronJobStatus::class,
    ];
}

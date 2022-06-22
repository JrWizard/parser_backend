<?php

namespace App\Models\Custom\Enums;

enum CronJobStatus: string {
    case enabled = 'enabled';
    case disabled = 'disabled';
}

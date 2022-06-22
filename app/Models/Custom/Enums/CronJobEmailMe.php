<?php

namespace App\Models\Custom\Enums;

enum CronJobEmailMe: string {
    case if_execution_fail = 'if_execution_fail';
    case never = 'never';
}

<?php

namespace App\Models\Custom;

use App\Exceptions\CronJobSaveFailed;
use App\Models\CronJob;
use App\Models\Custom\Enums\CronJobEmailMe;
use App\Models\Custom\Enums\CronJobStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\FileNotFoundException;

class Parser
{
    /**
     * @throws FileNotFoundException
     */
    public function __construct(
        private string $filename
    )
    {
        if (!Storage::exists($filename)) {
            throw new FileNotFoundException(Storage::path($filename));
        }
    }

    public function processCronJobs(): Collection
    {
        $data = collect($this->readCSV());

        DB::beginTransaction();
        $processedCronJobs = $data
            ->skip(1)
            ->mapSpread(static function ($iJob) {
                $job = new CronJob();

                $job->cron_job_id = (int)$iJob[0];
                $job->name = $iJob[1];
                $job->expression = $iJob[2];
                $job->url = $iJob[3];
                $job->email_me = match ($iJob[4]) {
                    'never' => CronJobEmailMe::never,
                    'if execution fail' => CronJobEmailMe::if_execution_fail,
                };
                $job->log = $iJob[5];
                $job->post = $iJob[6];
                $job->status = match ($iJob[7]) {
                    'enabled' => CronJobStatus::enabled,
                    'disabled' => CronJobStatus::disabled,
                };
                $job->execution_time = $iJob[8];

                if (!$job->save()) {
                    DB::rollBack();
                    throw new CronJobSaveFailed();
                }

                return $job->fresh();
            });
        DB::commit();

        return $processedCronJobs;
    }

    private function readCSV(): array
    {
        $line_of_text = [];
        $file_handle = fopen(Storage::path($this->filename), 'rb');

        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, ',');
        }

        fclose($file_handle);
        return $line_of_text;
    }
}

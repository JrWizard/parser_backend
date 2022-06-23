<?php

namespace App\Console\Commands;

use App\Exceptions\CronJobSaveFailed;
use App\Models\CronJob;
use App\Models\Custom\Parser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\FileNotFoundException;

class processCronJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronJobs:process {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates table, processes CSV of CRON jobs and saves it to database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $filename = $this->argument('filename');

        try {
            CronJob::query()->truncate();
            $parser = new Parser($filename);
            $importedData = $parser->processCronJobs();
            $this->info($importedData->count() . " cron jobs has been imported");
        } catch (CronJobSaveFailed) {
            $this->error("Error while saving data!");
        } catch (FileNotFoundException) {
            $this->error("File not found!");
        }


        return true;
    }
}

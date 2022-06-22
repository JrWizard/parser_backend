<?php

namespace App\Console\Commands;

use App\Models\CronJob;
use App\Models\Custom\Parser;
use Illuminate\Console\Command;
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
    protected $description = 'Processes CSV of CRON jobs and saves it to database.';

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
     * @throws FileNotFoundException
     */
    public function handle(): bool
    {
        CronJob::query()->truncate();
        $filename = $this->argument('filename');

        $parser = new Parser($filename);
        $parser->processCronJobs();

        return true;
    }
}

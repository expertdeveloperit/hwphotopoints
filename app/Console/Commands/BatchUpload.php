<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CronJobController;

class BatchUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:batchuploadfiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload the batch files to S3 and DB';

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
     * @return mixed
     */
    public function handle()
    {
        //\Log::info("Cron JOb Trigger");
        //call to cron job function
        $data =   (new CronJobController)->index();  
        $data =   (new CronJobController)->deleteExtra();  

    }
}

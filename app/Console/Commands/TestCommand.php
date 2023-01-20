<?php

namespace App\Console\Commands;

use App\Facades\MixLogService;
use App\Jobs\LogJob;
use App\Models\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        foreach(Application::all() as $application) {
            //MixLogService::setApplication($application)->getRecords();
            info("Added " . $application->name . " to queue");
//            dispatch(new LogJob($application))->onQueue('apps');
            try {
                LogJob::dispatch($application)->onQueue('apps');
            } catch (\Exception $e) {
                Log::error("LogJob failed for Application: " . $application->name . ". Error: " . $e->getMessage());
            }
        }
        return Command::SUCCESS;
    }
}

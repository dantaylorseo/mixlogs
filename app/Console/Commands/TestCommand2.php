<?php

namespace App\Console\Commands;

use App\Jobs\LogJob;
use App\Models\Application;
use App\Facades\MixLogService;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class TestCommand2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testcommand2';

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
        $application = Application::find(4);
        // dispatch( new LogJob( $application ) );
        MixLogService::test1($application);
        return Command::SUCCESS;
    }
}

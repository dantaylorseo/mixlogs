<?php

namespace App\Console\Commands;

use App\Facades\MixLogService;
use App\Models\Application;
use App\Models\Log;
use App\Models\Session;
use Illuminate\Console\Command;

class Test2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test2';

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

        // do {
        //     $deleted = Log::where('application_id', 1)->limit(1000)->delete();
        //     sleep(1);
        // } while ($deleted > 0);

        // do {
        //     $deleted = Session::where('application_id', 1)->limit(1000)->delete();
        //     sleep(1);
        // } while ($deleted > 0);

        // Log::where('application_id', 1)->delete();
        // Session::where('application_id', 1)->delete();

        $application = Application::find(1);
        MixLogService::setApplication($application)
        ->setTimeout(10 * 1000)
        // ->resetOffset()
        // ->commitOffset(400104)
        ->getRecords();
        return Command::SUCCESS;
    }
}

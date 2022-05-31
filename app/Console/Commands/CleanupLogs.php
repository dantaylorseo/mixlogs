<?php

namespace App\Console\Commands;

use DB;
use App\Models\Log;
use App\Models\Session;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Spatie\LaravelQueuedDbCleanup\CleanDatabaseJobFactory;

class CleanupLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup';

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
        $this->info('Cleaning up logs...');
        $this->info('Deleting logs older than 4 days...');
        // Session::where('timestamp', '<', Carbon::now()->subDays(4))->chunk(200, function ($sessions) {
        //     foreach ($sessions as $session) {
        //         $this->info('Deleting session ' . $session->sessionid);
        //         $session->logs()->delete();
        //         $session->delete();
                
        //     }
        // });

        // DB::table('sessions')->where('timestamp', '<', now()->subDays(4))->delete();
        // DB::table('logs')->where('timestamp', '<', now()->subDays(4))->delete();

        CleanDatabaseJobFactory::new()
        ->query(Session::query()->where('timestamp', '<',  now()->subDays(4)->toDateTimeString()))
        ->deleteChunkSize(1000)
        ->getBatch()
        ->onQueue('session_cleanups')
        ->dispatch();

        CleanDatabaseJobFactory::new()
        ->query(Log::query()->where('timestamp', '<',  now()->subDays(4)->toDateTimeString()))
        ->deleteChunkSize(1000)
        ->getBatch()
        ->onQueue('log_cleanups')
        ->dispatch();

        //Comment
        return Command::SUCCESS;
    }
}

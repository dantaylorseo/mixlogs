<?php

namespace App\Console\Commands;

use App\Models\Log;
use App\Models\Session;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

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
        Session::where('timestamp', '<', Carbon::now()->subDays(4))->chunk(200, function ($sessions) {
            foreach ($sessions as $session) {
                $session->logs()->delete();
                $session->delete();
                
            }
        });

        //Comment
        return Command::SUCCESS;
    }
}

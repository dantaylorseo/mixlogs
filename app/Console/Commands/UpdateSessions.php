<?php

namespace App\Console\Commands;

use App\Models\Log;
use App\Models\Session;
use Illuminate\Console\Command;

class UpdateSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatesessions';

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

        Log::whereNotNull('sessionid')->chunk(100, function($logs) {
            foreach($logs as $log ) {
                $this->info( "Processing $log->sessionid ");
                if( !empty( $log->sessionid ) ) {
                    $session = Session::firstOrNew([ 'sessionid' => $log->sessionid ]);
                    $session->application_id = $log->application_id;
                    if( !empty( $session->timestamp ) ) {
                        if( $session->timestamp->isAfter( $log->timestamp ) ) {
                            $session->timestamp = $log->timestamp;
                        }
                    } else {
                        $session->timestamp = $log->timestamp;
                    }
                    $session->save();
                }
            }
        });

        return Command::SUCCESS;
    }
}

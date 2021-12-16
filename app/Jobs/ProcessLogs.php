<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $application;
    protected $logs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($application, $logs)
    {
        $this->application = $application;
        $this->logs = $logs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach( $this->logs as $log ) {

            $timestamp = Carbon::parse($log['value']['timestamp']);
            if( !$timestamp->isToday() ) {
                //continue;
            }
            $log = Log::updateOrCreate(
                [
                    'id' => $log['key']['id'],
                ],
                [
                    'application_id' => $this->application->id,
                    'service' => $log['value']['service'],
                    'source' => $log['value']['source'],
                    'timestamp' => Carbon::parse($log['value']['timestamp']),
                    'appid' => $log['value']['appid'],
                    'traceid' => $log['value']['data']['traceid'],
                    'requestid' => $log['value']['data']['requestid'],
                    'sessionid' => !empty( $log['value']['data']['sessionid'] ) ? $log['value']['data']['sessionid'] : (!empty($log['value']['data']['request']['clientData']['x-nuance-dialog-session-id']) ? $log['value']['data']['request']['clientData']['x-nuance-dialog-session-id'] : null ),
                    'locale' => (!empty( $log['value']['data']['locale'] ) ? $log['value']['data']['locale'] : null),
                    'seqid' => !empty( $log['value']['data']['seqid'] ) ? $log['value']['data']['seqid'] : (!empty( $log['value']['data']['request']['clientData']['x-nuance-dialog-seqid'] ) ? $log['value']['data']['request']['clientData']['x-nuance-dialog-seqid'] : "0"),
                    'offset' => $log['offset'],
                    'events' => !empty( $log['value']['data']['events'] ) ? $log['value']['data']['events'] : null,
                    'request' => !empty( $log['value']['data']['request'] ) ? $log['value']['data']['request'] : null,
                    'response' => !empty( $log['value']['data']['response'] ) ? $log['value']['data']['response'] : null,
                    'data' => !empty( $log['value']['data'] ) ? $log['value']['data'] : null,
                ]
            );

            $this->application->offset = $log['offset'];
            $this->application->save();

            if( !empty( $log->sessionid ) ) {
                $session = Session::firstOrNew([ 'sessionid' => $log->sessionid ]);
                $session->records = $session->records + 1;
                $session->application_id = $this->application->id;
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
    }
}

<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log as FacadesLog;

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
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        FacadesLog::error("LogJob failed for Application: ".$this->application->name.". Error: ".$exception->getMessage() );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        

        $logArray = [];
        $count = 0;
        $lastLog = [];
        $nlu = "n/a";
        $dlg = "n/a";
        $c3 = "n/a";
        $project = "n/a";

        foreach( $this->logs as $log ) {
            if(Carbon::parse($log['value']['timestamp'])->isBefore(Carbon::now()->startOfDay())) continue;
            $logArray[] = [
                'id' => $log['key']['id'],
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
                'events' => !empty( $log['value']['data']['events'] ) ? json_encode($log['value']['data']['events']) : null,
                'request' => !empty( $log['value']['data']['request'] ) ? json_encode($log['value']['data']['request']) : null,
                'response' => !empty( $log['value']['data']['response'] ) ? json_encode($log['value']['data']['response']) : null,
                'data' => !empty( $log['value']['data'] ) ? json_encode($log['value']['data']) : null,
            ];
                
            if( !empty( $log['value']['data']['events'] ) && count( $log['value']['data']['events'] ) > 0 && !empty( $log['value']['data']['events'][0]['name'] ) && $log['value']['data']['events'][0]['name'] == 'session-start' ) {
                if( !empty( $log['value']['data']['events'][0]['value']['version'] ) ) {
                    $dlg = $log['value']['data']['events'][0]['value']['version']['dlg'];
                    if( !empty( $log['value']['data']['events'][0]['value']['project']['name'] ) ) {
                        $project = $log['value']['data']['events'][0]['value']['project']['name'];
                    }
                    $nlu = collect( $log['value']['data']['events'][0]['value']['version']['nlu'] )->first(); 
                }
            }

            if( !empty( $log['value']['data']['events'] ) && count( $log['value']['data']['events'] ) > 0 && !empty( $log['value']['data']['events'][0]['name'] ) && $log['value']['data']['events'][0]['name'] == 'data-required' ) {
                if( !empty( $log['value']['data']['events'][0]['value']['endpoint'] ) ) {
                    preg_match('/https:\/\/(?:[a-z0-9\\-\\.]+)digital.nod.nuance.com\/(?:[a-z\\-]+)\/(?:[a-z\\-]+)\/(?:[a-z\\-]+)([0-9]+)/u', $log['value']['data']['events'][0]['value']['endpoint']['uri'], $matches);
                    if( count( $matches ) > 1 ) {
                        $c3 = $matches[1];
                    }
                }
            }

            
            // $this->application->offset = $log['offset'];
            // $this->application->save();

            
            
        }

            DB::table('logs')->upsert( $logArray, 'id' );
            $count = count( $logArray );
            $lastLog = end( $logArray );
            if( !empty( $lastLog['sessionid'] ) ) {
                try {
                    $session = Session::firstOrNew([ 'sessionid' => $lastLog['sessionid'] ]);
                    $session->records = $session->records + $count;
                    $session->application_id = $this->application->id;
                    
                    if( $session->dlg == 'n/a' && $dlg != 'n/a' ) $session->dlg = $dlg;
                    if( $session->nlu == 'n/a' && $nlu != 'n/a' ) $session->nlu = $nlu;
                    if( $session->project == 'n/a' && $project != 'n/a' ) $session->project = $project;

                    if( !empty( $session->timestamp ) ) {
                        if( $session->timestamp->isAfter( $lastLog['timestamp'] ) ) {
                            $session->timestamp = $lastLog['timestamp'];
                        }
                    } else {
                        $session->timestamp = $lastLog['timestamp'];
                    }
                    $session->save();
                } catch( Exception $e ) {
                    dump( "catch" );
                    dump($e->getMessage());
                    FacadesLog::error($e->getMessage());
                }
            } else {
                dump( "not found" );
            }

        // } catch( Exception $e ) {
        //     dump( $e );
        // }

    }
}

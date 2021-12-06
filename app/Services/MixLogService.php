<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\Application;
use Illuminate\Support\Str;
use App\Exceptions\MixLogException;
use Illuminate\Support\Facades\Http;
use App\Exceptions\MixLogAuthenticationException;
use App\Models\Session;
use Illuminate\Support\Facades\Log as Logger;

class MixLogService {

    private $access_token = null;
    private $consumer_group = null;
    
    private $offset_reset = "earliest";
    private $timeout = 10000;
    private $min_bytes = -1;
    private $auto_commit = false;

    private $auth_url = "https://auth.crt.nuance.%s/oauth2/token";
    private $base_url = "https://log.api.nuance.%s";

    public ?Application $application = null;

    /**
     * Authenticate the application
     *
     * @return void
     */
    private function _authenticate() {
        if( empty( $this->application ) ) {
            throw new MixLogAuthenticationException("Application not set. Use setApplication()");
        }

        $auth_url = sprintf($this->auth_url, $this->application->tld);

        $response = Http::withBasicAuth( urlencode( $this->application->client_id ), $this->application->client_secret )->asForm()->post($auth_url, [
            'grant_type' => 'client_credentials',
            'scope' => 'log'
        ]);

        if( !$response->successful() ) {
            throw new MixLogAuthenticationException("Authentication error", $response->status() );
        }

        $json = $response->json();

        if( !empty( $json['access_token'] ) ) {
            $this->access_token = $json['access_token'];
        }

        return;
    }

    private function _generate_consumer_group_name() {
        $clientIdParts = explode( ':', $this->application->client_id );

        $groupName = sprintf(
            "appID-%s-clientName-%s-04", 
            $clientIdParts[1],
            $clientIdParts[5]
        );

        $this->consumer_group = $groupName;
    }

    /**
     * Create consumer for subscription
     *
     * @return void
     */
    private function _create_consumer() {

        $body = [
            "auto.offset.reset" => $this->offset_reset,
            "consumer.request.timeout.ms" => $this->timeout,
            "fetch.min.bytes" => $this->min_bytes,
            "auto.commit.enable" => $this->auto_commit
        ];

        
        $response = Http::withHeaders($this->_getHeaders())->post($this->_getBaseUrl().'/consumers', $body);

        if( !$response->successful() && $response->status() != 409 ) {
            dump( $response->json() );
            throw new MixLogException($response->status(). ": Error creating consumer", $response->status() );
        }

        return;
    }

    /**
     * Delete consuler for subscription
     *
     * @return void
     */
    private function _delete_consumer() {
        $response = Http::withHeaders($this->_getHeaders())->delete($this->_getBaseUrl().'/consumers');

        //dump( $this->_getHeaders() );
        if( !$response->successful() ) {
            //dump( $response->body() );
            //throw new MixLogException($response->status(). ": Error deleting consumer", $response->status() );
            Logger::error($response->status(). ": Error deleting consumer", ['body' => $response->body() || 'n/a' ]);
            return false;
        }

        return;
    }

    /**
     * Subscribe consumer to topic
     *
     * @return void
     */
    private function _subscribe() {
        $clientIdParts = explode( ':', $this->application->client_id );

        $body = [
            "topics" => [
                $clientIdParts[1]
            ]
        ];

        
        $response = Http::withHeaders($this->_getHeaders())->post($this->_getBaseUrl().'/consumers/subscription', $body);

        if( !$response->successful() ) {
            dump( $response->body() );
            throw new MixLogException($response->status(). ": Error creating consumer", $response->status() );
        }

    }

    private function _assignPartitions() {
        $clientIdParts = explode( ':', $this->application->client_id );
        
        $body = [
            "partitions" => [
                [
                    "topic" => $clientIdParts[1],
                    "partition" => 0,
                ]
            ]
        ];

        $response = Http::withHeaders($this->_getHeaders())->post($this->_getBaseUrl().'/consumers/assignments', $body);

        if( !$response->successful() ) {
            dump( $response->body() );
            throw new MixLogException($response->status(). ": Error assigning parititions", $response->status() );
        }

        return $this;

    }

    private function _getEarliestOffset() {
        $clientIdParts = explode( ':', $this->application->client_id );
        
        $body = [
            "partitions" => [
                [
                    "topic" => $clientIdParts[1],
                    "partition" => 0,
                ]
            ]
        ];

        $response = Http::withHeaders($this->_getHeaders())->post($this->_getBaseUrl().'/consumers/committed/offsets', $body);

        if( !$response->successful() ) {
            dump( $response->body() );
            throw new MixLogException($response->status(). ": Error getting offset", $response->status() );
        }

        dump( $response->json() );
    }

    public function resetOffset() {

        $clientIdParts = explode( ':', $this->application->client_id );
        
        $body = [
            "partitions" => [
                [
                    "topic" => $clientIdParts[1],
                    "partition" => 0,
                ]
            ]
        ];

        $response = Http::withHeaders($this->_getHeaders())->post($this->_getBaseUrl().'/consumers/positions/beginning', $body);

        if( !$response->successful() ) {
            dump( $response->body() );
            throw new MixLogException($response->status(). ": Error resetting offset", $response->status() );
        }

        return $this;
    }

    private function _commitOffset( $offset ) {
        $clientIdParts = explode( ':', $this->application->client_id );
        
        $body = [
            "offsets" => [
                [
                    "topic" => $clientIdParts[1],
                    "partition" => 0,
                    "offset" => $offset
                ]
            ]
        ];

        $response = Http::withHeaders($this->_getHeaders())->post($this->_getBaseUrl().'/consumers/offsets', $body);

        if( !$response->successful() ) {
            dump( $response->body() );
            // throw new MixLogException($response->status(). ": Error committing offset", $response->status() );
            return false;
        }
    }

    /**
     * Get the latest records from the logs
     *
     * @return void
     */
    public function getRecords( $loop = 1, $total = 0 ) {

        dump( "Running... $loop (".$this->application->name.")" );
        Logger::info( "Running... $loop (".$this->application->name.")" );

        $last = Log::orderByDesc('offset')->first();

        if( !empty( $last ) ) {
            $this->_commitOffset( $last->offset );
        } else {
            $this->_commitOffset( 0 );
        }

        //$response = null;
        //unset( $response );

        $response = Http::withHeaders($this->_getHeaders())->get($this->_getBaseUrl().'/consumers/records');

        if( !$response->successful() ) {
            $response->close();
            //throw new MixLogException($response->status(). ": Error getting records", $response->status() );
            Logger::error("Error getting records",
                [
                    'application' => $this->application->name,
                    'status' => $response->status(),
                    'headers' => $this->_getHeaders()
                ]
            );
            $this->_delete_consumer();
            return;
        }

        if( !empty( $response->json() ) ) {
            $logs = [];
            foreach( $response->json() as $log ) {
                // $logs[] = [
                //     'id' => $log['key']['id'],
                //     'application_id' => $this->application->id,
                //     'service' => $log['value']['service'],
                //     'source' => $log['value']['source'],
                //     'timestamp' => Carbon::parse($log['value']['timestamp']),
                //     'appid' => $log['value']['appid'],
                //     'traceid' => $log['value']['data']['traceid'],
                //     'requestid' => $log['value']['data']['requestid'],
                //     'sessionid' => !empty( $log['value']['data']['sessionid'] ) ? $log['value']['data']['sessionid'] : (!empty($log['value']['data']['request']['clientData']['x-nuance-dialog-session-id']) ? $log['value']['data']['request']['clientData']['x-nuance-dialog-session-id'] : null ),
                //     'locale' => (!empty( $log['value']['data']['locale'] ) ? $log['value']['data']['locale'] : null),
                //     'seqid' => !empty( $log['value']['data']['seqid'] ) ? $log['value']['data']['seqid'] : (!empty( $log['value']['data']['request']['clientData']['x-nuance-dialog-seqid'] ) ? $log['value']['data']['request']['clientData']['x-nuance-dialog-seqid'] : "0"),
                //     'offset' => $log['offset'],
                //     'events' => !empty( $log['value']['data']['events'] ) ? $log['value']['data']['events'] : null,
                //     'request' => !empty( $log['value']['data']['request'] ) ? $log['value']['data']['request'] : null,
                //     'response' => !empty( $log['value']['data']['response'] ) ? $log['value']['data']['response'] : null,
                //     'data' => !empty( $log['value']['data'] ) ? $log['value']['data'] : null,
                // ];

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
            // if( !empty( $logs ) ) {
            //     Log::upsert( $logs, ['id'], [ 'application_id', 'service', 'source', 'timestamp', 'appid', 'traceid', 'requestid', 'sessionid', 'locale', 'seqid', 'offset', 'events', 'request', 'response', 'data' ] );
            // }
        }
        //$response->close();
        
        gc_collect_cycles();

        //dump( $response->json() );
        try{
            if( !empty( $response->json() ) ) {
                $total = $total + count( $response->json() );
                dump( "Added ".count( $response->json() ) ." rows" );
                dump( "Total ".$total." rows" );
                dump( "Memory usage  ".memory_get_usage() );
                dump( "***********************************" );
                Logger::info('Got new rows', 
                    [
                        'application' => $this->application->name,
                        'added' => count( $response->json() ),
                        'total' => $total,
                        'memory' => memory_get_usage()
                    ]
                );
                $response->close();
                $this->getRecords( $loop += 1, $total );
            } else {
                dump( "Memory usage  ".memory_get_usage() );
                dump( "No logs" );
                Logger::info('No new rows', 
                    [
                        'application' => $this->application->name,
                        'memory' => memory_get_usage()
                    ]
                );
            }
        } catch( \RuntimeException $e ) {
            dump( "Memory usage  ".memory_get_usage() );
            dump( "No logs (Catch)" );
            Logger::info('No new rows (catch)', 
                [
                    'application' => $this->application->name,
                    'memory' => memory_get_usage()
                ]
            );
            $response->close();
        }
    }

    private function _getHeaders() {
        $headers = [
            "consumer-group" => $this->consumer_group,
            "consumer-name" => $this->application->consumer_name,
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => "Bearer $this->access_token"
        ];

        return $headers;
    }

    private function _getBaseUrl() {
        $base_url = sprintf($this->base_url, $this->application->tld);

        return $base_url;
    }

    /**
     * Set the value of timeout
     *
     * @return  self
     */ 
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }


    /**
     * Set the value of min_bytes
     *
     * @return  self
     */ 
    public function setMinBytes($min_bytes)
    {
        $this->min_bytes = $min_bytes;

        return $this;
    }

    /**
     * Set the value of auto_commit
     *
     * @return  self
     */ 
    public function setAutoCommit($auto_commit)
    {
        $this->auto_commit = $auto_commit;

        return $this;
    }

    /**
     * Set the value of application
     *
     * @return  self
     */ 
    public function setApplication(Application $application)
    {
        $this->application = $application;
        $this->_generate_consumer_group_name();
        $this->_authenticate();
        //$this->_delete_consumer();
        $this->_create_consumer();
        $this->_assignPartitions();
        $this->resetOffset();
        return $this;
    }
}
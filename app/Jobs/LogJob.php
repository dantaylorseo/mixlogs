<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use App\Facades\MixLogService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class LogJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $application;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    public $uniqueFor = 70;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Added ".$this->application->name." to queue");
        MixLogService::setApplication($this->application)->getRecords();
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new WithoutOverlapping($this->application->id)];
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::error("LogJob failed for Application: ".$this->application->name.". Error: ".$exception->getMessage() );
    }

    public function uniqueId()
    {
        return $this->application->id;
    }
}

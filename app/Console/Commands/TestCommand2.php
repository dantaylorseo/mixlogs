<?php

namespace App\Console\Commands;

use App\Models\Log;
use App\Jobs\LogJob;
use App\Models\Event;
use App\Models\Transition;
use App\Models\Application;
use Illuminate\Support\Str;
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
        $log = new Log ([
            'id' => Str::uuid(),
            'application_id' =>1,
            'service' => 'Service',
            'source' => 'Source',
            'timestamp' => Carbon::now()->setTimezone('Europe/London')->format('Y-m-d H:i:s.v'),
            'appid' => 'appid',
            'traceid' => 'traceid',
            'requestid' => 'requestid',
            'sessionid' => 'sessionid',
            'locale' => 'locale',
            'seqid' => 1,
            'partition' => 1,
            'offset' => 0,
            'request' => 'request',
            'response' => 'response',
            'data' =>  'data',
        ]);

        $event = Transition::create([
            'from' => 'from',
            'from_name' => 'from_name',
            'from_type' => 'from_type',
            'to' => 'to',
            'to_name' => 'to_name',
            'to_type' => 'to_type',
        ]);

        $event2 = Transition::create([
            'from' => 'from',
            'from_name' => 'from_name',
            'from_type' => 'from_type',
            'to' => 'to',
            'to_name' => 'to_name',
            'to_type' => 'to_type',
        ]);

        // $event = Event::create([]);

        $log->events()->createMany([
            [
                'eventable_id' => $event->id,
                'eventable_type' => get_class($event),
            ],
            [
                'eventable_id' => $event2->id,
                'eventable_type' => get_class($event2),
            ],
        ]);

        dd( $log->events()->each(function($item) {
            dump(get_class($item->eventable));
        }) );
        return Command::SUCCESS;
    }
}

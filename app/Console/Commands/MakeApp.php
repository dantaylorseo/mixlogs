<?php

namespace App\Console\Commands;

use App\Models\Application;
use Illuminate\Console\Command;

class MakeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makeapp';

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
        Application::create([
            'name' => 'ASOS UK Dev',
            'client_id' => 'appID:ASOS-VA-Sandbox:geo:eu:clientName:dan_logging_dev',
            'client_secret' => 'V4HZ68ihBd1p5-JTJIu0BaXjcUWIpxEfXOrQgl9QUyk',
            'date_retention' => 30,
            'tld' => 'eu'
        ]);
        return Command::SUCCESS;
    }
}

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
        $app = Application::create([
            'name' => 'UK Prod',
            'client_id' => 'appID:ASOS-VA-Production:geo:eu:clientName:nvaa-uk-store-va',
            'client_secret' => 'n0ukjR14gzIK_CQxIcAfIVxsu3vilziupGlym-xbV-E',
            'date_retention' => 30,
            'tld' => 'eu'
        ]);

        $app->users()->attach([1]);

        return Command::SUCCESS;
    }
}

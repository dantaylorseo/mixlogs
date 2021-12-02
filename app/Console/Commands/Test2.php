<?php

namespace App\Console\Commands;

use App\Facades\MixLogService;
use App\Models\Application;
use Illuminate\Console\Command;

class Test2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test2';

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
        $application = Application::find(1);
        MixLogService::setApplication($application)->resetOffset()->getRecords();
        return Command::SUCCESS;
    }
}

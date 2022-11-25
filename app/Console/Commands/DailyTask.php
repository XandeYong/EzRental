<?php

namespace App\Console\Commands;

use App\Http\Controllers\DailyTaskController;
use Illuminate\Console\Command;

class DailyTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all the function inside the DailyTaskController';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        new DailyTaskController();
    }
}

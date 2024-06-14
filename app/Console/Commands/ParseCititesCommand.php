<?php

namespace App\Console\Commands;

use App\Services\CityService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ParseCititesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing cities';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CityService $service)
    {   
        $service->parseCities();
        Artisan::call('optimize');
        return Command::SUCCESS;
    }
}

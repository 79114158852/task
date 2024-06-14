<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateApiUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:create {login}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate api token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::where('login', $this->argument('login'))->firstOrFail();
        echo PHP_EOL . $user->createToken('api')->plainTextToken . PHP_EOL;
        return Command::SUCCESS;
    }
}

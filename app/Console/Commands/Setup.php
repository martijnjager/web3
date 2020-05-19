<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:run {option=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs commands to configure Laravel and initialize database, expects the .env file to be present and configured';

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
     * @return mixed
     */
    public function handle()
    {
        $shouldRunKey = $this->argument('option');

        $db = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');

        if(is_file(base_path().'\.env') && !empty([$db, $db_user])) {

            if($shouldRunKey == 1)
                $commands = ['key:generate', 'migrate:fresh', 'db:seed'];
            else
                $commands = ['migrate:fresh', 'db:seed'];

            foreach($commands as $command)
                $this->call($command);

            return $this->info("Setup successfully completed.");
        }

        $this->info('Configure the .env file.');
    }
}

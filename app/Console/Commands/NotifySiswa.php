<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NotifySiswa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:job {--sleep=60}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail';

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
        while (true) {
            $this->info('Calling scheduler');
          
            $this->call('schedule:run');

            sleep($this->option('sleep'));
        }
    }
}

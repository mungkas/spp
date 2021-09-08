<?php

namespace App\Jobs;

use App\Mail\KirimEmail;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KirimEmailJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

        //
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $siswas = Siswa::all();

        foreach($siswas as $siswa) {
            Mail::to($siswa)->send(new KirimEmail($siswa));
        }

    }
}

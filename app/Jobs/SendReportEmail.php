<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Models\Mcu;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mcuIds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mcuIds)
    {
        $this->mcuIds = $mcuIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mcus = Mcu::whereIn('id', $this->mcuIds)->get();
        foreach($mcus as $mcu) {
            // Skip if patient don't have email address
            if(empty($mcu->email)) {
                continue;
            }

            // Send email
            Mail::to($mcu->email)
                ->send(new \App\Mail\MailPatientMedicalReport($mcu));
        }
    }
}

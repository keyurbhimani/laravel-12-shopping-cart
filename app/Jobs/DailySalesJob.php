<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\OrderItem;
use App\Mail\DailySalesMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class DailySalesJob implements ShouldQueue
{
    use Queueable;

    protected $sales;
    protected $today;
    /**
     * Create a new job instance.
     */
    public function __construct($sales, $today)
    {
        $this->sales = $sales;
        $this->today = $today;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if ($this->sales->isNotEmpty()) {
                Mail::to(config('mail.admin_email'))->send(new DailySalesMail($this->sales, $this->today));
            }
        } catch (\Exception $e) {
            info('Failed to send daily sales email: ' . $e->getMessage());
        }        
    }
}

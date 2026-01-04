<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Product;
use App\Mail\LowStockMail;
use Illuminate\Support\Facades\Mail;

class LowStockJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to(config('mail.admin_email'))->send(new LowStockMail($this->product));
        } catch (\Exception $e) {
            info('Failed to send low stock email: ' . $e->getMessage());
        }
    }
}

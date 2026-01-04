<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\DailySalesJob;

class DailySales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        $sales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereDate('orders.created_at', $today)
            ->select('order_items.product_id', 'products.name', DB::raw('SUM(order_items.quantity) as total_sold'), 'order_items.price')
            ->groupBy('order_items.product_id', 'products.name', 'order_items.price')
            ->get();

        if ($sales->isNotEmpty()) {
            DailySalesJob::dispatch($sales, $today);
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Modules\Sales\Dao\Models\Order;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Emails\CancelOrderEmail;

class CancelOrder extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands to cancel order if order is not paid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $list = Order::where('sales_order_status', 1)->where('sales_order_created_at', '<', Carbon::now()->subMinutes(10)->toDateTimeString())->limit(10);
        $model = new OrderRepository();
        foreach ($list->get() as $order) {
            $data = $model->showRepository($order->sales_order_id, ['customer', 'forwarder', 'detail', 'detail.product']);
            Mail::to($order->sales_order_email)->send(new CancelOrderEmail($data));
        }
        $data = $list->update(['sales_order_status' => '0']);
        $this->info('The system has cancel order successfully!');
    }

}

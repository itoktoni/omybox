<?php

namespace Modules\Procurement\Emails;

use Plugin\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Procurement\Dao\Models\Purchase;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateOrderEmail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $master;
    public $customer;
    public $forwarder;
    public $detail;
    public $account;

    public function __construct($order)
    {
        $this->master = $order;
        $this->vendor = $order->vendor;
        $this->detail = $order->detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(Helper::setViewEmail('create_order_email', 'procurement'));
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Finance\Dao\Models\Payment;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Sales\Emails\CreateOrderEmail;
use Modules\Sales\Emails\TestingOrderEmail;
use Modules\Sales\Emails\CreateEstimateEmail;
use Modules\Finance\Emails\ApprovePaymentEmail;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Finance\Emails\ConfirmationPaymentEmail;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Procurement\Dao\Repositories\PurchasePrepareRepository;
use Modules\Procurement\Emails\CreateOrderEmail as EmailsCreateOrderEmail;

class SendWa extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wa:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands To Sending Email';

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
        $order = new OrderRepository();
        // $order_data = $order->dataRepository()->whereNull('sales_order_email_date')->limit(3)->get();
        // if ($order_data) {
        //     foreach ($order_data as $order_item) {
        //         $data = $order->showRepository($order_item->sales_order_id, ['customer', 'detail', 'detail.product']);
        //         Mail::to([config('website.email')])->send(new CreateOrderEmail($data));
        //         // Mail::to([$order_item->sales_order_email, config('website.email')])->send(new CreateOrderEmail($data));
        //         $data->sales_order_email_date = date('Y-m-d H:i:s');
        //         $data->save();
        //     }
        // }

        $order_data = $order->dataRepository()->where('sales_order_status', 2)->whereNull('sales_order_estimate_date')->limit(1)->get();
        if ($order_data) {
            foreach ($order_data as $order_item) {
                $data = $order->showRepository($order_item->sales_order_id, ['customer', 'detail', 'detail.product', 'detail.brand']);
                // Mail::to([config('website.email')])->send(new CreateEstimateEmail($data));
                // Mail::to([$order_item->sales_order_email, config('website.email')])->send(new CreateOrderEmail($data));
                
                $message = "NOTIFICATION ORDER \n \n";
                $message = $message. "No. Order : $data->sales_order_id \n";
                $message = $message. "Customer : $data->sales_order_rajaongkir_name \n";
                $message = $message. "Alamat : $data->sales_order_rajaongkir_address \n \n";
                $message = $message. "Product : \n";
                $number = 1;
                $total = 0;
                foreach($data->detail as $detail){
                    $sub = $detail->sales_order_detail_qty_order * $detail->sales_order_detail_price_order;
                    $total = $total + $sub;

                    $message = $message.$detail->sales_order_detail_qty_order.' '.$detail->product->item_product_name.' x ('.number_format($detail->sales_order_detail_price_order,0,',','.').')'.' = '.number_format($detail->sales_order_detail_total_order,0,',','.'). '\n' ;
                    $number++;
                }
                $message = $message.'\nSub Total : '.number_format($total, 0,',','.').'\n';
                $message = $message.'PROMO : '.($data->sales_order_marketing_promo_value ? $data->sales_order_marketing_promo_name.' : -'.number_format($data->sales_order_marketing_promo_value,0,',','.') : '-0' ).' \n';
                $message = $message.'ONGKIR : '.number_format($data->sales_order_rajaongkir_ongkir, 0,',','.').'\n';
                $message = $message.'TOTAL : '.number_format($data->sales_order_total + $data->sales_order_rajaongkir_ongkir, 0,',','.').'\n';
                

                $message = $message.'\nPembayaran ke Rekening : \n';
                $bank = new BankRepository();
                foreach($bank->dataRepository()->get() as $account){
                    $message = $message.$account->finance_bank_name.' a.n '.$account->finance_bank_account_name.' : '.$account->finance_bank_account_number.'\n';
                }
                
                $message = $message.'\nPromo : '.config('website.promo').'\n';
                $this->sendWa($data->sales_order_rajaongkir_phone, $message);
                
                $data->sales_order_estimate_date = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        // $payment = new PaymentRepository();
        // $payment_data = $payment->dataRepository()->whereNull('finance_payment_reference')->whereNull('finance_payment_email_date')->limit(1)->get();
        // if ($payment_data) {
        //     foreach ($payment_data as $payment_item) {
        //         $data = $payment->showRepository($payment_item->finance_payment_id);
        //         Mail::to([$payment_item->finance_payment_email, config('website.email')])->send(new ConfirmationPaymentEmail($data));
        //         $data->finance_payment_email_date = date('Y-m-d H:i:s');
        //         $data->save();
        //     }
        // }

        // $payment_approve = $payment->dataRepository()->whereNull('finance_payment_email_approve_date')->whereNotNull('finance_payment_approved_at')->limit(1)->get();
        // if ($payment_approve) {
        //     foreach ($payment_approve as $payment_aprove) {
        //         $data = $payment->showRepository($payment_aprove->finance_payment_id);
        //         Mail::to([$data->finance_payment_email, config('website.email')])->send(new ApprovePaymentEmail($data));
        //         $data->finance_payment_email_approve_date = date('Y-m-d H:i:s');
        //         $data->save();
        //     }
        // }

        // $prepare_order = new PurchasePrepareRepository();
        // $prepare_order_data = $prepare_order->dataRepository()->where('purchase_status', 3)->whereNull('purchase_sent_date')->limit(1)->get();
        // if ($prepare_order_data) {

        //     foreach ($prepare_order_data as $prepare_order_item) {

        //         $data = $prepare_order->showRepository($prepare_order_item->purchase_id, ['vendor','detail', 'detail.product']);
        //         Mail::to([$data->vendor->procurement_vendor_email, config('website.warehouse')])->send(new EmailsCreateOrderEmail($data));
        //         $data->purchase_sent_date = date('Y-m-d H:i:s');
        //         $data->save();
        //     }
        // }

        $this->info('The system has been sent successfully!');
    }

    private function sendWa($target, $message)
    {
        $curl = curl_init();
        $token = env('WA'); //token lu

        $data = [
            'phone' => $target,
            'type' => 'text',
            'text' => $message
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
        "Authorization: $token",
    )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://fonnte.com/api/send_message.php");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    }
}
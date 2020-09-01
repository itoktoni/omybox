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
    protected $signature = 'send:wa';

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
        $payment = new PaymentRepository();

        //model

        $order_data = $data = $message = null;
        $order_data = $order->dataRepository()->where('sales_order_status', 1)->whereNull('sales_order_admin_wa')->limit(1)->get();
        if ($order_data) {
            foreach ($order_data as $order_item) {
                $data = $order->showRepository($order_item->sales_order_id, ['customer', 'detail', 'detail.product']);
                $brands = $order->brand()->where($order->getKeyName(), $order_item->sales_order_id)->groupBy('item_brand_id')->get();
                $message = "*NOTIFIKASI CUSTOMER* \n \n";
                $message = $message. "*No. Order : ".$data->sales_order_id."* \n";
                $message = $message. "Customer : $data->sales_order_rajaongkir_name \n";
                $message = $message. "Alamat : $data->sales_order_rajaongkir_address \n";

                foreach ($brands as $brand) {
                    $message = $message. "Branch : $brand->item_brand_name - $brand->item_brand_description \n";
                    
                    foreach ($data->detail as $detail) {
                        if ($detail->product->item_product_item_brand_id == $brand->item_brand_id) {
                            $message = $message. "Produk : \n";
                            $number = 1;
                            $total = 0;
                            
                            $sub = $detail->sales_order_detail_qty_order * $detail->sales_order_detail_price_order;
                            $total = $total + $sub;
                            
                            $message = $message.$detail->sales_order_detail_qty_order.' '.$detail->product->item_product_name.' x ('.number_format($detail->sales_order_detail_price_order, 0, ',', '.').')'.' = '.number_format($detail->sales_order_detail_total_order, 0, ',', '.'). '\n' ;
                            $number++;
                        }
                    }
                }

                $message = $message.'\nSub Total : '.number_format($total, 0, ',', '.').'\n';
                $message = $message.'PROMO : '.($data->sales_order_marketing_promo_value ? $data->sales_order_marketing_promo_name.' : -'.number_format($data->sales_order_marketing_promo_value, 0, ',', '.') : '-0').' \n';
                $message = $message.'TOTAL : '.number_format($data->sales_order_total, 0, ',', '.').'\n';
    
                $this->sendWa(config('website.phone'), $message);

                $data->sales_order_admin_wa = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        $order_data = $data = $message = null;
        $order_data = $order->dataRepository()->where('sales_order_status', 2)->whereNull('sales_order_estimate_wa')->limit(1)->get();
        if ($order_data) {
            foreach ($order_data as $order_item) {
                $data = $order->showRepository($order_item->sales_order_id, ['customer', 'detail', 'detail.product', 'detail.brand']);

                $message = "*NOTIFIKASI PESANAN* \n \n";
                $message = $message. "*No. Order : ".$data->sales_order_id."* \n";
                $message = $message. "Customer : $data->sales_order_rajaongkir_name \n";
                $message = $message. "Alamat : $data->sales_order_rajaongkir_address \n \n";
                $message = $message. "Produk : \n";
                $number = 1;
                $total = 0;
                foreach ($data->detail as $detail) {
                    $sub = $detail->sales_order_detail_qty_order * $detail->sales_order_detail_price_order;
                    $total = $total + $sub;

                    $message = $message.$detail->sales_order_detail_qty_order.' '.$detail->product->item_product_name.' x ('.number_format($detail->sales_order_detail_price_order, 0, ',', '.').')'.' = '.number_format($detail->sales_order_detail_total_order, 0, ',', '.'). '\n' ;
                    $number++;
                }
                $message = $message.'\nSub Total : '.number_format($total, 0, ',', '.').'\n';
                $message = $message.'PROMO : '.($data->sales_order_marketing_promo_value ? $data->sales_order_marketing_promo_name.' : -'.number_format($data->sales_order_marketing_promo_value, 0, ',', '.') : '-0').' \n';
                $message = $message.'ONGKIR : '.number_format($data->sales_order_rajaongkir_ongkir, 0, ',', '.').'\n';
                $message = $message.'TOTAL : '.number_format($data->sales_order_total + $data->sales_order_rajaongkir_ongkir, 0, ',', '.').'\n';

                $message = $message.'\nPembayaran ke Rekening : \n';
                $bank = new BankRepository();
                foreach ($bank->dataRepository()->get() as $account) {
                    $message = $message.$account->finance_bank_name.' a.n '.$account->finance_bank_account_name.' : '.$account->finance_bank_account_number.'\n';
                }
                
                $message = $message.'\nPromo : '.config('website.promo').'\n';
                $this->sendWa($data->sales_order_rajaongkir_phone, $message);
                
                $data->sales_order_estimate_wa = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        $order_data = $data = $message = null;
        $order_data = $order->dataRepository()->where('sales_order_status', 6)->whereNull('sales_order_delivery_wa')->limit(1)->get();
        if ($order_data) {
            foreach ($order_data as $order_item) {
                $data = $order->showRepository($order_item->sales_order_id, ['customer', 'detail', 'detail.product', 'detail.brand']);
                $brands = $order->brand()->where($order->getKeyName(), $order_item->sales_order_id)->groupBy('item_brand_id')->get();
                $message = "*NOTIFIKASI PENGIRIMAN* \n \n";
                $message = "Terimakasih untuk Pembayaran atas Pesanan berikut : \n \n";
                $message = $message. "No. Order : $data->sales_order_id \n";
                $message = $message. "Customer : $data->sales_order_rajaongkir_name \n";
                $message = $message. "Alamat : $data->sales_order_rajaongkir_address";

                foreach ($brands as $brand) {
                    $message = $message. "\n \nBranch : $brand->item_brand_name - $brand->item_brand_description \n";
                    $message = $message. "Ongkir : ".number_format($brand->sales_order_detail_ongkir,0,',','.')." \n";
                    $message = $message. "No. Resi : $brand->sales_order_detail_waybill \n";
                    
                    foreach ($data->detail as $detail) {
                        if ($detail->product->item_product_item_brand_id == $brand->item_brand_id) {
                            $message = $message. "Produk : \n";
                            $number = 1;
                            $total = 0;
                            
                            $sub = $detail->sales_order_detail_qty_order * $detail->sales_order_detail_price_order;
                            $total = $total + $sub;
                            
                            $message = $message.$detail->sales_order_detail_qty_order.' '.$detail->product->item_product_name.' x ('.number_format($detail->sales_order_detail_price_order, 0, ',', '.').')'.' = '.number_format($detail->sales_order_detail_total_order, 0, ',', '.'). '\n' ;
                            $number++;
                        }
                    }
                }

                $message = $message.'\nSub Total : '.number_format($total, 0, ',', '.').'\n';
                $message = $message.'PROMO : '.($data->sales_order_marketing_promo_value ? $data->sales_order_marketing_promo_name.' : -'.number_format($data->sales_order_marketing_promo_value, 0, ',', '.') : '-0').' \n';
                $message = $message.'ONGKIR : '.number_format($data->sales_order_rajaongkir_ongkir, 0, ',', '.').'\n';
                $message = $message.'TOTAL : '.number_format($data->sales_order_total + $data->sales_order_rajaongkir_ongkir, 0, ',', '.').'\n \n';
                $message = $message."Pesanan dalam proses pengiriman. Mohon di tunggu. Terimakasih";

                $this->sendWa($data->sales_order_rajaongkir_phone, $message);
                
                $data->sales_order_delivery_wa = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        $payment_data = $data = $message = null;
        $payment_data = $payment->dataRepository()->whereNull('finance_payment_reference')->whereNull('finance_payment_wa_date')->limit(1)->get();
        if ($payment_data) {
            foreach ($payment_data as $payment_item) {
                $data = $payment->showRepository($payment_item->finance_payment_id);
                $message = "*NOTIFIKASI KONFIRMASI PEMBAYARAN* \n \n";
                $message = $message. "No. Order : $data->finance_payment_sales_order_id \n";
                $message = $message. "Nama : $data->finance_payment_person \n";
                $message = $message. "Tanggal Pembayaran : ".$data->finance_payment_date->format('d M Y'). "\n";
                $message = $message. "Jumlah : ". number_format($data->finance_payment_amount, 0, ',', '.')." \n";
                $message = $message. "Catatan : $data->finance_payment_note \n";
                $this->sendWa($data->finance_payment_phone, $message);
                
                // Mail::to([$payment_item->finance_payment_email, config('website.email')])->send(new ConfirmationPaymentEmail($data));
                $data->finance_payment_wa_date = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        $payment_data = $data_order = $data = $message = null;
        $payment_data = $payment->dataRepository()->whereNull('finance_payment_wa_approve_date')->whereNotNull('finance_payment_approved_at')->limit(1)->get();
        if ($payment_data) {
            foreach ($payment_data as $payment_item) {
                $data = $payment->showRepository($payment_item->finance_payment_id);
                $message = "*NOTIFIKASI TERIMA PEMBAYARAN* \n \n";
                $message = $message. "No. Order : $data->finance_payment_sales_order_id \n";
                $message = $message. "Nama : $data->finance_payment_person \n";
                $message = $message. "Tgl Terima Pembayaran : ".$data->finance_payment_approved_at->format('d M Y')." \n";
                $message = $message. "Jumlah Terima: ". number_format($data->finance_payment_approve_amount, 0, ',', '.')." \n";
                $message = $message. "Catatan admin : $data->finance_payment_description \n";
                $this->sendWa($data->finance_payment_phone, $message);

                // Mail::to([$data->finance_payment_email, config('website.email')])->send(new ApprovePaymentEmail($data));
                
                $data->finance_payment_wa_approve_date = date('Y-m-d H:i:s');
                $data->save();

                // proses notifikasi branch

                $data_order = $order->showRepository($data->finance_payment_sales_order_id, ['customer', 'detail', 'detail.product', 'detail.brand']);
                $brands = $order->brand()->where($order->getKeyName(), $data->finance_payment_sales_order_id)->groupBy('item_brand_id')->get();
                $messagep = "*NOTIFIKASI ORDER* \n \n";
                $messagep = $messagep. "No. Order : $data_order->sales_order_id \n";
                $messagep = $messagep. "Customer : $data_order->sales_order_rajaongkir_name \n";
                $messagep = $messagep. "Alamat : $data_order->sales_order_rajaongkir_address";

                $pesan = [];
                $number = 0;
                foreach ($brands as $brand) {
                    $pesan[$number] = $messagep. "\n \nPesanan $brand->item_brand_name - $brand->item_brand_description : \n";
                    foreach ($data_order->detail as $detail) {
                        if ($detail->product->item_product_item_brand_id == $brand->item_brand_id) {
                            $pesan[$number] = $pesan[$number].$detail->sales_order_detail_qty_order.' '.$detail->product->item_product_name. '\n' ;
                            $pesan[$number] = $pesan[$number]. "Catatan : $detail->sales_order_detail_notes \n \n";
                        }
                    }
                    $this->sendWa($brand->item_brand_phone, $pesan[$number]);
                    $number++;
                }

                //end notifikasi branch
            }
        }

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

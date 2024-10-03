<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $payments = Payment::where('status', 'pending')->where('is_scheduled',1)->get();

        foreach ($payments as $payment) {
            $apiResponse = $this->callBankApi($payment);

            if ($apiResponse['status'] == 'success') {
                $payment->update(['status' => 'success']);
                // ارسال پیامک یا ایمیل به کاربر
            } else {
                $payment->update(['status' => 'failed']);
                Log::error('پرداخت با مشکل مواجه شد با ID: ' . $payment->id);
            }
        }

    }


    protected function callBankApi($payment)
    {
        // اینجا کدهای لازم برای فراخوانی API بانکی نوشته میشود
        // فرض می‌کنیم یک API فرضی داریم که ریسپانسش به صورت زیر هست
        //  اینجا فقط برای مثال از یک آرایه استفاده می‌کنیم

        $response = [
            'status' => 'success', // یا 'failed'
            'message' => 'Transaction completed.',
        ];

        return $response;
    }


}

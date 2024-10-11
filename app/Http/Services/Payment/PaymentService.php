<?php
namespace App\Http\Services;

use App\Models\Expense;


class PaymentService
{
    public $expense;
    public $bankCode;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
        $this->bankCode = substr($expense->iban, 0, 2);

    }

    public function identifyBank()
    {
        if (!array_key_exists($this->bankCode, config('banks'))) {
            return back()->with('error', 'Invalid Sheba number.');
        }
    }

    public function getBankApi()
    {
        $banks = config('banks');
        return $banks[$this->bankCode] ?? null;
    }

    protected function callBankApi($payment, $amount, $iban)
    {
        $response = [
            'status' => 'success',
            'message' => 'Transaction completed.',
        ];

        return $response;
    }
}
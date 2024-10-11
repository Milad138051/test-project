<?php
namespace App\Http\Services;

use Exception;
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
            throw new Exception('Invalid Sheba number.');
        }
    }

    public function getBankApi(): ?array
    {
        $banks = config('banks');
        if (!$banks[$this->bankCode]) {
            throw new Exception('Bank Api Not Found.');
        }
        return $banks[$this->bankCode] ?? null;
    }


    protected function simulateBankApiResponse($payment, $amount, $iban, $status): array
    {
        $responses = [
            ['status' => 'success', 'message' => 'Transaction completed.'],
            ['status' => 'failed', 'message' => 'Transaction failed.'],
            ['status' => 'error', 'message' => 'Bank service unavailable.'],
        ];

        return $responses[$status];
    }


    protected function callBankApi($payment, $amount, $iban): array
    {
        if (!is_numeric($amount) || $amount <= 0) {
            throw new Exception('The amount must be a positive number.');
        }

        if (empty($payment)) {
            throw new Exception('Payment information cannot be empty.');
        }

        $status = 'succees'; //or failed or error
        $response = $this->simulateBankApiResponse($payment, $amount, $iban, $status);

        if ($response['status'] === 'failed' || $response['status'] === 'error') {
            throw new Exception($response['message']);
        }

        return $response;
    }




}
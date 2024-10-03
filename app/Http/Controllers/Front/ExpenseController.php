<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ExpenseRequest;
use App\Http\Services\File\FileService;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Ticket\TicketFile;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\ExpenseRepository;
use Faker\Provider\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    private $expenseRepository;
    private $categoryRepository;

    public function __construct(ExpenseRepository $expenseRepository,CategoryRepository $categoryRepository)
    {
        $this->expenseRepository = $expenseRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create()
    {
        //farzan categories ro hamin se ta dar nazar migirim va dige query nemizanim
        $categories=$this->categoryRepository->all();
        return view('front.expense.create', compact('categories'));
    }

    public function store(ExpenseRequest $request,FileService $fileService)
    {
        $inputs=$request->all();
        //فرضی
        $inputs['national_code'] = 123456789;

        // چک کردن وجود کاربر
        $user = User::where('national_code',$inputs['national_code'])->first();
        if (!$user) {
            return redirect()->back()->withErrors(['national_code' => 'کاربر وجود ندارد.']);
        }

        if($request->hasFile('attachment')) {
            $fileService->setExclusiveDirectory('attachments' . DIRECTORY_SEPARATOR . 'expenses');
            $fileService->setFileSize($request->file('attachment'));
            $result = $fileService->moveToPublic($request->file('attachment'));
            $inputs['attachment'] = $result;
        }
            //فرضی
        $inputs['user_id'] = 1;

//        Expense::create($inputs);
        $this->expenseRepository->create($inputs);
        return redirect()->route('expenses.index')->with('success', 'درخواست با موفقیت ثبت شد.');
    }

    public function myExpenses()
    {
        // farzan man user 1 hastam
        $expenses=$this->expenseRepository->where('user_id',1)->get();
        return view('front.expense.my-requests',compact('expenses'));
    }

    public function processPayment(Request $request,Expense $expense)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'sheba_number' => 'required|string',
        ]);

        // شناسایی بانک بر اساس شماره شبا
        $bankCode = substr($expense->iban, 0, 2);
        if (!in_array($bankCode, ['11', '22', '33'])) {
            return back()->with('error','Invalid Sheba number.');
        }
        $bankApi = $this->getBankApi($bankCode); // دریافت API مربوط به بانک

        $payment = Payment::create([
            'cost_request_id' => $expense->id,
            'amount' => $expense->amount,
            'sheba_number' => $expense->sheba_number,
            'bank_code' => $bankCode,
            'status' => 'pending',
        ]);

        try {

            $apiResponse = $this->callBankApi($bankApi, $payment->amount, $expense->iban);

            if ($apiResponse['status'] == 'success') {
                $payment->update(['status' => 'success']);
                return back()->with('success', 'پرداخت با موفقیت انجام شد.');
            } else {
                $payment->update(['status' => 'failed']);
                Log::error('Payment failed: ' . $apiResponse['message']);
                return back()->with('success', 'پرداخت با مشکل مواجه شد.');
            }
        }catch (\Exception $e) {
             Log::error('Exception during payment processing: ' . $e->getMessage());
}

}
    private function getBankApi($bankCode)
    {
        $banks = [
            '11' => ['name' => 'Bank 1', 'api_url' => 'https://api.bank1.com/pay'],
            '22' => ['name' => 'Bank 2', 'api_url' => 'https://api.bank2.com/pay'],
            '33' => ['name' => 'Bank 3', 'api_url' => 'https://api.bank3.com/pay'],
        ];

        return $banks[$bankCode] ?? null;
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


    public function schedulePayments(Expense $expense)
    {
        $payment=\App\Models\Payment::where('expense_id',$expense->id)->first();
        $payment->update(['is_scheduled'=>1]);
        return back()->with('message', 'پرداخت‌ بصورت روزانه زمان‌بندی شد.');
    }







}









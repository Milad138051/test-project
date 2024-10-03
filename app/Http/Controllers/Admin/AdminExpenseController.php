<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Category;
use App\Models\Expense;
use App\Repositories\ExpenseRepository;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AdminExpenseController extends Controller
{
    private $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses=$this->expenseRepository->all();
        return view('admin.expense.index',compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('admin.expense.show',compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->expenseRepository->deleteById($expense->id);
        return redirect()->route('admin.expenses.index')->with('success', 'عملیات با موفقیت ثبت شد.');

    }

    public function status(Expense $expense,Request $request)
    {
        if ($request->multi)
        {
//            edit mulii
            $ids=$request->multi;
            DB::table('expenses')->whereIn('id', $ids)->update([
                'status' => DB::raw('CASE
                                WHEN status = 0 THEN 1
                                WHEN status = 1 THEN 2
                                WHEN status = 2 THEN 1
                             END')
            ]);
        }else{
            // edit single one
            $input=$request->validate(['status'=>'required|integer|in:0,1,2']);
            $this->expenseRepository->updateById($expense->id,$input);
        }
        if ($expense->status==2){
            // send email
//            $emailService=new EmailService();
//            $details=[
//                'title'=>'request status',
//                'body'=>'your request rejected',
//            ];
//            $emailService->setDetails($details);
//            $emailService->setFrom('test email','example');
//            $emailService->setSubject('وضعیت درخواست');
//            $emailService->setTo($expense->user->email);
//            $messageService=new MessageService($emailService);
//            $messageService->send();


            // send sms
//            $smsService=new SmsService();
//            $smsService->setFrom(Config::get('sms.mobile_number'));
//            $smsService->setTo([ '0'. $expense->user->mobile]);
//            $smsService->setText('your request rejected');
//            $smsService->setIsFlash(true);
//            $messageService=new MessageService($smsService);

        }
        return back()->with('success', 'عملیات با موفقیت ثبت شد.');
    }

    public function rejectReason(Request $request,Expense $expense)
    {
        $input=$request->validate(['reason_for_not_approved'=>'required|string']);
        $expense->update($input);
        return back()->with('success', 'عملیات با موفقیت ثبت شد.');
    }
}

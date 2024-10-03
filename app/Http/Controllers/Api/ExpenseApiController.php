<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ExpenseRequest;
use App\Http\Resources\ExpenseCollection;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $inputs=$request->all();
        // چک کردن وجود کاربر
        $user = User::where('national_code', $request->national_code)->first();
        if (!$user) {
            return response()->json('')->isForbidden();
        }


        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $inputs['attachment'] = $path;
        }
        // ذخیره درخواست
        return new ExpenseCollection(Expense::create($inputs));
    }
}

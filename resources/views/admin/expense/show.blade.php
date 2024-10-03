@extends('admin.layouts.master')



@section('content')
    <section class="row">


        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش درخواست ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section class="card mb-3">
                    <section class="card-header bg-custom-yellow">
                        درخواست با کد : {{ $expense->id }}
                        از طرف : {{ $expense->user->email }}
                    </section>

                    <section class="card-body">
                        <p class="card-text">مبلغ : {{$expense->amount}}</p>
                        <p class="card-text">دسته بندی : {{$expense->category->title}}</p>
                        <p class="card-text">وضعیت  :
                            @if($expense->status==0)
                                در حال پردازش
                            @elseif($expense->status==1)
                                تایید شده
                            @else
                               رد شده
                            @endif
                        </p>
                        <p class="card-text">کد ملی کاربر : {{$expense->user->national_code}}</p>
                        <p class="card-text">توضیحات : {{ $expense->description }}</p>
                    </section>
                </section>

{{--                //status--}}
                <section class="card-body">
                    <form action="{{route('admin.expenses.status',$expense)}}" method="post">
                        @csrf
                        <p class="card-text">وضعیت درخواست</p>
                        <select name="status" id="" class="form-control">
                            <option value="1" class="form-control" @if($expense->status==1) selected @endif>تایید شده</option>
                            <option value="2" class="form-control" @if($expense->status==2) selected @endif>رد شده</option>
                            <option value="0" class="form-control" @if($expense->status==0) selected @endif>در حال پردازش</option>
                        </select>
                        <section class="mt-3">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </form>

                </section>

                @if($expense->attachment !==null)
                    <section class="card-footer">
                        <a class="btn btn-success" href="{{ asset($expense->attachment) }}" download>دانلود
                            ضمیمه</a>
                    </section>
                @endif

                @if ($expense->status == 2 and $expense->reason_for_not_approved == null)
                                    <section>
                                        <form action="{{route('admin.expenses.reject-reason',$expense)}}" method="post">
                                            @csrf
                                            <section class="row">
                                                <section class="col-12">
                                                    <div class="form-group">
                                                        <label for="reason_for_not_approved">دلیل رد شدن</label>
                                                        <textarea id="reason_for_not_approved" class="form-control form-control-sm" name="reason_for_not_approved" rows="4"></textarea>
                                                    </div>
                                                    @error('reason_for_not_approved')
                                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                            <strong>
                                                                {{ $message }}
                                                            </strong>
                                                        </span>
                                                    @enderror
                                                </section>

                                                <section class="col-12">
                                                    <button class="btn btn-primary btn-sm">ثبت</button>
                                                </section>
                                            </section>
                                        </form>
                                    </section>
                                @endif

            </section>
        </section>
    </section>
@endsection

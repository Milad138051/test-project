@extends('admin.layouts.master')

@section('head-tag')
    <title>درخواست هزینه ها</title>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">درخواست هزینه ها</h3>
                    <a href="#" class="btn btn-info btn-sm disabled"> ایجاد </a>
                    <button form="multiSelect" class="btn btn-warning btn-sm"> تغییر وضعیت چندتایی </button>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>selected</th>
                                <th>#</th>
                                <th>کاربر</th>
                                <th>دسته بندی</th>
                                <th>توضیحات</th>
                                <th>مبلغ</th>
                                <th>کد ملی</th>
                                <th style="width: 258px">tools</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($expenses as $key => $i)
                            <tr>
                                <form action="{{route('admin.expenses.status',$i)}}" id="multiSelect" method="post">
                                    @csrf
                                <td><input type="checkbox" name="multi[]" value="{{ $i->id }}"></td>
                                <th>{{$loop->iteration}}</th>
                                <td>{{$i->user->email ?? '-'}}</td>
                                <td>{{$i->category->title ?? '-'}}</td>
                                <td>{{Str::limit($i->description, 15) ?? '-'}}</td>
                                <td>{{$i->amount ?? '-'}}</td>
                                <td>{{$i->user->national_code ?? '-'}}</td>


                                <td class="width-22-rem text-left">
                                   <a href="{{route('admin.expenses.show',$i)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> مشاهده</a>
                               </td>
                           </tr>
                           @endforeach
                           </form>

                        </tbody>
                    </table>

                </div>

            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection


@section('script')


    <script type="text/javascript">
        function sweetalertStatusSuccess(msg) {
            $(document).ready(function() {
                Swal.fire({
                    title: msg,
                    text: 'عملیات با موفقیت انجام شد',
                    icon: 'success',
                    confirmButtonText: 'باشه',
                });
            });
        }

        function sweetalertStatusError(msg) {
            $(document).ready(function() {
                Swal.fire({
                    title: msg,
                    text: 'هنگام ویرایش مشکلی بوجود امده است',
                    icon: 'error',
                    confirmButtonText: 'باشه',
                });
            });
        }
    </script>

    <script type="text/javascript">
        function changeStatus(id) {
            var element = $("#" + id + '-status')
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            // successToast('ایتم با موفقیت فعال شد')
                            sweetalertStatusSuccess('ایتم با موفقیت تایید شد')

                        } else {
                            element.prop('checked', false);
                            // successToast('ایتم با موفقیت غیر فعال شد')
                            sweetalertStatusSuccess('ایتم با موفقیت رد شد')

                        }
                    } else {
                        element.prop('checked', elementValue);
                        // errorToast('هنگام ویرایش مشکلی بوجود امده است')
                        sweetalertStatusError('هنگام ویرایش مشکلی بوجود امده است')

                    }
                },
                error: function() {
                    element.prop('checked', elementValue);
                    // errorToast('ارتباط برقرار نشد')
                    sweetalertStatusError('ارتباط برقرار نشد')

                }
            });

            function sweetalertStatusSuccess(msg) {
                $(document).ready(function() {
                    Swal.fire({
                        title: msg,
                        text: 'عملیات با موفقیت انجام شد',
                        icon: 'success',
                        confirmButtonText: 'باشه',
                    });
                });
            }

            function sweetalertStatusError(msg) {
                $(document).ready(function() {
                    Swal.fire({
                        title: msg,
                        text: 'هنگام ویرایش مشکلی بوجود امده است',
                        icon: 'error',
                        confirmButtonText: 'باشه',
                    });
                });
            }

        }
    </script>



    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection

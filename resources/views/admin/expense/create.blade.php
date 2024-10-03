@extends('admin.layouts.master')


@section('head-tag')
    <title>دسته بندی ها</title>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">دسته بندی ها</h3>
                </div>

                <div class="card-body">
                    <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                        <a href="{{ route('admin.category.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                    </section>

                    <form action="{{route('admin.category.store')}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">نام </label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm" value="{{ old('title') }}">
                            @error('title')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">وضعیت</label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                <option value="0" @if(old('status') == 0) selected @endif>غیرفعال</option>
                            </select>
                            @error('status')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        </div>

                        <button type="submit" class="btn btn-success text-white">ثبت</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

<script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>

<script>
    CKEDITOR.replace('description');
</script>

@endsection


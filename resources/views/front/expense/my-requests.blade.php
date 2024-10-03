<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>my requests</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
</head>
<body>

<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">amount</th>
        <th scope="col">category</th>
        <th scope="col">status</th>
        <th scope="col">pay</th>
    </tr>
    </thead>
    <tbody>
    @foreach($expenses as $expense)
    <tr>
        <th scope="row">{{$loop->iteration}}</th>
        <td>{{$expense->amount}}</td>
        <td>{{$expense->category->title}}</td>
        <td>
            @if($expense->status==0)
                در حال پردازش
            @elseif($expense->status==1)
                تایید شده
            @else
                رد شده
            @endif
        </td>
        <td>
            @if($expense->status==1)
                <a class="btn btn-sm btn-success" href="{{route('expenses.processPayment',$expense)}}">پرداخت بصورت دستی</a>
                <a class="btn btn-sm btn-primary" href="{{route('expenses.schedule-payments',$expense)}}">پرداخت بصورت زمانبندی شده</a>

            @else
                <p class="text-danger">            درخواست هنوز تایید نشده است
                </p>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>

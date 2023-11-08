@extends('layouts.admin')
@section('title')
Danh sách danh mục
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Trả lời mail</h1>

        <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tiêu Đề</label>
                        <input type="text" class="form-control" name="subject" id="title" value="{{$contact->subject}}" disabled>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Người gửi</label>
                        <input target="_blank" class="form-control" name="name" id="slug" value="{{$contact->name}}" disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="title" value="{{$contact->email}}" disabled>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Số điện thoại</label>
                        <input target="_blank" class="form-control" name="name" id="slug" value="{{$contact->phone}}" disabled>
                    </div>
                </div>
            </div>


            <label for="image">Nội Dung</label> <br>
            <div class="">
                <div class="row_content ">
                    <textarea name="content" id="content123" cols="67" rows="10" width="100%" height="1000px">
                </textarea>

                </div>

            </div>
            <div class="col submit-button-container">
                <a href="{{route('contact.replied'}}"><button type="submit" class="btn btn-success" >Gửi mail</button></a>
                <a href="{{route('contact.index')}}"> <button class="btn btn-primary" type="button">Danh Sách</button></a>
                <button type="reset" class="btn btn-danger">Làm Lại</button>
            </div>
        </form>
    </div>
</body>

</html>
@endsection
@push('scripts')

@endpush
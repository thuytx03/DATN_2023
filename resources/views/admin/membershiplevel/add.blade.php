@extends('layouts.admin')
@section('title')
  Thêm mới Cấp Độ Thành Viên
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">  Thêm mới Cấp Độ Hội Viên </h1>
        @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

        <form action="{{route('MBSL.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3 mt-3">
                <label for="inputText" class="col-sm-2 col-form-label">Tên Cấp Độ <span class="text-danger">(*)</span></label>

                <div class="col-sm-10">
                    <input type="text" name="name" placeholder="Vui lòng nhập tên cấp độ" class="form-control" value="{{ old('name') }}">
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <label for="inputText" class="col-sm-2 col-form-label">Lợi Ích Nhận được (%)<span class="text-danger">(*)</span></label>

                <div class="col-sm-10">
                    <input type="text" name="benefits" placeholder="Vui lòng nhập Lợi Ích Nhận được (%)" class="form-control" value="{{ old('benefits') }}">
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <label for="inputText" class="col-sm-2 col-form-label">Lợi Ích Nhận được của đồ ăn(%)<span class="text-danger">(*)</span></label>

                <div class="col-sm-10">
                    <input type="text" name="benefits_food" placeholder="Vui lòng nhập Lợi Ích Nhận được (%)" class="form-control" value="{{ old('benefits_food') }}">
                </div>
            </div>
            

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Hạn mức tối thiểu <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="min_limit" placeholder="Vui lòng nhập hạn Mức " class="form-control" value="{{ old('min_limit') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Hạn mức tối đa<span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="max_limit" placeholder="Vui lòng nhập hạn Mức " class="form-control" value="{{ old('max_limit') }}">
                </div>
            </div>
           
           
           

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Mô tả</label>
                <div class="col-sm-10">
                    <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputStatus" class="col-sm-2 col-form-label">Trạng thái</label>
                <div class="col-sm-10">
                    <select id="inputStatus" name="status" class="form-control custom-select">
                        <option selected disabled>Chọn 1</option>
                        <option value="1" @if(old('status') == '1') selected @endif>Kích hoạt</option>
                        <option value="0" @if(old('status') == '0') selected @endif>Không kích hoạt</option>
                    </select>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                    <a href="{{ route('voucher.index') }}" class="btn btn-success text-white">Danh sách</a>
                    <button type="reset" class="btn btn-danger">Nhập lại</button>

                </div>
            </div>

        </form>

    </div>
@endsection
@push('scripts')
   
@endpush

@extends('layouts.admin')
@section('title')
  Cập nhật Cấp Độ Thành Viên
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Cập nhật Cấp Độ Thành Viên </h1>
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

        <form action="{{ route('MBSL.update', ['id' => $membershipLevel->id]) }}" method="PUT">
            @csrf
           
            
            <div class="row mb-3 mt-3">
                <label for="inputText" class="col-sm-2 col-form-label">Tên Cấp Độ <span class="text-danger">(*)</span></label>

                <div class="col-sm-10">
                    <input type="text" name="name" placeholder="Vui lòng nhập tên cấp độ" class="form-control" value="{{ old('name', $membershipLevel->name) }}">
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <label for type="inputText" class="col-sm-2 col-form-label">Lợi Ích Nhận được (%)<span class="text-danger">(*)</span></label>

                <div class="col-sm-10">
                    <input type="text" name="benefits" placeholder="Vui lòng nhập Lợi Ích Nhận được (%)" class="form-control" value="{{ old('benefits', $membershipLevel->benefits) }}">
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <label for type="inputText" class="col-sm-2 col-form-label">Lợi Ích Nhận được của đồ ăn (%)<span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="benefits_food" placeholder="Vui lòng nhập Lợi Ích Nhận được (%)" class="form-control" value="{{ old('benefits_food', $membershipLevel->benefits_food) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Hạn mức tối thiểu <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="min_limit" placeholder="Vui lòng nhập hạn Mức " class="form-control" value="{{ old('min_limit', $membershipLevel->min_limit) }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Hạn mức tối đa<span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="max_limit" placeholder="Vui lòng nhập hạn Mức " class="form-control" value="{{ old('max_limit', $membershipLevel->max_limit) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Mô tả</label>
                <div class="col-sm-10">
                    <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $membershipLevel->description) }}</textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputStatus" class="col-sm-2 col-form-label">Trạng thái</label>
                <div class="col-sm-10">
                    <select id="inputStatus" name="status" class="form-control custom-select">
                        <option value="1" @if(old('status', $membershipLevel->status) == '1') selected @endif>Kích hoạt</option>
                        <option value="0" @if(old('status', $membershipLevel->status) == '0') selected @endif>Không kích hoạt</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('voucher.index') }}" class="btn btn-success text-white">Danh sách</a>
                    <button type="reset" class="btn btn-danger">Nhập lại</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
@endpush
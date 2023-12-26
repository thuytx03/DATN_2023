@extends('layouts.admin')
@section('title')
  Cập nhật Thành Viên
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

        <form action="{{route('member.update',['id'=>$member->id])}}" method="PUT">
            @csrf
           
            
            <div class="row mb-3 mt-3">
                <label for type="inputText" class="col-sm-2 col-form-label">Mã Thẻ(%)<span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="card_number" class="form-control" value="{{ old('card_number', $member->card_number) }}" readonly>
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <label for="inputText" class="col-sm-2 col-form-label">Cấp Độ Thẻ hiện tại (%)<span class="text-danger">(*)</span></label>
                
                <div class="col-sm-10">
                    <select name="level_id" class="form-control">
                        @foreach ($membershipLevels as $level)
                            <option value="{{ $level->id }}" {{ $level->id == $member->level_id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <label for type="inputText" class="col-sm-2 col-form-label">Tổng Điểm Thưởng (%)<span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="total_bonus_points" class="form-control" value="{{ old('total_bonus_points', $member->total_bonus_points) }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Điểm Thưởng Hiện Tại <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="current_bonus_points" placeholder="Vui lòng nhập hạn Mức " class="form-control" value="{{ old('current_bonus_points', $member->current_bonus_points) }}" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Tặng Điểm <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="cong_current_bonus_points" placeholder="Vui lòng nhập hạn Mức " class="form-control" value="{{ old('cong_current_bonus_points') }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Giảm Điểm <span class="text-danger">(*)</span></label>
                <div class="col-sm-10">
                    <input type="text" name="tru_current_bonus_points" placeholder="Vui lòng nhập hạn Mức " class="form-control" value="{{ old('tru_current_bonus_points') }}">
                </div>
            </div>
           
            <div class="row mb-3">
                <label for="inputStatus" class="col-sm-2 col-form-label">Trạng thái</label>
                <div class="col-sm-10">
                    <select id="inputStatus" name="status" class="form-control custom-select">
                        <option value="1" @if(old('status', $member->status) == '1') selected @endif>Kích hoạt</option>
                        <option value="0" @if(old('status', $member->status) == '0') selected @endif>Không kích hoạt</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="" class="btn btn-success text-white">Danh sách</a>
                    <button type="reset" class="btn btn-danger">Nhập lại</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
@endpush

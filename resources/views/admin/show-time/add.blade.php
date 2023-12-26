@extends('layouts.admin')
@section('title')
    Thêm mới lịch chiếu
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm mới lịch chiếu</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form action="{{ route('show-time.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- DataTales Example -->
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <label for="room_id">Phòng chiếu<span class="text-danger">(*)</span></label>
                        <select id="room_id" class="form-control custom-select" name="room_id">
                            <option selected="" disabled="">Chọn 1</option>
                            @foreach($rooms as $room)
                                @if ($room->status != 2)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="movie_id">Bộ phim<span class="text-danger">(*)</span></label>
                        <select id="movie_id" class="form-control custom-select" name="movie_id">
                            <option selected="" disabled="">Chọn 1</option>
                            @foreach($movies as $movie)
                                @if ($movie->status != 0)
                                <option value="{{ $movie->id }}">{{ $movie->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Thời gian bắt đầu<span class="text-danger">(*)</span></label>
                        <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date">Thời gian kết thúc<span class="text-danger">(*)</span></label>
                        <input type="datetime-local" class="form-control" name="end_date" id="end_date" value="{{ old('end_date') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="thuong">Giá ghế thường<span class="text-danger">(*)</span></label>
                                <input type="text" placeholder="Giá ghế thường" class="form-control" name="thuong" id="thuong" value="{{ old('thuong') }}">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="vip">Giá ghế vip<span class="text-danger">(*)</span></label>
                                <input type="text" placeholder="Giá ghế vip" class="form-control" name="vip" id="vip" value="{{ old('vip') }}">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="doi">Giá ghế đôi<span class="text-danger">(*)</span></label>
                                <input type="text" placeholder="Giá ghế đôi" class="form-control" name="doi" id="doi" value="{{ old('doi') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái<span class="text-danger">(*)</span></label>
                        <select id="status" class="form-control custom-select" name="status">
                            <option selected="" disabled="">Chọn 1</option>
                            <option value="1" selected @if(old('type') == '1') selected @endif>Kích hoạt</option>
                            <option value="0" @if(old('type') == '0') selected @endif>Không kích hoạt</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer ">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                    <a href="{{ route('show-time.index') }}" class="btn btn-info">Danh sách</a>
                    <button type="reset" class="btn btn-secondary">Nhập lại</button>
                </div>
            </div>
        </form>

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('upload_file/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('upload_file/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('upload_file/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script>
        const imagePreview = document.getElementById('image_preview');
        const imageUrlInput = document.getElementById('image_url');

        $(function () {
            function readURL(input, selector) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        $(selector).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_url").change(function () {
                readURL(this, '#image_preview');
            });

        });
        imagePreview.addEventListener('click', function () {
            imageUrlInput.click();
        });

        imageUrlInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        // Add an event listener to select/deselect all checkboxes
        document.getElementById('select-all-checkboxes').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[name="parent_id[]"]');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });

    </script>
@endpush

<style>
    /*.image-list {*/
    /*    position: relative;*/
    /*}*/

    /*.delete-button {*/
    /*    position: absolute;*/
    /*    top: 0;*/
    /*    right: 12px;*/
    /*    background-color: red;*/
    /*    color: white;*/
    /*    border: none;*/
    /*    padding: 0.5rem;*/
    /*    font-size: 1rem;*/
    /*    cursor: pointer;*/
    /*}*/
</style>
@extends('layouts.admin')
@section('title')
    Cập nhập Phim
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Cập nhập phim</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

        <form action="{{ route('movie.update',['id' => $movie->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- DataTales Example -->
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Tên phim<span class="text-danger">(*)</span></label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{ $movie->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Đường dẫn<span class="text-danger">(*)</span></label>
                                        <input name="slug" type="text" id="slug" class="form-control" value="{{ $movie->slug }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="poster">Poster<span class="text-danger">(*)</span></label> <br>
                                        <input name="poster" type="file" id="image_url" style="display: none">
                                        <img src="{{ ($movie->poster == null) ? asset('images/image-not-found.jpg') : Storage::url($movie->poster) }}" width="130" height="110"
                                             id="image_preview" class="mt-1" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Ngày khởi chiếu<span class="text-danger">(*)</span></label>
                                        <input name="start_date" type="date" id="start_date" class="form-control" value="{{ substr($movie->start_date, 0, 10) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="duration">Thời lượng phim<span class="text-danger">(*)</span></label>
                                        <input name="duration" type="text" id="duration" class="form-control" value="{{ $movie->duration }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea id="description" name="description" class="form-control"
                                                  rows="4">{{ $movie->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="movie_image">Ảnh liên quan</label> <br>
                                        <input name="movie_image[]" type="file" id="image_url1" multiple
                                               class="form-control" style="display: none" accept="image/*">
                                        <img src="{{ asset('images/image-not-found.jpg') }}" width="110" height="90"
                                             id="image_preview1" class="mt-1" alt="">
                                        <div id="imagePreview" class="row mt-2 p-4">
                                            @foreach($images as $image)
                                            <div class="col-md-3 mt-3 image-list">
                                                <img src="{{ Storage::url($image->movie_image) }}" class="img-fluid">
{{--                                                <button class="delete-button" onclick="deleteImage(this)">X</button>--}}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="language">Ngôn ngữ<span class="text-danger">(*)</span></label>
                                        <input type="text" name="language" id="language" class="form-control" value="{{ $movie->language }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="trailer">Đoạn giới thiệu<span class="text-danger">(*)</span></label>
                                        <input type="text" name="trailer" id="trailer" class="form-control" value="{{ $movie->trailer }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="director">Đạo diễn<span class="text-danger">(*)</span></label>
                                        <input type="text" name="director" id="director" class="form-control" value="{{ $movie->director }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="actor">Diễn viên<span class="text-danger">(*)</span></label>
                                        <input type="text" name="actor" id="actor" class="form-control" value="{{ $movie->actor }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="manufacturer">Nhà sáng tác<span class="text-danger">(*)</span></label>
                                        <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="{{ $movie->manufacturer }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStatus">Thể loại<span class="text-danger">(*)</span></label>
                                        <div class="container">
                                            <div class="row">
                                                @foreach($genres as $genre)
                                                    <div class="col-md-3">
                                                        <label>
                                                            <input type="checkbox" name="genre_id[]"
                                                                   value="{{ $genre->id }}"   {{ in_array($genre->id, $movie->genres->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                            {{ $genre->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country_id">Quốc gia<span class="text-danger">(*)</span></label>
                                        <select id="country_id" name="country_id" class="form-control custom-select">
                                            <option selected="" disabled="">Chọn 1</option>
                                            @foreach($contries as $country)
                                                <option value="{{ $country->id }}" {{ $country->id == $movie->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStatus">Trạng thái</label>
                                        <select id="status" name="status" class="form-control custom-select">
                                            <option selected="" disabled="">Chọn 1</option>
                                            <option value="1" {{ $movie->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="0" {{ $movie->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer ">
                    <button type="submit" class="btn btn-success">Cập nhập</button>
                    <a href="{{ route('movie.index') }}" class="btn btn-info">Danh sách</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script>
        // function deleteImage(button) {
        //     // Assuming the image and the button are in the same parent element
        //     var imageContainer = button.parentElement;
        //     imageContainer.remove();
        // }
        const imagePreview = document.getElementById('image_preview');
        const imagePreview1 = document.getElementById('image_preview1');
        const imageUrlInput = document.getElementById('image_url');
        const imageUrlInput1 = document.getElementById('image_url1');
        $(document).ready(function () {
            $('#image_url1').on('change', function (event) {
                var files = event.target.files;

                $('#imagePreview').empty();

                for (var i = 0; i < files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagePreview').append(
                            '<div class="col-md-3 mt-3 image-list"><img src="' + e.target.result + '" class="img-fluid"></div>'
                        );
                    }
                    reader.readAsDataURL(files[i]);
                }
            });
        });
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
        imagePreview1.addEventListener('click', function () {
            imageUrlInput1.click();
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

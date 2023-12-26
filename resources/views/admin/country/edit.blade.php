@extends('layouts.admin')
@section('title')
Cập nhật quốc gia
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Cập nhật quốc gia </h1>
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

    <form action="{{ route('country.update',['id'=>$country->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3 mt-3">
            <label for="inputText" class="col-sm-2 col-form-label">Tên quốc gia:</label>
            <div class="col-sm-10">
                <input type="text" name="name" placeholder="Vui lòng nhập tên quốc gia" class="form-control" value="{{ $country->name }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Hình ảnh <span class="text-danger">(*)</span></label>
            <div class="col-sm-10">
                <input name="image" type="file" id="image_url" style="display: none">
                <img src="{{ Storage::url($country->image) }}" width="150" height="130" id="image_preview" class="mt-1" alt="">
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Mô tả</label>
            <div class="col-sm-10">
                <textarea id="description" name="desc" class="form-control" rows="4">{{ $country->desc }}</textarea>

            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('country.index') }}" class="btn btn-success text-white">Danh sách</a>
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

    $(function() {
        function readURL(input, selector) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $(selector).attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image_url").change(function() {
            readURL(this, '#image_preview');
        });

    });
    imagePreview.addEventListener('click', function() {
        imageUrlInput.click();
    });

    imageUrlInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    // Add an event listener to select/deselect all checkboxes
    document.getElementById('select-all-checkboxes').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="parent_id[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });
</script>

@endpush
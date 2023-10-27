@extends('layouts.admin')
@section('title')
Thêm mới món ăn
@endsection
@section('content')
<style>
  div.scroll {
  background-color: #white;
 border:1px solid;
  height: 350px;
  overflow-x: hidden;
  overflow-y: auto;

  padding: 20px;
}
</style>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"> Thêm mới món ăn</h1>
        @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

        <form action="{{route('movie-foode.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- DataTales Example -->
            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Tên Sản Phẩm</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Tên Đường Dẫn</label>
                        <input type="text" id="slug" name="slug" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">Giá</label>
                        <input type="text" id="name" name="price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Số Lượng</label>
                        <input type="number" min="1" id="name" name="quantity" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea id="ckeditor1" name="description"  class="form-control" rows="4"></textarea>
                    </div>
                </div>
                    <div class="col-md-6">
                    <div class="scroll">
                        <div class="form-group" >
                            <label for="parent_id">Loại Danh Mục</label>
                            @foreach($Foodstypes as $Foodstype)
                            @if($Foodstype->parent_id == 0)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$Foodstype->id}}" id="{{$Foodstype->id}}" name="foodstypes[]">
                                    <label class="form-check-label" for="{{$Foodstype->id}}">
                                        {{$Foodstype->name}}
                                    </label>
                                </div>

                                @foreach($Foodstypes as $Foodstylechild)
                                    @if($Foodstylechild->parent_id == $Foodstype->id && $Foodstylechild->status == 1)
                                        <div class="form-check ml-3">
                                            <input class="form-check-input" type="checkbox" value="{{$Foodstylechild->id}}" name="foodstypes[]" id="{{$Foodstylechild->id}}">
                                            <label class="form-check-label" for="{{$Foodstylechild->id}}">
                                                {{$Foodstylechild->name}}
                                            </label>
                                        </div>
                                        @foreach($Foodstypes as $Foodstylechild1)
                                            @if($Foodstylechild1->parent_id == $Foodstylechild->id && $Foodstylechild1->status == 1)
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="checkbox" value="{{$Foodstylechild1->id}}" name="foodstypes[]" id="{{$Foodstylechild1->id}}">
                                                    <label class="form-check-label" for="{{$Foodstylechild1->id}}">
                                                        {{$Foodstylechild1->name}}
                                                    </label>
                                                </div>

                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        </div>
                    </div>

                    <div class="form-group" style="text-align :center">
                        <label for="image">Ảnh</label> <br>
                        <input name="image" type="file" id="image_url" style="display: none" >
                        <img src="{{ asset('images/image-not-found.jpg') }}" width="150"  height="130" id="image_preview" class="mt-1" alt="">
                    </div>
                </div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer ">
                    <button type="submit" class="btn btn-success">Thêm mới</button>
                    <button type="reset" class="btn btn-info">Nhập Lại</button>
                    <a href="{{route('movie-foode.index')}}" class="btn btn-info">Danh sách</a>

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
        document.getElementById('select-all-checkboxes').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[name="parent_id[]"]');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });

    </script>
@endpush

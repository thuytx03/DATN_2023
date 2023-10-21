@extends('layouts.admin')
@section('content')

@section('title')
Sửa loại phòng
@endsection
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{route('list-room-type')}}" class="btn btn-success m-3">Danh sách loại phòng</a>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{route('update-room-type',['id'=>$roomType->id])}}" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-2 text-gray-800">Sửa loại phòng</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên loại phòng</label>
                            <input type="text" class="form-control" name="name" value="{{$roomType->name}}" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" name="description" value="{{$roomType->description}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Hình ảnh</label>
                            <br>
                            <img id="mat_truoc_preview" src="{{ $roomType->image?''.Storage::url($roomType->image):''}}" alt="your image" style="max-width: 200px; height:100px; margin-bottom: 10px;" class="img-fluid" />
                            <input type="file" name="image" accept="image/*" class="form-control-file @error('image') is-invalid @enderror" id="cmt_truoc" value="{{ $roomType->image?''.Storage::url($roomType->image):''}}">
                            <label for="cmt_truoc"></label><br />
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Đường dẫn</label>
                            <input type="text" class="form-control" name="slug" value="{{$roomType->slug}}" id="slug">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Trạng thái</label>
                            <br>
                            <select class="form-select border border-1 rounded w-100 p-2" name="status">
                                <option value="1" {{$roomType->status == 1 ? 'selected':''}}>Hoạt động</option>
                                <option value="2" {{$roomType->status != 1 ? 'selected':''}}>Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <button type="reset" class="btn btn-danger">Nhập lại</button>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
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
        $("#cmt_truoc").change(function() {
            readURL(this, '#mat_truoc_preview');
        });

    });

    document.getElementById('name').addEventListener('input', function() {
        let nameValue = this.value
            .toLowerCase()
            .normalize('NFD') // Normalize to decomposed form
            .replace(/[\u0300-\u036f]/g, '') // Remove diacritics
            .replace(/[^\w\s-]/g, '') // Remove special characters except for spaces and hyphens
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-'); // Replace multiple consecutive hyphens with a single hyphen

        document.getElementById('slug').value = nameValue;
    });
</script>
@endpush

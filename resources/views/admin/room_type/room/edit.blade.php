@extends('layouts.admin')
@section('content')

@section('title')
Sửa phòng
@endsection
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{route('room.list')}}" class="btn btn-success m-3">Danh sách phòng</a>
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
            <form method="post" action="{{route('room.update',['id'=>$room->id])}}" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-2 text-gray-800">Sửa phòng</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" name="name" value="{{$room->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Loại phòng</label>
                            <br>
                            <select class="form-select border border-1 rounded w-100 p-2" name="room_type_id">
                                @foreach($typeRoom as $typeRoom)
                                <option value="{{$typeRoom->id}}" {{$typeRoom->id === $room->room_type_id ? 'selected':''}}>{{$typeRoom->name}}</option>
                                <!-- Add more options as needed -->
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên rạp</label>
                            <br>
                            <select class="form-select border border-1 rounded w-100 p-2" name="cinema_id">
                            @foreach($cinema as $cinema)
                                <option value="{{$cinema->id}}" {{$cinema->id === $room->room_type_id ? 'selected':''}}>{{$cinema->name}}</option>
                                @endforeach
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" name="description" value="{{$room->description}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Hình ảnh</label>
                            <br>
                            <img id="mat_truoc_preview" src="{{ $room->image?''.Storage::url($room->image):''}}" alt="your image" style="max-width: 200px; height:100px; margin-bottom: 10px;" class="img-fluid" />
                            <input type="file" name="image" accept="image/*" class="form-control-file @error('image') is-invalid @enderror" id="cmt_truoc" value="{{ $room->image?''.Storage::url($room->image):''}}">
                            <label for="cmt_truoc"></label><br />
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Trạng thái</label>
                            <br>
                            <select class="form-select border border-1 rounded w-100 p-2" name="status">
                                <option value="1" {{$room->status == 1 ? 'selected':''}}>Hoạt động</option>
                                <option value="2" {{$room->status != 1 ? 'selected':''}}>Không hoạt động</option>
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


</script>
@endpush

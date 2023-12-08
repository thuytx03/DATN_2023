@extends('layouts.admin')
@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{route('role.list')}}" class="btn btn-success m-3">Danh sách vai trò</a>
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
            <form method="post" action="{{route('role.add')}}" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-2 text-gray-800">Thêm mới vai trò</h1>
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="" class="btn btn-success">Vai trò</label>
                            <hr>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên vai trò</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên hiển thị</label>
                                <input type="text" class="form-control" name="display_name">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nhóm</label>
                                <input type="text" class="form-control" name="group">
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                            <button type="reset" class="btn btn-danger">Nhập lại</button>
                        </div>
                        
                        <div class="col-md-7">
                            <label for="" class="btn btn-success mb-2">Quyền</label>
                            <div class="form-check">
                                <input class="form-check-input select-all-checkbox" type="checkbox" id="selectAllAll">
                                <label class="form-check-label" for="selectAllAll">
                                    Chọn tất cả
                                </label>
                            </div>
                            <hr>
                            <div class="row">
                                @foreach($cinemas as $item)
                                <div class="form-check m-3">
                                    <input class="form-check-input permission-checkbox" type="checkbox" value="{{$item->id}}" id="{{$item->id}}" name="cinema[]" checked>
                                    <label class="form-check-label" for="{{$item->id}}">
                                        {{$item->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach($permission as $groupName => $per)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <hr>
                                        <h6 class="text-capitalize fw-bold">{{ $groupName }}</h6>
                                        <input class="form-check-input select-all-checkbox" type="checkbox" id="selectAll{{$groupName}}">
                                        <label class="form-check-label" for="selectAll{{$groupName}}">
                                            Chọn tất cả {{$groupName}}
                                        </label>
                                    </div>
                                    <hr>
                                    @foreach($per as $item)
                                    <div class="form-check">
                                        <input class="form-check-input permission-checkbox" type="checkbox" value="{{$item->name}}" id="{{$item->id}}" name="permission[]">
                                        <label class="form-check-label" for="{{$item->id}}">
                                            {{$item->name}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>

                        </div>
                       
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function selectAllCheckbox() {
        document.getElementById('selectAllAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.permission-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        let permissionCheckboxes = document.getElementsByClassName('permission-checkbox');
        for (let checkbox of permissionCheckboxes) {
            checkbox.addEventListener('change', function() {
                document.getElementById('selectAllAll').checked = [...permissionCheckboxes].every(checkbox => checkbox.checked);
            });
        }
    }

    selectAllCheckbox();
</script>

@endpush
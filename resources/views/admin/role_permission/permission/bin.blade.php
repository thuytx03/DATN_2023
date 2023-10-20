@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{route('list-permission')}}">
                <button class="btn btn-primary">Danh sách quyền</button>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Tên quyền</th>
                            <th>Tên hiển thị</th>
                            <th>Nhóm</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($softDeletedPermissions as $softDeletedPermissions)
                        <tr class="">
                            <td><input type="checkbox" class="child-checkbox"></td>
                            <td>{{$softDeletedPermissions->name}}</td>
                            <td>{{$softDeletedPermissions->display_name}}</td>
                            <td>{{$softDeletedPermissions->group}}</td>
                            <td class="col-3">
                                <a href="{{route('restore-bin-permission',['id'=>$softDeletedPermissions->id])}}">
                                    <button class="btn btn-primary m-2">Khôi phục</button>
                                </a>
                                <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>Xóa vĩnh viễn</button>

                                <form action="{{route('delete-bin-permission',['id'=>$softDeletedPermissions->id])}}" method="post" id="delete">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
<!-- Page level custom scripts -->
<script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        var switches = Array.from(document.querySelectorAll('.switch1'));
        switches.forEach(function(elem) {
            new Switchery(elem);
        });
    });
</script>
<script type="text/javascript">
    function alertConfirmation() {
        $('.show_confirm').click(function(event) {
            event.preventDefault();
            var form = $(this).next("form"); // Changed closest() to next()
            var name = $(this).data("name");

            swal({
                    title: `Bạn có muốn xóa quyền này không ?`, // Include the item's name
                    text: "Nếu bạn xóa, Nó sẽ biến mất mãi mãi!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    }

    alertConfirmation();


    function selectAllCheckbox() {
        document.getElementById('select-all').addEventListener('change', function() {
            let checkboxes = document.getElementsByClassName('child-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        let childCheckboxes = document.getElementsByClassName('child-checkbox');
        for (let checkbox of childCheckboxes) {
            checkbox.addEventListener('change', function() {
                document.getElementById('select-all').checked = false;
            });
        }
    }

    selectAllCheckbox();
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
@endpush
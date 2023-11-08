@extends('layouts.admin')
@push('styles')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('title')
    Danh sách Điểm Thưởng
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">  Danh sách Điểm Thưởng</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <a href="" class="btn btn-success">
                            Danh Sách
                        </a>
                    </div>
                    <div class="col text-right">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-expanded="false">
                                Hành động
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="">Thùng rác</a>
                                <a href="{{route('MBSL.deleteAll')}}" id="delete-selected" class="dropdown-item">Xoá đã chọn</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="dataTable_length"><label>Hiển thị <select
                                            name="dataTable_length" aria-controls="dataTable"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> Mục</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="dataTables_length mr-2" id="dataTable_length"><label>Lọc
                                                <select name="status" aria-controls="dataTable"
                                                    class="custom-select custom-select-sm form-control ">
                                                    <option value="all">Vui lòng chọn</option>
                                                    <option value="1">Hoạt động</option>
                                                    <option value="0">Không hoạt động</option>
                                                  
                                                </select>
                                            </label>
                                        </div>
                                        <div id="dataTable_filter" class="dataTables_filter"><label>
                                                <input type="search" name="search" class="form-control form-control-sm"
                                                    placeholder="" aria-controls="dataTable">
                                                <button class="btn btn-outline-success form-control-sm" type="submit">
                                                    Tìm kiếm
                                                </button>
                                            </label>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered text-center mt-2" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="">
                                                <input type="checkbox" class="" id="select-all">
                                            </th>
                                            <th scope="col">Tên Tài Khoản</th>
                                            <th scope="col">mã thẻ Thẻ</th>
                                            <th scope="col">Cấp Độ Thẻ năm {{ date('Y') - 1 }}</th>
                                            <th scope="col">Cấp Độ Thẻ hiện tại</th>
                                            <th scope="col">Tổng Điểm Thưởng </th>
                                            <th scope="col">Điểm Thưởng sắp nhận được</th>
                                            <th scope="col">Điểm Thưởng Hiện Tại</th>
                                            <th scope="col">Tổng Chi Tiêu </th>
                                            <th scope="col">Trạng Thái</th>
                                            <th scope="col">Mô Tả</th>
                                           
                                            <th scope="col">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listLevel as $value)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="child-checkbox" name="ids[]" value="{{ $value->id }}">
                                            </td>
                                            @php
                                    $user = $users->firstWhere('id', $value->user_id);
                                         $userBookings = $bookings->where('user_id', $user->id);
                                        $total = 0; // Khởi tạo biến tổng
                                        $currentYear = date('Y'); // Lấy năm hiện tại

                                        foreach ($userBookings as $booking) {
                                            if (is_numeric($booking->total)) {
                                                $createdAtYear = date('Y', strtotime($booking->created_at));
                                                $updatedAtYear = date('Y', strtotime($booking->updated_at));

                                                // Kiểm tra xem booking được tạo hoặc cập nhật trong năm hiện tại
                                                if ($createdAtYear == $currentYear && $updatedAtYear == $currentYear) {
                                                    $total += $booking->total;
                                                }
                                                

                                            }
                                        }
                                            // Sử dụng $total theo nhu cầu
                                            $MembershipLevel = $MembershipLevels->firstWhere('id', $value->level_id);
                                            $MembershipLevel1 = $MembershipLevels->firstWhere('id', $value->level_id_old);
                                            // Lưu giá trị total tính toán được vào biến $totalForUser
                                            $totalForUser = $total;
                                    
                                            // Tìm các mức MembershipLevel có min_limit cao hơn nhưng nhỏ nhất trong danh sách tìm được
                                         
                                            @endphp
                                    
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $value->card_number }}</td>
                                            <td>{{ $MembershipLevel1->name ?? 'Chưa có level' }}</td>
                                            <td>{{ $MembershipLevel->name ?? 'Chưa có level' }}</td>
                                    
                                            <td>
                                                @if ($totalForUser <= 0)
                                                Chưa có thanh toán
                                                @else
                                                {{ $totalForUser }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->bonus_points_will_be_received <= 0)
                                                Chưa có thanh toán
                                                @else
                                                {{ $value->bonus_points_will_be_received }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->current_bonus_points <= 0)
                                                Chưa có thanh toán
                                                @else
                                                {{ $value->current_bonus_points }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($totalForUser <= 0)
                                                Chưa có thanh toán
                                                @else
                                                @php
                                                if ($updatedAtYear < $currentYear) {
            // Nếu đã hết năm, cập nhật `level_id` thành `level_id_old`
            $user->level_id_old = $user->level_id;
            $user->level_id = // Đặt giá trị mới tại đây;
            $levelIdUpdated = true; // Đánh dấu đã cập nhật
        }
    // Tạo một danh sách MembershipLevels theo thứ tự tăng dần của min_limit
    $sortedMembershipLevels = $MembershipLevels->sortBy('min_limit');

    if ($totalForUser > 0) {
        // Tìm mức MembershipLevel có min_limit lớn nhất nhưng nhỏ hơn số tiền chi tiêu
        $higherMembershipLevel = $sortedMembershipLevels->where('min_limit', '<', $totalForUser)->last();

        if ($higherMembershipLevel) {
            // Cập nhật level_id của người dùng thành id của mức MembershipLevel tìm thấy
            $value->level_id = $higherMembershipLevel->id;
            $value->save();
        }
    }
@endphp


                                                {{ number_format($totalForUser, 0, '.', ',') }} VND
                                                @endif
                                            </td>
                                            </td>
                                    
                                            <td>
                                                <div class="form-check form-switch">
                                                    <a href="{{ route('member.changeStatus',['id' => $value->id]) }}"><input type="checkbox" class="switch1"
                                                            data-id="{{ $value->id }}" {{ $value->status == 1 ? 'checked' : '' }} /></a>
                                                </div>
                                            </td>
                                            <td>{{ $value->Description }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn " type="button" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('MBSL.edit', ['id' => $value->id]) }}">Sửa</a>
                                                        <a class="dropdown-item show_confirm"
                                                            href="{{ route('MBSL.destroy', ['id' => $value->id]) }}">Xoá
                                                        </a>
                                    
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                   
                                             

                                                    <div class="dropdown">
                                                        <button class="btn " type="button" data-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                                href="">Sửa</a>
                                                            <a class="dropdown-item show_confirm"
                                                                href="">Xoá
                                                            </a>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                    Hiển thị {{ $listLevel->firstItem() }} đến {{ $listLevel->lastItem() }}
                                    của {{ $listLevel->total() }} mục
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        {{ $listLevel->links('pagination::bootstrap-4') }}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                var href = $(this).attr("href"); // Lấy URL từ thuộc tính href của thẻ <a>
                var name = $(this).data("name");
                event.preventDefault();

                Swal.fire({
                        title: 'Xác nhận xóa',
                        text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // Người dùng đã xác nhận xóa
                            // Chuyển hướng đến URL xóa
                            window.location.href = href;
                        } else {
                            // Người dùng đã bấm nút "Hủy"
                            // Không làm gì cả hoặc có thể xử lý khác nếu cần
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

        function updateStatus() {

            $(document).ready(function() {
                $('.switch-status').change(function() {
                    const itemId = $(this).data('item-id');
                    const status = this.checked ? 1 : 2;

                    $.ajax({
                        method: 'POST',
                        url: '/admin/voucher/update-status/' + itemId,
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function(data) {
                            // Xử lý phản hồi thành công (nếu cần)
                        },
                        error: function(error) {
                            // Xử lý lỗi (nếu có)
                        }
                    });
                });
            });
        }
        updateStatus();

        function deleteSelected() {
            $(document).ready(function() {
                $('#delete-selected').click(function(e) {
                    e.preventDefault();

                    var selectedCheckboxes = $('.child-checkbox:checked');

                    if (selectedCheckboxes.length > 0) {
                        Swal.fire({
                            title: 'Xác nhận xóa',
                            text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var selectedIds = [];
                                selectedCheckboxes.each(function() {
                                    selectedIds.push($(this).val());
                                });

                                $.ajax({
                                    type: 'POST',
                                    url: '/admin/membershiplevels/deleteAll', // Thay thế bằng tuyến đường xử lý xoá của bạn
                                    data: {
                                        ids: selectedIds,
                                        _token: '{{ csrf_token() }}',
                                    },
                                    success: function(response) {
                                        // Xử lý phản hồi từ máy chủ nếu cần
                                        location.reload();
                                    },
                                    error: function() {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                });
            });


        }
        deleteSelected();
    </script>
@endpush

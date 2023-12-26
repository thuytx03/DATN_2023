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
                               
                            
                                <a class="dropdown-item" href="{{route('member.unTrashAll')}}" id="restore-selected" >Khôi phục mục đã chọn</a>
                                <a href="{{route('member.permanentlyDeleteSelected')}}" id="delete-selected" class="dropdown-item">Xoá vĩnh viễn các mục đã chọn</a>
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
$poin_will_cailm = 0; // Khởi tạo biến điểm thưởng
$currentYear = date('Y'); // Lấy năm hiện tại
$total = 0; // Khởi tạo biến tổng
$MembershipLevel = $MembershipLevels->firstWhere('id', $value->level_id);
                                            $MembershipLevel1 = $MembershipLevels->firstWhere('id', $value->level_id_old);

foreach ($userBookings as $booking) {
    if (is_numeric($booking->total)) {
        $createdAtYear = date('Y', strtotime($booking->created_at));
        $updatedAtYear = date('Y', strtotime($booking->updated_at));
        $showtime_id = $booking->showtime_id;

        $showtime = $ShowTimes->where('id', $showtime_id)->first();

        if ($showtime) {
            $showtime_end = strtotime($showtime->end_date);
            $current_time = time();

            // Kiểm tra xem thời gian hiện tại có lớn hơn thời gian showtime_end
            if ($current_time < $showtime_end) {
              
                if (isset($booking->price_ticket) && isset($booking->price_food)) {
                    $benefit_percentage = $MembershipLevel->benefits / 100;
                    $benefit_percentage1 = $MembershipLevel->benefits_food / 100;
                    $price_ticket_poin = ($booking->price_ticket) * $benefit_percentage;
                    $price_ticket__food_poin = ($booking->price_food) * $benefit_percentage1;
                    $poin_will_cailm += $price_ticket_poin + $price_ticket__food_poin;
                }
                elseif(isset($booking->price_ticket)) {
                    $benefit_percentage = $MembershipLevel->benefits / 100;
                    $price_ticket_poin = ($booking->price_ticket) * $benefit_percentage;
                    $poin_will_cailm += $price_ticket_poin;
                }
            }elseif($current_time > $showtime_end && $booking->status == 3) {
                $MembershipLevel->current_bonus_points += $poin_will_cailm;
                $MembershipLevel->total_bonus_poin += $poin_will_cailm;
            $MembershipLevel->save();
            } 
        }

        // Kiểm tra xem booking được tạo hoặc cập nhật trong năm hiện tại
        if ($createdAtYear == $currentYear && $updatedAtYear == $currentYear) {
            $total += $booking->total;
        }
    }
}
      
                                            // Sử dụng $total theo nhu cầu
                                        //   dd($poin_will_cailm);
                                            // Lưu giá trị total tính toán được vào biến $totalForUser
                                            $totalForUser = $total;
                                            $value->total_spending = $totalForUser;
                                            $value->save();
                                            // Tìm các mức MembershipLevel có min_limit cao hơn nhưng nhỏ nhất trong danh sách tìm được
                                         
                                            @endphp
                                    
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $value->card_number }}</td>
                                            <td>{{ $MembershipLevel1->name ?? 'Chưa có level' }}</td>
                                            <td>{{ $MembershipLevel->name ?? 'Chưa có level' }}</td>
                                    
                                            <td>
                                                @if ($value->total_bonus_points <= 0)
                                                Chưa có thanh toán
                                                @else
                                                {{ $value->total_bonus_points }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($poin_will_cailm <= 0)
                                                Chưa có thanh toán
                                                @else
                                                {{$poin_will_cailm}}
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
            $value->level_id_old = $value->level_id;
            $value->level_id = // Đặt giá trị mới tại đây;
            $levelIdUpdated = true; // Đánh dấu đã cập nhật
        }
    // Tạo một danh sách MembershipLevels theo thứ tự tăng dần của min_limit
    $sortedMembershipLevels = $MembershipLevels->sortBy('min_limit');

// Tìm mức MembershipLevel có khoảng min_limit và max_limit mà số tiền chi tiêu nằm trong đó
$selectedMembershipLevel = $sortedMembershipLevels->first(function ($level) use ($totalForUser) {
    if ($totalForUser >= $level->min_limit && ($level->max_limit === null || $totalForUser <= $level->max_limit)) {
        
    }elseif ($totalForUser !=$level->min_limit && ($level->max_limit === null || $totalForUser <= $level->max_limit)) {
        return;
    } 
});

if ($selectedMembershipLevel) {
    // Kiểm tra nếu level_id mới lớn hơn hoặc bằng level_id hiện tại của người dùng
    // và min_limit của mức đã chọn lớn hơn hoặc bằng min_limit hiện tại của người dùng
    if ($value->max_limit <= $selectedMembershipLevel->min_limit) {
        $value->level_id = $selectedMembershipLevel->id;
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
                                                        <a class="dropdown-item" href="{{ route('member.restore', ['id' => $value->id]) }}">Khôi Phục</a>
                                                        <a class="dropdown-item show_confirm"
                                                            href="{{ route('member.permanentlyDelete', ['id' => $value->id]) }}">Xoá
                                                        </a>
                                    
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                   
                                             

                                                 
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
        function restoreSelected() {
            $(document).ready(function() {
                $('#restore-selected').click(function(e) {
                    e.preventDefault();

                    var selectedCheckboxes = $('.child-checkbox:checked');

                    if (selectedCheckboxes.length > 0) {
                        Swal.fire({
                            title: 'Xác nhận khôi phục',
                            text: 'Bạn có chắc chắn muốn khôi phục các mục đã chọn?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Khôi phục',
                            cancelButtonText: 'Hủy',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var selectedIds = [];
                                selectedCheckboxes.each(function() {
                                    selectedIds.push($(this).val());
                                });

                                $.ajax({
                                    type: 'POST',
                                    url: '/admin/member/unTrashAll',
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
        restoreSelected();

        function deleteSelected() {
            $(document).ready(function() {
                $('#delete-selected').click(function(e) {
                    e.preventDefault();

                    var selectedCheckboxes = $('.child-checkbox:checked');

                    if (selectedCheckboxes.length > 0) {
                        Swal.fire({
                            title: 'Xác nhận xóa',
                            text: 'Bạn có chắc chắn muốn xóa vĩnh viễn các mục đã chọn?',
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
                                    url: '/admin/member/permanentlyDeleteSelected', // Thay thế bằng tuyến đường xử lý xoá của bạn
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

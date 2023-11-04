@extends('layouts.admin')
@section('title')
    Thêm mới ghế
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm mới ghế</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('seat.store') }}">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-12 mt-3">
                        <label for="province_id">Tỉnh:</label>
                        <select name="province_id" id="province_id" class="form-control">
                            <option value="">Vui lòng chọn</option>
                            @foreach ($province as $value)
                                <option value="{{ $value->id }}" >{{ $value->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-4 col-12 mt-3">
                        <label for="cinema_id">Rạp:</label>
                        <select name="cinema_id" id="cinema_id" class="form-control" disabled>
                            <option value="">Chọn tỉnh trước</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-3">
                        <label for="room_id">Phòng:</label>
                        <select name="room_id" id="room_id" class="form-control" disabled>
                            <option value="">Chọn rạp trước</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12 mt-3">
                        <div class="form-group">
                            <label for="standard_quantity">Số lượng ghế Thường:</label>
                            <input type="text" name="standard_quantity" value="{{ old('standard_quantity') }}" id="standard_quantity" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4 col-12 mt-3">
                        <div class="form-group">
                            <label for="vip_quantity">Số lượng ghế VIP:</label>
                            <input type="text" name="vip_quantity" value="{{ old('vip_quantity') }}" id="vip_quantity" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4 col-12 mt-3">
                        <div class="form-group">
                            <label for="couple_quantity">Số lượng ghế Cặp đôi:</label>
                            <input type="text" name="couple_quantity" value="{{ old('couple_quantity') }}" id="couple_quantity" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 col-12 mt-1">
                        <div class="form-group">
                            <label for="total_seats">Tổng số ghế:</label>
                            <input type="text" name="total_seats" id="total_seats" class="form-control" readonly>
                        </div>
                    </div>

                    <script>
                        // Lấy các trường số lượng ghế
                        var vipQuantityInput = document.getElementById('vip_quantity');
                        var standardQuantityInput = document.getElementById('standard_quantity');
                        var coupleQuantityInput = document.getElementById('couple_quantity');
                        var totalSeatsInput = document.getElementById('total_seats');

                        // Sử dụng sự kiện 'input' để cập nhật tổng số ghế khi người dùng nhập số lượng
                        vipQuantityInput.addEventListener('input', updateTotalSeats);
                        standardQuantityInput.addEventListener('input', updateTotalSeats);
                        coupleQuantityInput.addEventListener('input', updateTotalSeats);

                        function updateTotalSeats() {
                            var vipQuantity = parseInt(vipQuantityInput.value) || 0;
                            var standardQuantity = parseInt(standardQuantityInput.value) || 0;
                            var coupleQuantity = parseInt(coupleQuantityInput.value) || 0;

                            var totalSeats = vipQuantity + standardQuantity + coupleQuantity;
                            totalSeatsInput.value = totalSeats;
                        }
                    </script>

                </div>

            </div>

            <button type="submit" class="btn btn-success">Thêm Ghế</button>
            <button type="reset" class="btn btn-danger">Nhập lại</button>
            <a href="{{ route('seat.index') }}" class="btn btn-primary">Danh sách</a>
        </form>



    </div>
@endsection
@push('scripts')
<script>
    var provinceSelect = document.getElementById('province_id');
    var cinemaSelect = document.getElementById('cinema_id');
    var roomSelect = document.getElementById('room_id');

    provinceSelect.addEventListener('change', function() {
        var selectedProvinceId = provinceSelect.value;
        cinemaSelect.innerHTML = '<option value="">Chọn rạp</option>';
        roomSelect.innerHTML = '<option value="">Chọn phòng</option>';

        if (selectedProvinceId) {
            // Sử dụng Ajax để lấy danh sách các rạp thuộc tỉnh đã chọn
            $.get('/admin/seat/get-cinemas/' + selectedProvinceId, function(data) {
                data.forEach(function(cinema) {
                    var option = document.createElement('option');
                    option.value = cinema.id;
                    option.textContent = cinema.name;
                    cinemaSelect.appendChild(option);
                });

                cinemaSelect.disabled = false;
            });
        } else {
            cinemaSelect.disabled = true;
        }
    });

    cinemaSelect.addEventListener('change', function() {
        var selectedCinemaId = cinemaSelect.value;
        roomSelect.innerHTML = '<option value="">Chọn phòng</option>';

        if (selectedCinemaId) {
            // Sử dụng Ajax để lấy danh sách các phòng thuộc rạp đã chọn
            $.get('/admin/seat/get-rooms/' + selectedCinemaId, function(data) {

                data.forEach(function(room) {
                    var option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = room.name;
                    roomSelect.appendChild(option);
                });

                roomSelect.disabled = false;
            });
        } else {
            roomSelect.disabled = true;
        }
    });
</script>



@endpush

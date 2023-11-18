@extends('layouts.client')
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner"
        data-background="{{ asset('client/assets/images/banner/banner04.jpg') }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">Venus</h3>
                    <div class="tags">
                        <a href="#0">City Walk</a>
                        <a href="#0">English - 2D</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Page-Title========== -->
    <section class="page-title bg-one">
        <div class="container">
            <div class="page-title-area">
                <div class="item md-order-1">
                    <a href="{{ route('chon-ghe', ['room_id' => $showTime->room_id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}" class="custom-button back-button">
                        Quay lại </a>
                </div>
                <div class="item text-white ">
                    <div class="tags ">
                        <a href="#0" class="text-white">Rạp: {{ $showTime->room->cinema->name }}</a> -
                        <a href="#0" class="text-white">Phòng: {{ $showTime->room->name }}</a> -
                        <a href="#0" class="text-white">Thời gian: {{ date('H:i', strtotime($showTime->start_date)) }}
                            ~ {{ date('H:i', strtotime($showTime->start_end)) }}</a>
                    </div>
                </div>
                <div class="item">
                    <h5 class="title">05:00</h5>
                    <p>Mins Left</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Page-Title========== -->

    <style>
        .quantity-input {
            display: flex;
            align-items: center;
            color: white;
        }

        .quantity-input button {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            color: white;
        }

        .quantity-input input {
            text-align: center;
            width: 50px;
            color: white;

        }
    </style>
    <!-- ==========Movie-Section========== -->
    <div class="movie-facility padding-bottom padding-top">
        <div class="container">
            <div class="row bg-one p-5">

                <div class="col-lg-12 ">
                    <div class="grid--area">
                        <div class="section-header-3">
                            <span class="cate">Bạn đang đói</span>
                            <h2 class="title">Chúng tôi có thức ăn</h2>
                            <p>Đặt trước bữa ăn của bạn và tiết kiệm nhiều hơn!</p>
                        </div>

                        <table class="table text-center text-white">
                            <thead class="">
                                <tr>
                                    <th scope="col" style="display: none">
                                        <input type="checkbox" class="select-control " style="width:15px;" id="select-all">
                                    </th>
                                    <th>Tên</th>
                                    <th>Ảnh</th>
                                    <th>Số lượng</th>
                                    <th>Giá/1</th>
                                    <th>Tổng giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($food as $value)
                                    <tr>
                                        <td scope="row" style="display: none">
                                            <input type="checkbox" class="child-checkbox" style="width:15px" name="ids[]"
                                                value="{{ $value->id }}">
                                        </td>
                                        <td scope="row">{{ $value->name }}</td>
                                        <td><img src="{{ Storage::url($value->image) }}" width="50" alt=""></td>
                                        <td>
                                            <div class="quantity-input">
                                                <button class="decrease" data-productid="{{ $value->id }}">-</button>
                                                <input type="number" name="quantity" min="0" max="20"
                                                    value="0" id="quantity-input-{{ $value->id }}">
                                                <button class="increase" data-productid="{{ $value->id }}">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            {{ number_format($value->price, 0, ',', '.') }} VNĐ

                                        </td>
                                        <td id="price-{{ $value->id }}" data-price="{{ $value->price }}">

                                            @if (is_numeric($value->price))
                                                @if (request()->quantity == 0)
                                                    0 VNĐ
                                                @else
                                                    {{ number_format($value->price, 0, ',', '.') }} VNĐ
                                                @endif
                                            @else
                                                {{ $value->price }} VNĐ
                                            @endif

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-8">
                                <div id="total-price" class="text-danger">Tổng tiền: 0 VNĐ</div>
                                <div>
                                    <i class="text-white">Với những sản phẩm được chọn</i>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="custom-button">Thanh toán</button>
                            </div>
                        </div>
                        @if (session('selectedProducts'))
                            <li>
                                <h6 class="subtitle"><span>Đồ ăn</span> </h6>
                                @foreach (session('selectedProducts') as $product)
                                    <span
                                        class="info"><span>{{ $product['name'] }}</span><span>{{ $product['quantity'] }}</span><span>{{ number_format($product['price'], 0, ',', '.') }}
                                            VNĐ</span></span>
                                @endforeach
                            </li>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->


    {{-- tăng giảm số lượng cập nhật giá --}}
    <script>
        // Hàm cập nhật tổng tiền dựa trên các checkbox đã chọn và giá của từng sản phẩm
        function updateTotalPrice() {
            var total = 0;
            $("input[name='quantity']").each(function() {
                var productId = $(this).attr("id").replace("quantity-input-", "");
                var quantity = parseInt($(this).val());

                // Tự động chọn checkbox nếu số lượng lớn hơn 0
                var checkbox = $("input[name='ids[]'][value='" + productId + "']");
                if (quantity > 0) {
                    checkbox.prop("checked", true);
                } else {
                    checkbox.prop("checked", false);
                }

                if (quantity > 0) {
                    var price = parseFloat($("#price-" + productId).data("price"));
                    var productTotal = quantity * price;
                    total += productTotal;
                    // Cập nhật giá của từng sản phẩm trong bảng
                    $("#price-" + productId).text(productTotal.toLocaleString("vi-VN") + " VNĐ");
                }
            });
            $("#total-price").text("Tổng tiền: " + total.toLocaleString("vi-VN") + " VNĐ");
        }

        // Hàm cập nhật giá sản phẩm khi số lượng thay đổi
        function updateProductPrice(productId) {
            var quantity = parseInt($("#quantity-input-" + productId).val());
            var price = parseFloat($("#price-" + productId).data("price"));
            var productTotal = quantity * price;

            // Cập nhật giá của từng sản phẩm trong bảng
            $("#price-" + productId).text(productTotal.toLocaleString("vi-VN") + " VNĐ");
        }

        // Gắn các trình xử lý sự kiện cho các nút tăng/giảm số lượng
        $(".quantity-input").on("click", ".increase, .decrease", function() {
            var productId = $(this).data("productid");
            var quantityInput = $("#quantity-input-" + productId);
            var quantity = parseInt(quantityInput.val());

            if ($(this).hasClass("increase")) {
                quantity += 1;
            } else {
                quantity -= 1;
            }

            // Đảm bảo rằng số lượng không nhỏ hơn 0
            if (quantity < 0) {
                quantity = 0;
            }

            quantityInput.val(quantity);
            updateProductPrice(productId); // Cập nhật giá sản phẩm
            updateTotalPrice(); // Cập nhật tổng tiền
        });

        // Tính toán ban đầu tổng tiền
        updateTotalPrice();
    </script>

    {{-- lưu thông tin đồ ăn  --}}
    <script type="text/javascript">
        document.querySelector("button.custom-button").addEventListener("click", function() {
            // Thu thập thông tin các sản phẩm được chọn
            const selectedProducts = [];
            let totalPriceFood = 0;
            const checkboxes = document.querySelectorAll("input.child-checkbox:checked");
            checkboxes.forEach(checkbox => {
                const productId = checkbox.value;
                const productName = checkbox.parentElement.nextElementSibling.textContent;
                const quantity = document.querySelector(`#quantity-input-${productId}`).value;
                const priceText = document.querySelector(`#price-${productId}`)
                    .textContent; // Lấy giá từ nội dung văn bản
                const priceParts = priceText.split(' '); // Tách giá và đơn vị tiền tệ
                const priceValue = parseFloat(priceParts[0].replace('.', '').replace(',',
                    '')); // Loại bỏ dấu "." và "," và chuyển thành số

                // Cộng giá tiền của sản phẩm vào tổng giá tiền
                totalPriceFood += priceValue;

                selectedProducts.push({
                    id: productId,
                    name: productName,
                    quantity,
                    price: priceValue,
                });
            });

            // Gửi dữ liệu lên server bằng Ajax hoặc fetch API và lưu vào session
            fetch('/luu-thong-tin-san-pham', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        selectedProducts,
                        totalPriceFood
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const redirectUrl =
                            '{{ route('thanh-toan', ['room_id' => $room->id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}';
                        window.location.href = redirectUrl;
                    } else {
                        // Xử lý lỗi nếu cần
                    }
                });
        });
    </script>

@endsection

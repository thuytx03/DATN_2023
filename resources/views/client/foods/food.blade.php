@extends('layouts.client')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .required {
        color: red;
    }
</style>
@endpush
@section('title')
Đồ ăn
@endsection
@section('content')

<section class="details-banner hero-area bg_img seat-plan-banner" data-background="">
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

<section class="page-title bg-one">
    <div class="container">
        <div class="page-title-area">
            <div class="item md-order-1">
                <a href="movie-ticket-plan.html" class="custom-button back-button">
                    <i class="fa-solid fa-rotate-left"></i></i>Quay lại
                </a>
            </div>
            <div class="item date-item">
                <span class="date">Tháng 10,2023</span>
                <select class="select-bar">
                    <option value="sc1">09:40</option>
                    <option value="sc2">13:45</option>
                    <option value="sc3">15:45</option>
                    <option value="sc4">19:50</option>
                </select>
            </div>
            <div class="item">
                <h5 class="title">05:00</h5>
                <p>Phút còn lại</p>
            </div>
        </div>
    </div>
</section>
<div class="movie-facility padding-bottom padding-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-header-3">
                    <span class="cate">Bạn đang đói</span>
                    <h2 class="title">Chúng tôi có thức ăn</h2>
                    <p>Đặt trước bữa ăn của bạn và tiết kiệm nhiều hơn!</p>
                </div>
                <div class="container">
                    <div class="newslater-container mb-5">
                        <div class="newslater-wrapper">
                            <form class="newslater-form" action="{{route('food')}}">
                                <input type="text" placeholder="Nhập tên đồ ăn" name="search" id="food">
                                <button type="submit">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="grid--area">
                    <ul class="filter">
                        <li id="showAll" onclick="submitForm(this)">Tất cả</li>
                        @foreach($foodType as $foodTypeItem)
                        @if ($foodTypeItem->parent_id == 0)
                        <a href="#0" onclick="submitForm(this, {{$foodTypeItem->id}})">
                            <li class="foodstype" data-value="{{$foodTypeItem->id}}">{{$foodTypeItem->name}}</li>
                        </a>
                        @endif
                        @endforeach
                        <form action="{{ route('food')}}" method="get" id="postTypeSearch">
                            <input type="hidden" name="foodstypes" id="selectedFoodType" value="">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        </form>
                    </ul>
                    <div class="grid-area">
                        @foreach($food as $foodItem)
                        <div class="grid-item combos popcorn {{$foodItem->food_type_id}}">
                            <div class="grid-inner">
                                <div class="grid-thumb">
                                    <img src="{{$foodItem->image?''.Storage::url($foodItem->image):''}}" alt="movie/popcorn">
                                </div>
                                <div class="grid-content">
                                    <h5 class="subtitle">
                                        <a href="#0">
                                            {{$foodItem->name}}
                                        </a>
                                    </h5>
                                    <hr>
                                    <h6 class="subtitle"><span> {{$foodItem->price}} Vnđ</span>
                                        <form class="cart-button" onsubmit="addItem(event)">
                                            <input type="hidden" class="food-name" value="{{$foodItem->name}}">
                                            <input type="hidden" class="food-price" value="{{$foodItem->price}}">
                                            <input type="hidden" class="food-id" value="{{$foodItem->id}}">
                                            <input class="number" type="hidden" name="qtybutton" value="1">
                                            <div class="w-100 d-flex justify-content-center">
                                                <button type="submit" class="custom-button m-2">
                                                    Mua
                                                </button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="booking-summery bg-one">
                    <h4 class="title">Đặt đồ ăn</h4>
                    <ul class="side-shape">
                        <li>
                            <h6 class="subtitle"><span>Thực phẩm và đồ uống</span></h6>
                        </li>
                        <hr>
                        <li id="itemList">
                            <!-- Các món ăn được thêm vào sẽ được hiển thị ở đây -->
                        </li>
                        <br>
                        <li>
                            <h6 class="subtitle"><span>Tạm tính</span><span id="totalPrice">0</span></h6>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <div class="mb-3">
                                <label class="form-label">Mã giảm</label>
                                <input type="text" class="form-group" id="voucher">
                                <button class="custom-button back-button" id="applyButton">Áp dụng</button>
                            </div>
                            <div>
                                <span id="alert" class="text-danger font-bold"></span>
                            </div>
                            <br>
                            <span class="info"><span>Mã giảm</span><span id="discount">0</span></span>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <h6 class="subtitle"><span>Thông tin cá nhân</span> </h6>
                            <hr>
                            <div class="">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li class="text-danger">{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <div class="mb-3">
                                    <label class="form-label">Email<span class="required">*</span></label>
                                    <input type="email" class="form-group" id="email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ngày nhận<span class="required">*</span></label>
                                    <input type="datetime-local" class="form-group" id="order_end">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</label>
                                    <input class="form-group" id="note"></input>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <h6 class="subtitle"><span>Phương thức thanh toán</span></h6>
                            <hr>
                            <span>
                                <div class=" mt-2">
                                    <select class="form-select text-dark " id="paymentMethod">
                                        <option value="1" class="form-group">Thanh toán nội địa VnPay</option>
                                        <option value="2" class="form-group">Thanh toán quốc tế Paypay</option>
                                    </select>
                                </div>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="proceed-area  text-center">
                    <h6 class="subtitle"><span>Tổng tiền</span><span id="total"></span></h6>
                    <form id="myForm" action="{{ route('food.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="total_amount">
                        <input type="hidden" name="total_price">
                        <input type="hidden" name="payment_method">
                        <input type="hidden" name="food_items">
                        <input type="hidden" name="email">
                        <input type="hidden" name="order_end">
                        <input type="hidden" name="note">
                        <input type="hidden" name="voucher">
                        <button class="custom-button back-button" id="payButton">Thanh toán</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function submitForm(element, foodTypeId) {
        var form = document.getElementById('postTypeSearch');
        var hiddenField = document.getElementById('selectedFoodType');
        if (element.id === 'showAll') {
            hiddenField.value = 0;
        } else {
            hiddenField.value = foodTypeId;
        }
        form.submit();
    }
</script>
<script>
    function updateTotalPrice() {
        var totalPrice = parseInt(document.getElementById('totalPrice').textContent);
        var discount = parseInt(document.getElementById('discount').textContent);
        var finalPrice = totalPrice - discount;
        document.getElementById('total').textContent = finalPrice;
    }
    updateTotalPrice();
</script>
<script>
    document.getElementById('totalPrice').addEventListener('DOMSubtreeModified', function() {
        var totalPrice = parseInt(document.getElementById('totalPrice').textContent);
        var discount = parseInt(document.getElementById('discount').textContent);
        var finalPrice = totalPrice - discount;
        document.getElementById('total').textContent = finalPrice;
    });

    document.getElementById('discount').addEventListener('DOMSubtreeModified', function() {
        var totalPrice = parseInt(document.getElementById('totalPrice').textContent);
        var discount = parseInt(document.getElementById('discount').textContent);
        var finalPrice = totalPrice - discount;
        document.getElementById('total').textContent = finalPrice;
    });
</script>
<script>
    function addItem(event) {
        event.preventDefault();
        var foodName = event.target.querySelector('.food-name').value;
        var foodPrice = event.target.querySelector('.food-price').value;
        var quantity = event.target.querySelector('.number').value;
        var itemExists = false;
        var itemList = document.getElementById('itemList').getElementsByTagName('li');
        var foodId = event.target.querySelector('.food-id').value;
        for (var i = 0; i < itemList.length; i++) {
            var item = itemList[i];
            var itemFoodName = item.querySelector('span:nth-child(1)').textContent;

            if (itemFoodName === foodName) {
                var itemQuantity = parseInt(item.querySelector('.quantity').textContent);
                var newQuantity = itemQuantity + parseInt(quantity);
                item.querySelector('.quantity').textContent = newQuantity;
                var itemPrice = parseInt(foodPrice);
                var totalPriceElement = document.getElementById('totalPrice');
                var totalPrice = parseInt(totalPriceElement.textContent);
                totalPrice += itemPrice * parseInt(quantity);
                totalPriceElement.textContent = totalPrice;
                foodId = item.dataset.foodId;
                itemExists = true;
                break;
            }
        }

        if (!itemExists) {
            var newItem = document.createElement('li');
            newItem.dataset.foodId = foodId;
            newItem.innerHTML = `
            <h6 class="subtitle">
                <span>${foodName}</span>
                <span></i></span>
            </h6>
            <div class="info">
                <span id="number">Price: ${foodPrice} Vnđ</span>
                <div class="border border-1 rounded-pill d-flex justify-content-center w-25">
                    <span class="m-1" id="decrease">-</span>
                    <span class="quantity m-1 w-50 d-flex justify-content-center" id="newQuantity" min="1">${quantity}</span>
                    <span class="m-1" id="increase">+</span>
                </div>
            </div>
        `;
            document.getElementById('itemList').appendChild(newItem);
            var itemPrice = parseInt(foodPrice);
            var totalPriceElement = document.getElementById('totalPrice');
            var totalPrice = parseInt(totalPriceElement.textContent);
            totalPrice += itemPrice * parseInt(quantity);
            totalPriceElement.textContent = totalPrice;
        }

        // Thêm sự kiện click cho nút giảm
        newItem.querySelector('#decrease').addEventListener('click', function() {
            var quantityElement = newItem.querySelector('#newQuantity');
            var quantity = parseInt(quantityElement.innerText);

            if (quantity > 1) {
                quantityElement.innerText = quantity - 1;
                updateTotalPrice(-1, foodPrice);
            }
            resetVoucher();
        });


        // Thêm sự kiện click cho nút tăng
        newItem.querySelector('#increase').addEventListener('click', function() {
            var quantityElement = newItem.querySelector('#newQuantity');
            var quantity = parseInt(quantityElement.innerText);

            quantityElement.innerText = quantity + 1;
            updateTotalPrice(1, foodPrice);
            resetVoucher();
        });

        function updateTotalPrice(change, itemPrice) {
            var totalPriceElement = document.getElementById('totalPrice');
            var totalPrice = parseInt(totalPriceElement.textContent);

            totalPrice += (itemPrice * change);
            totalPriceElement.textContent = totalPrice;
        }
        resetVoucher();
    }
</script>
<script>
    document.getElementById('payButton').addEventListener('click', function() {
        var paymentMethod = document.getElementById('paymentMethod').value;
        var email = document.getElementById('email').value;
        var order_end = document.getElementById('order_end').value;
        var note = document.getElementById('note').value;
        var voucher = document.getElementById('voucher').value;
        var total = document.getElementById('total').textContent;
        var totalPrice = document.getElementById('totalPrice').textContent;
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var itemList = document.getElementById('itemList').getElementsByTagName('li');
        var foodItems = [];

        for (var i = 0; i < itemList.length; i++) {
            var item = itemList[i];
            var foodId = item.dataset.foodId;
            var quantity = parseInt(item.querySelector('.quantity').textContent);

            foodItems.push({
                food_id: parseInt(foodId),
                quantity: quantity
            });
        }

        // Cập nhật giá trị trong form
        document.querySelector('input[name="total_amount"]').value = parseInt(total);
        document.querySelector('input[name="total_price"]').value = parseInt(totalPrice);
        document.querySelector('input[name="payment_method"]').value = parseInt(paymentMethod);
        document.querySelector('input[name="email"]').value = email;
        document.querySelector('input[name="order_end"]').value = order_end;
        document.querySelector('input[name="note"]').value = note;
        document.querySelector('input[name="voucher"]').value = voucher;
        document.querySelector('input[name="food_items"]').value = JSON.stringify(foodItems);

        // Gửi form
        document.getElementById('myForm').submit();
    });
</script>
<script>
    function resetVoucher() {
        document.getElementById('voucher').value = ''; // Clear the voucher input field
        document.getElementById('alert').innerText = ''; // Clear the voucher input field
        document.getElementById('discount').innerText = '0'; // Reset discount value to 0
    }
    document.getElementById('applyButton').addEventListener('click', function() {
        var userVoucher = document.getElementById('voucher').value;
        var totalPrice = parseInt(document.getElementById('totalPrice').textContent);

        axios.post('/food/check-voucher', {
                voucher: userVoucher,
                totalPrice: totalPrice

            })
            .then(function(response) {
                var discount = response.data.discount;
                document.getElementById('discount').innerText = discount;
                document.getElementById('alert').innerText = "Mã giảm giá áp dụng thành công !!!";
            })
            .catch(function(error) {
                if (error.response.status === 422) {
                    document.getElementById('alert').innerText = error.response.data.error;
                }
            });
    });
</script>
@endpush
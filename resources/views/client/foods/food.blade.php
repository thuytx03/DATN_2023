@extends('layouts.client')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .grid-item {
        display: block;
        /* Mặc định hiển thị tất cả */
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
                                            <input class="cart-plus-minus-box" type="hidden" name="qtybutton" value="1">
                                            <div class="w-100">
                                                <button type="submit" class="custom-button">
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
                        <li>
                            <h6 class="subtitle"><span>Tạm tính</span><span id="totalPrice">0</span></h6>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <span class="info"><span>Mã giảm</span><span id="discount">15000</span></span>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <h6 class="subtitle"><span>Phương thức thanh toán</span>
                                <span>
                                    <div class=" mt-2 w-100">
                                        <select class="form-select text-dark" id="paymentMethod">
                                            <option value="1">Tiền mặt</option>
                                            <option value="2">Thẻ tín dụng/debit</option>
                                            <option value="3">Chuyển khoản ngân hàng</option>
                                            <option value="4">Ví điện tử</option>
                                            <option value="5">Thanh toán qua QR code</option>
                                        </select>
                                    </div>
                                </span>
                            </h6>
                        </li>
                    </ul>
                </div>
                <div class="proceed-area  text-center">
                    <h6 class="subtitle"><span>Tổng tiền</span><span id="total"></span></h6>
                    <a href="#0" class="custom-button back-button" id="payButton">Thanh toán</a>
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
</script>
<script>
    function addItem(event) {
        event.preventDefault();
        var foodName = event.target.querySelector('.food-name').value;
        var foodPrice = event.target.querySelector('.food-price').value;
        var quantity = event.target.querySelector('.cart-plus-minus-box').value;
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
                    <span>Price: ${foodPrice} Vnđ</span>
                    <span class="quantity">${quantity}</span>
                </div>
            `;
            document.getElementById('itemList').appendChild(newItem);
            var itemPrice = parseInt(foodPrice);
            var totalPriceElement = document.getElementById('totalPrice');
            var totalPrice = parseInt(totalPriceElement.textContent);
            totalPrice += itemPrice * parseInt(quantity);
            totalPriceElement.textContent = totalPrice;
        }
    }


    // function deleteItem(button) {
    //     var listItem = button.parentElement.parentElement;
    //     var itemPrice = parseInt(listItem.querySelector('.info span:nth-child(2)').textContent.split(' ')[1]);
    //     var quantity = parseInt(listItem.querySelector('.quantity').textContent);
    //     var itemList = document.getElementById('itemList').getElementsByTagName('li');
    //     if (itemList.length > 0) {
    //         var totalPriceElement = document.getElementById('totalPrice');
    //         var totalPrice = parseInt(totalPriceElement.textContent) || 0; // Use 0 if parseInt returns NaN
    //         totalPrice -= itemPrice * quantity;
    //         totalPriceElement.textContent = totalPrice;
    //         listItem.remove();
    //     } else {
    //         alert("At least one item is required in the list.");
    //     }
    //     // Check if there are remaining items
    //     var remainingItems = document.getElementById('itemList').getElementsByTagName('li');
    //     if (remainingItems.length > 0) {
    //         // Calculate new total price
    //         var newTotalPrice = 0;
    //         for (var i = 0; i < remainingItems.length; i++) {
    //             var item = remainingItems[i];
    //             var itemPrice = parseInt(item.querySelector('.info span:nth-child(2)').textContent.split(' ')[1]);
    //             var itemQuantity = parseInt(item.querySelector('.quantity').textContent);
    //             newTotalPrice += itemPrice * itemQuantity;
    //         }
    //         var newTotalPriceElement = document.getElementById('totalPrice');
    //         newTotalPriceElement.textContent = newTotalPrice;
    //     } else {
    //         // If no remaining items, set total price to 0
    //         var newTotalPriceElement = document.getElementById('totalPrice');
    //         newTotalPriceElement.textContent = '0';
    //     }
    // }
</script>
<!-- <script>
    document.getElementById('payButton').addEventListener('click', function() {
        var paymentMethod = document.getElementById('paymentMethod').value;
        var totalPrice = document.getElementById('total').textContent;

        var data = {
            order_date: new Date().toISOString(),
            total_amount: parseInt(totalPrice),
            payment_method: parseInt(paymentMethod),
            food_items: []
        };
        var itemList = document.getElementById('itemList').getElementsByTagName('li');
        for (var i = 0; i < itemList.length; i++) {
            var item = itemList[i];
            var foodId = item.dataset.foodId;
            var quantity = parseInt(item.querySelector('.quantity').textContent);
            data.food_items.push({
                food_id: parseInt(foodId),
                quantity: quantity
            });

        }
        // Bước 3: Gửi dữ liệu lên server bằng Ajax
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/order/store');
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Đặt đồ ăn thành công!');
            } else {
                alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            }
        };
        xhr.send(JSON.stringify(data));
        console.log(data)
    });
</script> -->

<script>
    document.getElementById('payButton').addEventListener('click', function() {
        var paymentMethod = document.getElementById('paymentMethod').value;
        var totalPrice = document.getElementById('total').textContent;
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var data = {
            _token: csrfToken,
            order_date: new Date().toISOString(),
            total_amount: parseInt(totalPrice),
            payment_method: parseInt(paymentMethod),
            food_items: []
        };
        var itemList = document.getElementById('itemList').getElementsByTagName('li');
        for (var i = 0; i < itemList.length; i++) {
            var item = itemList[i];
            var foodId = item.dataset.foodId;
            var quantity = parseInt(item.querySelector('.quantity').textContent);

            data.food_items.push({
                food_id: parseInt(foodId),
                quantity: quantity
            });
        }
        console.log(data)
        // Thực hiện yêu cầu POST bằng Axios
        axios.post('/admin/order/store', data)
            .then(function(response) {
                alert('Đặt đồ ăn thành công!');
            })
            .catch(function(error) {
                alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            });
    });
</script>

@endpush
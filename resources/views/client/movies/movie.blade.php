<div class="container" id="movie-list">
    <style>
        .button5 {
            background-color: #032055;
            border: none;
        }
    </style>
    <div class="tab">
        <div class="section-header-2">
            <div class="left">
                <h2 class="title">Phim</h2>
                <p>Hãy chắc chắn không bỏ lỡ những bộ phim này hôm nay.</p>
            </div>
            <ul class="tab-menu">
                <li class="sort-option" data-sort="now-showing">Đang chiếu</li>
                <li class="sort-option" data-sort="coming-soon">Sắp tới</li>
                <li class="sort-option" data-sort="filter">Chọn lọc</li>
            </ul>
        </div>
        <div class="tab-area mb-30-none">
            <div class="tab-item active">
                @if($movies->isNotEmpty())
                    <div class="owl-carousel owl-theme tab-slider">
                        @foreach($movies as $movie)
                            <div class="item">
                                <div class="movie-grid">
                                    <!-- Hiển thị thông tin của bộ phim -->
                                    <div class="movie-thumb c-thumb">
                                        <a href="#0">
                                            <img alt="movies" class="img-fluid" width="60" src="{{ $movie->poster ? Storage::url($movie->poster) : asset('images/image-not-found.jpg') }}" alt="Image">
                                        </a>
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h5 class="title m-0">
                                            <a href="{{ route('movie.detail', ['slug' => Str::slug($movie->name), 'id' => $movie->id]) }}">
                                                {{ $movie->name }}
                                            </a>
                                        </h5>
                                        <ul class="movie-rating-percent">
                                            <li>
                                                <div class="thumb1">
                                                    @if (auth()->check())
                                                        <form action="{{ route('home.favorite.add', ['id' => $movie->id]) }}">
                                                            <button type="submit" id="favorite-link" style="color: white" class="button5" data-movie-id="{{ $movie->id }}">
                                                                <i id="heart-icon" class="fas fa-heart {{ $user->favoriteMovies->contains($movie) ? 'text-danger' : '' }}"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('home.favorite.add', ['id' => $movie->id]) }}" style="color: white">
                                                            <i id="heart-icon" class="fas fa-heart"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </li>
                                            <li>
                                                <div class="thumb">
                                                    <img src=" {{ asset('client/assets/images/movie/tomato.png') }}" alt="movie">
                                                </div>
                                                <span class="content">88%</span>
                                            </li>
                                            <li>
                                                <div class="thumb">
                                                    <a href="{{ route('lich-chieu',['id'=>$movie->id, 'slug'=>$movie->slug]) }}" class="custom-button buy-ticket-button" style="padding: 8px; height: 45px">Mua vé</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="tab-item active">
                        <p>Không tìm thấy bộ phim nào.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        $('.ticket-search-form').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            formData += '&_token={{ csrf_token() }}'; // Thêm token CSRF vào dữ liệu gửi đi
            $.ajax({
                type: 'POST',
                url: "{{ route('movie.searchByName') }}",
                data: formData,
                success: function(response) {
                    // ... (Trong hàm success của bạn)
                    $('#movie-list').html(response);

                    // Reinitialize the Owl Carousel
                    $('.owl-carousel').owlCarousel({
                        // Các tùy chọn Owl Carousel của bạn ở đây
                        loop: true,
                        margin: 10,
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            600: {
                                items: 3,
                            },
                            1000: {
                                items: 5,
                            },
                        },
                    });

                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Sự kiện khi chọn sắp xếp từ tab-menu
        $('.sort-option').click(function() {
            var sortBy = $(this).data('sort');

            // Gửi yêu cầu Ajax đến máy chủ
            $.ajax({
                type: 'POST',
                url: "{{ route('movie.showing') }}",
                data: {
                    sortBy: sortBy,
                    _token: '{{ csrf_token() }}', // Include the CSRF token
                },
                success: function(data) {
                    // Update the movie list with the new data
                    $('#movie-list').html(data);

                    $('.owl-carousel').owlCarousel({
                        // Các tùy chọn Owl Carousel của bạn ở đây
                        loop: true,
                        margin: 10,
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            600: {
                                items: 3,
                            },
                            1000: {
                                items: 5,
                            },
                        },
                    });
                    // console.log('Movies:', data);
                },
                error: function(error) {
                    console.error('Error sending sort request: ', error);
                }
            });
        });
    });
</script>

<script>
    // Select all elements with the "favorite-button" class
    const favoriteButtons = document.querySelectorAll(".favorite-button");

    favoriteButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            const movieId = button.getAttribute("data-movie-id");
            const heartIcon = button.querySelector("i");

            // Toggle favorite status
            const isFavorite = !heartIcon.classList.contains("text-danger");

            if (isFavorite) {
                heartIcon.classList.add("text-danger");
            } else {
                heartIcon.classList.remove("text-danger");
            }

            // Send the favorite status to the server
            sendFavoriteStatus(movieId, isFavorite);
        });
    });
</script>

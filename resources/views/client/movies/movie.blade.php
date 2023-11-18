<section class="movie-section padding-top padding-bottom">
    <div class="container">
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
                    <li class="active">
                        Đang chiếu
                    </li>
                    <li>
                        Sắp tới
                    </li>
                    <li>
                        Chọn lọc
                    </li>
                </ul>
            </div>
            <div class="tab-area mb-30-none">
                <div class="tab-item active">
                    <div class="owl-carousel owl-theme tab-slider">

                        @foreach ($movies as $movie)
                            <div class="item">
                                <div class="movie-grid">
                                    <div class="movie-thumb c-thumb">
                                        <a href="#0">
                                            <img alt="movies" class="img-fluid" width="60"
                                                src="{{ $movie->poster ? Storage::url($movie->poster) : asset('images/image-not-found.jpg') }}"
                                                alt="Image">
                                        </a>
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h5 class="title m-0">
                                            <a
                                                href="{{ route('movie.detail', ['slug' => Str::slug($movie->name), 'id' => $movie->id]) }}">
                                                {{ $movie->name }}
                                            </a>
                                        </h5>
                                        <ul class="movie-rating-percent">

                                            <li>
                                                <div class="thumb1">
                                                    @if (auth()->check())
                                                        <form
                                                            action="{{ route('home.favorite.add', ['id' => $movie->id]) }}">
                                                            <button type="submit" id="favorite-link"
                                                                style="color: white" class="button5"
                                                                data-movie-id="{{ $movie->id }}">
                                                                <i id="heart-icon"
                                                                    class="fas fa-heart {{ $user->favoriteMovies->contains($movie) ? 'text-danger' : '' }}"></i>

                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('home.favorite.add', ['id' => $movie->id]) }}"
                                                            style="color: white">
                                                            <i id="heart-icon" class="fas fa-heart"></i>
                                                        </a>
                                                    @endif

                                            </li>
                                            <li>
                                                <div class="thumb">
                                                    <img src=" {{ asset('client/assets/images/movie/tomato.png') }}"
                                                        alt="movie">
                                                </div>
                                                <span class="content">88%</span>
                                            </li>

                                            <li>
                                                <div class="thumb">
                                                    <a href="{{ route('lich-chieu',['id'=>$movie->id, 'slug'=>$movie->slug]) }}" class="custom-button buy-ticket-button"

                                                        style="padding: 8px; height: 45px">Mua vé</a>

                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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

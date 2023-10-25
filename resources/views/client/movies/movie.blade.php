<section class="movie-section padding-top padding-bottom">
    <div class="container">
        <div class="tab">
            <div class="section-header-2">
                <div class="left">
                    <h2 class="title">movies</h2>
                    <p>Be sure not to miss these Movies today.</p>
                </div>
                <ul class="tab-menu">
                    <li class="active">
                        now showing
                    </li>
                    <li>
                        coming soon
                    </li>
                    <li>
                        exclusive
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
                                    <img alt="movies" width="60" src="{{ $movie->poster ? Storage::url($movie->poster) : asset('images/image-not-found.jpg') }}" alt="Image">
                                    </a>
                                </div>
                                <div class="movie-content bg-one">
                                    <h5 class="title m-0">
                                        <a href="{{route('movie.detail', ['id' => $movie->id])}}">{{$movie->name}}</a>
                                    </h5>
                                    <ul class="movie-rating-percent">
                                        <li>
                                            <div class="thumb">
                                                <img src=" {{asset('client/assets/images/movie/tomato.png')}}" alt="movie">
                                            </div>
                                            <span class="content">88%</span>
                                        </li>
                                        <li>
                                            <div class="thumb">
                                                <img src=" {{asset('client/assets/images/movie/cake.png')}}" alt="movie">
                                            </div>
                                            <span class="content">88%</span>
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

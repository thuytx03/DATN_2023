<section class="sports-section padding-top padding-bottom">
        <div class="container">
            <div class="tab">
                <div class="section-header-2">
                    <div class="left">
                        <h2 class="title">Bài Viết</h2>
                 
                    </div>
              
                </div>
                <div class="tab-area mb-30-none">
                    <div class="tab-item active">
                        <div class="owl-carousel owl-theme tab-slider">
                            @foreach($post as $data)
                            <div class="item">
                                <div class="sports-grid">
                                    <div class="movie-thumb c-thumb">
                                        <a href="{{route('blog-detail',[ $data->slug, 'id' => $data->id])}}">
                                            <img src=" {{asset($data->image)}} " alt="sports">
                                        </a>
                                    
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h5 class="title m-0">
                                            <a href="#0">   {{$data->title}}</a>
                                        </h5>
                                        <div class="movie-rating-percent">
                                        <p>
                                    {!! \Illuminate\Support\Str::limit(strip_tags($data->content), 50) !!}
                                    </p>
                                        </div>
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
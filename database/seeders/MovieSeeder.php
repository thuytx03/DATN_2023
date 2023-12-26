<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('movies')->insert([
            [
                'name' => 'The Marvels',
                'slug' => 'the-marvels',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/the-marvels.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 1',
                'actor' => 'Diễn viên 1',
                'manufacturer' => 'Nhà sản xuất 1',
                'duration' => '120 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 1',
                'country_id' => 1, // ID của quốc gia
                'status' => 1, // Trạng thái phim (ví dụ: 1 cho phim đang chiếu)
            ],
            [
                'name' => 'Slotherhouse',
                'slug' => 'slotherhouse',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/slotherhouse.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 11',
                'actor' => 'Diễn viên 11',
                'manufacturer' => 'Nhà sản xuất 11',
                'duration' => '120 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 11',
                'country_id' => 1, // ID của quốc gia
                'status' => 1, // Trạng thái phim (ví dụ: 1 cho phim đang chiếu)
            ],
            [
                'name' => 'The Dark Knight Rises',
                'slug' => 'the-dark-knight-rises',
                'language' => 'English',
                'poster' => 'movies/image-movie/the-dark-knight-rises.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 2',
                'actor' => 'Diễn viên 2',
                'manufacturer' => 'Nhà sản xuất 2',
                'duration' => '220 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 2',
                'country_id' => 2, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Người Vợ Cuối Cùng',
                'slug' => 'nguoi-vo-cuoi-cung',
                'language' => 'VietNamese',
                'poster' => 'movies/image-movie/nguoi-vo-cuoi-cung.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 3',
                'actor' => 'Diễn viên 3',
                'manufacturer' => 'Nhà sản xuất 3',
                'duration' => '90 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 3',
                'country_id' => 3, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Love Reset',
                'slug' => 'love-reset',
                'language' => 'Korea',
                'poster' => 'movies/image-movie/love-reset.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 4',
                'actor' => 'Diễn viên 4',
                'manufacturer' => 'Nhà sản xuất 4',
                'duration' => '120 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 4',
                'country_id' => 3, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Đất rừng phương Nam',
                'slug' => 'dat-rung-phuong-nam',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/dat-rung-phuong-nam.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 5',
                'actor' => 'Diễn viên 5',
                'manufacturer' => 'Nhà sản xuất 5',
                'duration' => '90 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 5',
                'country_id' => 3, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Dear David',
                'slug' => 'dear-david',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/dear-david.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 6',
                'actor' => 'Diễn viên 6',
                'manufacturer' => 'Nhà sản xuất 6',
                'duration' => '90 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 6',
                'country_id' => 1, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Five Nights at Freddy',
                'slug' => 'five-nights-at-freddy',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/five-nights-at-freddy.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 7',
                'actor' => 'Diễn viên 7',
                'manufacturer' => 'Nhà sản xuất 7',
                'duration' => '120 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 7',
                'country_id' => 2, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Anatomy of a Fall',
                'slug' => 'anatomy-of-a-fall',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/anatomy-of-a-fall.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 8',
                'actor' => 'Diễn viên 8',
                'manufacturer' => 'Nhà sản xuất 8',
                'duration' => '100 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 8',
                'country_id' => 3, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Back Home',
                'slug' => 'back-home',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/back-home.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 9',
                'actor' => 'Diễn viên 9',
                'manufacturer' => 'Nhà sản xuất 9',
                'duration' => '120 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 9',
                'country_id' => 1, // ID của quốc gia khác
                'status' => 1,
            ],
            [
                'name' => 'Wolfoo And The Mysterious Island',
                'slug' => 'wolfoo-and-the-mysterious-island',
                'language' => 'Vietnamese',
                'poster' => 'movies/image-movie/wolfoo-and-the-mysterious-island.jpg',
                'trailer' => 'https://www.youtube.com/watch?v=n6Pnzi6r9NU&list=RDbNp9pn0ni3I&index=7',
                'director' => 'Đạo diễn 10',
                'actor' => 'Diễn viên 10',
                'manufacturer' => 'Nhà sản xuất 10',
                'duration' => '130 phút',
                'start_date' => now(),
                'view' => 0,
                'description' => 'Mô tả phim 10',
                'country_id' => 2, // ID của quốc gia khác
                'status' => 1,
            ],
        ]);
        DB::table('movie_genres')->insert([
            ['movie_id' => 1,'genre_id' => 1],
            ['movie_id' => 1,'genre_id' => 2],
            ['movie_id' => 1,'genre_id' => 3],
            ['movie_id' => 2,'genre_id' => 5],
            ['movie_id' => 2,'genre_id' => 2],
            ['movie_id' => 3,'genre_id' => 1],
            ['movie_id' => 3,'genre_id' => 2],
            ['movie_id' => 3,'genre_id' => 4],
            ['movie_id' => 4,'genre_id' => 1],
            ['movie_id' => 4,'genre_id' => 2],
            ['movie_id' => 4,'genre_id' => 3],
            ['movie_id' => 5,'genre_id' => 1],
            ['movie_id' => 5,'genre_id' => 2],
            ['movie_id' => 6,'genre_id' => 1],
            ['movie_id' => 7,'genre_id' => 5],
            ['movie_id' => 7,'genre_id' => 6],
            ['movie_id' => 8,'genre_id' => 1],
            ['movie_id' => 8,'genre_id' => 2],
            ['movie_id' => 8,'genre_id' => 5],
            ['movie_id' => 8,'genre_id' => 5],
            ['movie_id' => 9,'genre_id' => 5],
            ['movie_id' => 9,'genre_id' => 1],
            ['movie_id' => 10,'genre_id' => 5],
            ['movie_id' => 10,'genre_id' => 2],
            ['movie_id' => 10,'genre_id' => 3],
        ]);

    }
}

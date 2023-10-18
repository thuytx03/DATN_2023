<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::with('genres')->paginate(5);
        $moviesWithGenres = Movie::with('genres')->get();
        return view('admin.movie.index',compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('admin.movie.add', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {
        try {
            $imageNames = [];
            if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
                $request->poster = uploadFile('movies', $request->file('poster'));
            } else {
                $request->poster = null;
            }
            if (!$request->slug) {
                $request->slug = Str::slug($request->name);
            }
            $movie = new Movie();
            $movie->name = $request->name;
            $movie->poster = $request->poster;
            $movie->trailer = $request->trailer;
            $movie->slug = $request->slug;
            $movie->language = $request->language;
            $movie->director = $request->director;
            $movie->actor = $request->actor;
            $movie->manufacturer = $request->manufacturer;
            $movie->duration = $request->duration;
            $movie->start_date = $request->start_date;
            $movie->description = $request->description;
            $movie->status = $request->status;
            $movie->country_id = $request->country_id;
            if($request->movie_image) {
                foreach ($request->file('movie_image') as $file) {
                    $imageNames[] = uploadFile('movies', $file);
                }
            }
            $movie->save();
            $movie->genres()->attach($request->genre_id);
            $movieId = $movie->id;
            foreach ($imageNames as $imageName) {
                MovieImage::create([
                    'movie_id' => $movieId,
                    'movie_image' => $imageName
                ]);
            }
            if ($movie->save()) {
                toastr()->success('Thêm mới phim thành công', 'success');
                return redirect()->route('movie.index');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.movie.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

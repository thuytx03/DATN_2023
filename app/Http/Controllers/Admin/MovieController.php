<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin', ['only' => $methods]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MovieRequest $request)
    {
//        $moviesWithGenres = Movie::with('genres')->get();
        $query = Movie::query();
        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 1 || $status == 0) {
                $query->where('status', $status);
            } else if ($status == 'all') {
                $query->get();
            }
        }
        $movies = $query->orderBy('id', 'DESC')->paginate(5);

        return view('admin.movie.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        $contries = Country::all();
        return view('admin.movie.add', compact('genres', 'contries'));
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
            if ($request->movie_image) {
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
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        $genres = Genre::all();
        $movie = Movie::find($id);
        $contries = Country::all();
        $images = MovieImage::where('movie_id', $id)->get();
        return view('admin.movie.edit', compact('genres', 'movie', 'images', 'contries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(MovieRequest $request, $id)
    {
        try {
            $imageNames = [];
            $movie = Movie::find($id);
            if (!$request->slug) {
                $params['slug'] = Str::slug($request->name);
            }
            $params = $request->except('_token', 'poster');
            if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
                $deleted = Storage::delete('/public/' . $movie->poster);
                $request->poster = uploadFile('movies', $request->file('poster'));
                $params['poster'] = $request->poster;
            } else {
                $request->poster = $movie->poster;
            }
            $movieImages = MovieImage::where('movie_id', $id)->get();
            if ($request->hasFile('movie_image')) {
                MovieImage::where('movie_id', $id)->delete();
                foreach ($movieImages as $image) {
                    Storage::delete('/public/' . $image->movie_image);
                }
                foreach ($request->file('movie_image') as $file) {
                    $imageNames[] = uploadFile('movies', $file);
                }
                foreach ($imageNames as $imageName) {
                    MovieImage::create([
                        'movie_id' => $id,
                        'movie_image' => $imageName
                    ]);
                }
            }
            $movie->update($params);
            $movie->genres()->sync($request->input('genre_id'));
            toastr()->success('Cập nhật phim thành công!', 'success');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng nhập tên khác']);
            }
            toastr()->error('Có lỗi xảy ra !', 'error');
        }

        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        if ($id) {
            $deleted = Movie::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa phim thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('movie.index');
        }
    }

    public
    function trash(MovieRequest $request)
    {
        $deleteItems = Movie::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $deleteItems->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status trong trash
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 0 || $status == 1) {
                $deleteItems->where('status', $status);
            } else if ($status == 'all') {
                $deleteItems->get();
            }
        }

        $deleteItems = $deleteItems->orderBy('id', 'DESC')->paginate(5);
        return view('admin.movie.trash', compact('deleteItems'));
    }

    public
    function updateStatus($id, Request $request)
    {
        $item = Movie::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();
        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public
    function restore($id)
    {
        if ($id) {
            $restore = Movie::withTrashed()->find($id);
            $restore->restore();
            toastr()->success('Khôi phục phim thành công', 'success');
            return redirect()->route('movie.trash');
        }
    }

    public
    function delete($id)
    {
        if ($id) {
            $deleted = Movie::onlyTrashed()->find($id);
            $deleted->forceDelete();
            toastr()->success('Xóa vĩnh viễn phim thành công', 'success');
            return redirect()->route('movie.trash');
        }
    }

    public
    function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Movie::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các phim đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các phim đã chọn');
        }

    }

    public
    function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = Movie::withTrashed()->whereIn('id', $ids);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công khôi phục phim');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phim đã chọn');
        }
        return redirect()->route('movie.trash');
    }

    public
    function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = Movie::withTrashed()->whereIn('id', $ids);
            $voucher->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn phim');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phim đã chọn');
        }
        return redirect()->route('movie.trash');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowTimeRequest;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Province;
use App\Models\RoleHasCinema;
use App\Models\Room;
use App\Models\ShowTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ShowTimeController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Staff-Showtime-Hanoi|Staff-Showtime-HaiPhong|Staff-Showtime-ThaiBinh', ['only' => $methods]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ShowTimeRequest $request)
    {
        $user = Auth::user();
        $query = ShowTime::query();
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            $query->get();
        } else {
            // Tìm vai trò và lấy danh sách cinema_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $query->whereIn('room_id', $roomIds);
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
        // Tìm kiếm theo tên phim
        if ($request->has('search_movie')) {
            $searchMovie = $request->input('search_movie');
            $query->whereHas('movie', function ($movieQuery) use ($searchMovie) {
                $movieQuery->where('name', 'like', '%' . $searchMovie . '%');
            });
        }
        // Tìm kiếm theo tên phòng
        if ($request->has('search_room')) {
            $searchRoom = $request->input('search_room');
            $query->whereHas('room', function ($roomQuery) use ($searchRoom) {
                $roomQuery->where('name', 'like', '%' . $searchRoom . '%');
            });
        }
        // Lấy danh sách tất cả ShowTime
        $showTimes = $query->orderBy('id', 'DESC')->get();
        // Kiểm tra và cập nhật status
        $now = now(); // Lấy ngày hiện tại
        foreach ($showTimes as $showTime) {
            if ($showTime->start_date < $now) {
                $showTime->update(['status' => 0]);
            }
        }
        $showTimes = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.show-time.index', compact('showTimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::all();
        $movies = Movie::all();
        $provinces = Province::all();
        return view('admin.show-time.add', compact('rooms', 'movies', 'provinces'));
    }
    public function getCinemas($provinceId)
    {
        $cinemas = Cinema::where('province_id', $provinceId)->get();
        return response()->json($cinemas);
    }
    public function getRooms($cinemaId)
    {
        $room = Room::where('cinema_id', $cinemaId)->get();
        return response()->json($room);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShowTimeRequest $request)
    {
        $room_id = $request->room_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $current_date = Carbon::now(); // Ngày hiện tại
        // Lấy thông tin phim từ bảng movies
        $movie = Movie::find($request->movie_id);
        $movie_start_date = Carbon::parse($movie->start_date);
        // Kiểm tra trạng thái của phòng
        $room = Room::find($room_id);
        if (!$movie) {
            return redirect()->back()->withErrors(['show-time' => 'Phim không tồn tại.']);
        }

        if ($movie->status == 0) {
            return redirect()->back()->withErrors(['show-time' => 'Phim không ở trạng thái hoạt động, không thể thêm lịch chiếu.']);
        }
        if ($room->status == 2) {
            return redirect()->back()->withErrors(['show-time' => 'Phòng không hoạt động, không thể thêm lịch chiếu.']);
        }
        // Kiểm tra xem thời gian bắt đầu của lịch chiếu phải lớn hơn thời gian khởi chiếu của phim
        if ($start_date->lessThanOrEqualTo($movie_start_date)) {
            return redirect()->back()->withErrors(['show-time' => 'Thời gian bắt đầu lịch chiếu phải lớn hơn thời gian khởi chiếu của phim. Vui lòng kiểm tra ngày khởi chiếu của (' . $movie->name . ') !']);
        }

        // Kiểm tra xem thời gian kết thúc của lịch chiếu phải lớn hơn thời gian bắt đầu
        if ($end_date->lessThanOrEqualTo($start_date)) {
            return redirect()->back()->withErrors(['show-time' => 'Thời gian kết thúc lịch chiếu phải lớn hơn thời gian bắt đầu.']);
        }

        // Kiểm tra xem ngày bắt đầu và kết thúc phải lớn hơn ngày hiện tại
        if ($start_date->lessThanOrEqualTo($current_date) || $end_date->lessThanOrEqualTo($current_date)) {
            return redirect()->back()->withErrors(['show-time' => 'Ngày bắt đầu và kết thúc phải lớn hơn ngày hiện tại.']);
        }

        // Lấy tất cả lịch chiếu trong cùng một phòng
        $existingShowtimesInRoom = Showtime::where('room_id', $room_id)
            ->orderBy('start_date')
            ->get();

        $previousEnd = null; // Thời gian kết thúc của lịch chiếu trước đó

        foreach ($existingShowtimesInRoom as $existingShowtime) {
            $existingStart = Carbon::parse($existingShowtime->start_date);
            $existingEnd = Carbon::parse($existingShowtime->end_date);

            // Kiểm tra trùng lặp
            if ($end_date->between($existingStart, $existingEnd) || $start_date->between($existingStart, $existingEnd)) {
                return redirect()->back()->withErrors(['show-time' => 'Lịch chiếu trùng lặp với phim trước trong phòng này.']);
            }

            $previousEnd = $existingEnd;
        }

        // Kiểm tra thời gian nghỉ ít nhất 30 phút
        if ($previousEnd) {
            $time_gap = $start_date->diffInMinutes($previousEnd);
            if ($time_gap < 30) {
                return redirect()->back()->withErrors(['show-time' => 'Không đủ thời gian nghỉ giữa các lịch chiếu (ít nhất 30 phút).']);
            }
        }
        $showtime = new Showtime;
        $showtime->room_id = $room_id;
        $showtime->movie_id = $request->movie_id;
        $showtime->start_date = $request->start_date;
        $showtime->end_date = $request->end_date;
        $showtime->status = $request->status;
        $showtime->save();
        toastr()->success('Thêm lịch chiếu thành công!', 'success');
        return redirect()->back();
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
        $rooms = Room::all();
        $movies = Movie::all();
        $showTime = ShowTime::find($id);
        $provinces = Province::all();
        return view('admin.show-time.edit', compact('rooms', 'movies', 'showTime', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShowTimeRequest $request, $id)
    {
        $showtime = Showtime::findOrFail($id);
        $room_id = $request->room_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $current_date = Carbon::now(); // Ngày hiện tại
        // Lấy thông tin phim từ bảng movies
        $movie = Movie::find($request->movie_id);
        $movie_start_date = Carbon::parse($movie->start_date);
        // Kiểm tra trạng thái của phòng
        $room = Room::find($room_id);
        if ($room->status == 2) {
            return redirect()->back()->withErrors(['show-time' => 'Phòng không hoạt động, không thể thêm lịch chiếu.']);
        }
        // Kiểm tra xem thời gian bắt đầu của lịch chiếu phải lớn hơn thời gian khởi chiếu của phim
        if ($start_date->lessThanOrEqualTo($movie_start_date)) {
            return redirect()->back()->withErrors(['show-time' => 'Thời gian bắt đầu lịch chiếu phải lớn hơn thời gian khởi chiếu của phim. Vui lòng kiểm tra ngày khởi chiếu của (' . $movie->name . ') !']);
        }
        // Kiểm tra thời gian kết thúc phải lớn hơn thời gian bắt đầu
        if ($end_date->lessThanOrEqualTo($start_date)) {
            return redirect()->back()->withErrors(['show-time' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.']);
        }
        // Kiểm tra xem thời gian kết thúc của lịch chiếu phải lớn hơn thời gian khởi chiếu của phim
        if ($end_date->lessThanOrEqualTo($movie_start_date)) {
            return redirect()->back()->withErrors(['show-time' => 'Thời gian kết thúc lịch chiếu phải lớn hơn thời gian khởi chiếu của phim. Vui lòng kiểm tra ngày khởi chiếu của (' . $movie->name . ') !']);
        }
        // Kiểm tra xem ngày bắt đầu và kết thúc phải lớn hơn ngày hiện tại
        if ($start_date->lessThanOrEqualTo($current_date) || $end_date->lessThanOrEqualTo($current_date)) {
            return redirect()->back()->withErrors(['show-time' => 'Ngày bắt đầu và kết thúc phải lớn hơn ngày hiện tại.']);
        }
        // Lấy tất cả lịch chiếu trong cùng một phòng (loại bỏ lịch chiếu hiện tại)
        $existingShowtimesInRoom = Showtime::where('room_id', $room_id)
            ->where('id', '!=', $id) // Loại bỏ lịch chiếu hiện tại
            ->orderBy('start_date')
            ->get();

        $previousEnd = null; // Thời gian kết thúc của lịch chiếu trước đó

        foreach ($existingShowtimesInRoom as $existingShowtime) {
            $existingStart = Carbon::parse($existingShowtime->start_date);
            $existingEnd = Carbon::parse($existingShowtime->end_date);

            // Kiểm tra trùng lặp
            if ($end_date->between($existingStart, $existingEnd) || $start_date->between($existingStart, $existingEnd)) {
                return redirect()->back()->withErrors(['show-time' => 'Lịch chiếu trùng lặp với phim trước trong phòng này.']);
            }

            $previousEnd = $existingEnd;
        }

        // Kiểm tra thời gian nghỉ ít nhất 30 phút
        if ($previousEnd) {
            $time_gap = $start_date->diffInMinutes($previousEnd);
            if ($time_gap < 30) {
                return redirect()->back()->withErrors(['show-time' => 'Không đủ thời gian nghỉ giữa các lịch chiếu (ít nhất 30 phút).']);
            }
        }

        // Cập nhật thông tin lịch chiếu
        $showtime->room_id = $room_id;
        $showtime->movie_id = $request->movie_id;
        $showtime->start_date = $request->start_date;
        $showtime->end_date = $request->end_date;
        $showtime->status = $request->status;
        $showtime->save();

        toastr()->success('Cập nhật lịch chiếu thành công!', 'success');
        return redirect()->route('show-time.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            $deleted = ShowTime::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa lịch chiếu thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('show-time.index');
        }
    }

    public function trash(Request $request)
    {
        $deleteItems = ShowTime::onlyTrashed();

        // Tìm kiếm theo name trong trash
        //        if ($request->has('search')) {
        //            $search = $request->input('search');
        //            $deleteItems->where('name', 'like', '%' . $search . '%');
        //        }
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
        return view('admin.show-time.trash', compact('deleteItems'));
    }

    public function restore($id)
    {
        if ($id) {
            $restore = ShowTime::withTrashed()->find($id);
            $restore->restore();
            toastr()->success('Khôi phục lịch chiếu thành công', 'success');
            return redirect()->route('show-time.trash');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $deleted = ShowTime::onlyTrashed()->find($id);
            $deleted->forceDelete();
            toastr()->success('Xóa vĩnh viễn lịch chiếu thành công', 'success');
            return redirect()->route('show-time.trash');
        }
    }

    public function updateStatus(ShowTimeRequest $request, $id)
    {
        $item = ShowTime::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();
        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public function deleteAll(ShowTimeRequest $request)
    {
        $ids = $request->ids;
        if ($ids) {
            ShowTime::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các lịch chiếu đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các lịch chiếu đã chọn');
        }
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $showTime = ShowTime::withTrashed()->whereIn('id', $ids);
            $showTime->restore();
            toastr()->success('Thành công', 'Thành công khôi phục lịch chiếu đã chọn');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các lịch chiếu đã chọn');
        }
        return redirect()->route('show-time.trash');
    }

    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $showTime = ShowTime::withTrashed()->whereIn('id', $ids);
            $showTime->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn lịch chiếu');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các lịch chiếu đã chọn');
        }
        return redirect()->route('show-time.trash');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Cinema;
use App\Models\RoleHasCinema;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class RoomController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh|Staff-Room-Hanoi|Staff-Room-HaiPhong|Staff-Room-ThaiBinh|Staff-Room-NamDinh|Staff-Room-NinhBinh', ['only' => $methods]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        $query = Room::query();

        // Lọc theo tên nếu có
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lọc theo status nếu có
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }

        // Lọc theo vai trò của người dùng hiện tại
        $roles = $user->getRoleNames()->toArray(); // Lấy danh sách vai trò của người dùng

        // Lấy danh sách rạp chiếu phim dựa trên vai trò của người dùng hiện tại
        if (in_array('Admin', $roles)) {
            // Nếu là Admin, hiển thị tất cả phòng chiếu phim
            $rooms = $query->with(['typeRoom', 'cinema'])->orderBy('id', 'DESC')->get();
        } else {
            // Nếu không phải Admin, lọc phòng chiếu phim dựa trên vai trò của người dùng
            $roleIDs = Role::whereIn('name', $roles)->pluck('id')->toArray();
            $allowedCinemas = RoleHasCinema::whereIn('role_id', $roleIDs)->pluck('cinema_id')->toArray();
            $rooms = $query->whereIn('cinema_id', $allowedCinemas)
                ->with(['typeRoom', 'cinema'])
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('admin.room_type.room.index', compact('rooms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        // Xác định role_id của người dùng
        $roles = $user->getRoleNames(); // Get the roles associated with the user
        $roleIDs = [];
        foreach ($roles as $role) {
            $roleModel = Role::where('name', $role)->first(); // Assuming Role model path
            if ($roleModel) {
                $roleIDs[] = $roleModel->id; // Store the role IDs in an array
            }
        }

        // Lấy danh sách cinema_ids từ bảng role_has_cinema với role_id tương ứng
        $cinemaIDs = RoleHasCinema::whereIn('role_id', $roleIDs)->pluck('cinema_id')->toArray();

        // Lấy thông tin của các rạp từ danh sách cinema_ids
        $cinema = Cinema::whereIn('id', $cinemaIDs)->orderBy('id', 'DESC')->get();

        $typeRoom = RoomType::orderBy('id', 'DESC')->get();

        return view('admin.room_type.room.add', compact('typeRoom', 'cinema'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $data = $request->all();
        $room = new Room();
        $room->name = $data['name'];
        $room->cinema_id = $data['cinema_id'];
        $room->room_type_id = $data['room_type_id'];
        $room->description = $data['description'];
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = uploadFile('image', $request->file('image'));
            // Check if $data['image'] is a valid file path before assigning
            if ($data['image']) {
                $room->image = $data['image'];
            } else {
                // Handle file upload error
            }
        }
        $room->save();
        toastr()->success('Cảm ơn! ' . $data['name'] . ' thêm thành công!');
        return redirect()->route('room.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);
        if (!$room) {
            abort(404); // Nếu không tìm thấy bản ghi, xử lý tùy ý (ở đây là trả về trang 404)
        }

        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        if ($user->hasRole('Admin')) {
            // Nếu là Admin, cho phép truy cập không cần kiểm tra cinema_id
            $typeRoom = RoomType::orderBy('id', 'DESC')->get();
            $cinema = Cinema::orderBy('id', 'DESC')->get();
            return view('admin.room_type.room.edit', compact('room', 'typeRoom', 'cinema'));
        }
        // Lấy roleIDs của người dùng hiện tại
        $roleIDs = $user->roles()->pluck('id')->toArray();

        // Lấy danh sách các cinema_id mà người dùng có quyền truy cập
        $allowedCinemaIDs = RoleHasCinema::whereIn('role_id', $roleIDs)->pluck('cinema_id')->toArray();

        // Kiểm tra xem phòng có thuộc cinema_id mà người dùng được phép không
        $isAllowed = Room::where('id', $id)->whereIn('cinema_id', $allowedCinemaIDs)->exists();
        if (!$isAllowed) {
            toastr()->error('Bạn không có quyền chỉnh sửa phòng chiếu phim này!');
            return redirect()->route('room.list');
        }

        // Nếu được phép, lấy thông tin cần thiết và hiển thị trang chỉnh sửa
        $typeRoom = RoomType::orderBy('id', 'DESC')->get();
        $cinema = Cinema::whereIn('id', $allowedCinemaIDs)->orderBy('id', 'DESC')->get();

        return view('admin.room_type.room.edit', compact('room', 'typeRoom', 'cinema'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $id)
    {
        $room = Room::find($id);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $resultDL = Storage::delete('/public/' . $room->image);
                if ($resultDL) {
                    $params['image'] = uploadFile('image', $request->file('image'));
                }
            }
            $result = Room::where('id', $id)->update($params);
            if ($result) {
                toastr()->success('Cập nhật thành công!');
                return redirect()->route('room.form-update', ['id' => $id]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return abort(404);
        }

        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        if ($user->hasRole('Admin')) {
            // Nếu là Admin, cho phép xóa phòng mà không cần kiểm tra cinema_id
            Storage::delete('/public/' . $room->image);
            $room->delete();
            toastr()->success('Xóa thành công!');
            return redirect()->route('room.list');
        }

        // Lấy roleIDs của người dùng hiện tại
        $roleIDs = $user->roles()->pluck('id')->toArray();

        // Lấy cinema_id của phòng để kiểm tra xem người dùng có quyền xóa không
        $allowedCinemaIDs = RoleHasCinema::whereIn('role_id', $roleIDs)->pluck('cinema_id')->toArray();

        if (!in_array($room->cinema_id, $allowedCinemaIDs)) {
            toastr()->error('Bạn không có quyền xóa phòng chiếu phim này!');
            return redirect()->route('room.list');
        }

        // Nếu được phép, xóa phòng và chuyển hướng về danh sách
        Storage::delete('/public/' . $room->image);
        $room->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('room.list');
    }


    public function list_bin(Request $request)
    {
        $user = Auth::user(); // Lấy thông tin người dùng đăng nhập

        if ($user->hasRole('Admin')) {
            // Nếu là Admin, cho phép xem danh sách phòng đã xóa mà không cần kiểm tra cinema_id
            $query = Room::onlyTrashed();
            // Tiếp tục với logic tìm kiếm và lọc status nếu cần
        } else {
            // Lấy roleIDs của người dùng hiện tại
            $roleIDs = $user->roles()->pluck('id')->toArray();

            // Lấy danh sách các cinema_id mà người dùng có quyền truy cập
            $allowedCinemaIDs = RoleHasCinema::whereIn('role_id', $roleIDs)->pluck('cinema_id')->toArray();

            $query = Room::onlyTrashed()->whereIn('cinema_id', $allowedCinemaIDs);
            // Tiếp tục với logic tìm kiếm và lọc status nếu cần
        }

        // Áp dụng logic tìm kiếm và lọc status nếu có
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }

        $softDeletedRoom = $query->orderBy('id', 'DESC')->paginate(10);
        return view('admin.room_type.room.bin', compact('softDeletedRoom'));
    }

    public function restore_bin(Request $request, $id)
    {
        $room = Room::withTrashed()->find($id);
        if ($room) {
            $room->restore();
            $room->deleted_at = null;
            $room->save();
            toastr()->success('Cập nhật thành công!');
            return redirect()->route('bin.list-room');
        } else {
            abort(404);
        }
    }
    public function delete_bin(Request $request, $id)
    {
        $room = Room::withTrashed()->find($id);

        if ($room && $room->deleted_at !== null) {
            Storage::delete('/public/' . $room->image);
            $room->forceDelete();
            toastr()->success('Xóa thành công!');
            return redirect()->route('bin.list-room');
        } else {
            abort(404);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $item = Room::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        if ($ids) {
            Room::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các phòng đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các phòng đã chọn');
        }
    }

    public function delete_bin_all(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $room = Room::withTrashed()->whereIn('id', $ids);
            $room->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn phòng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phòng đã chọn');
        }
        return redirect()->route('room.list');
    }
    public function restore_bin_all(Request $request)
    {

        $ids = $request->ids;
        if ($ids) {
            $room = Room::withTrashed()->whereIn('id', $ids);
            $room->restore();
            toastr()->success('Thành công', 'Thành công khôi phục phòng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phòng đã chọn');
        }
        return redirect()->route('room.list');
    }
}

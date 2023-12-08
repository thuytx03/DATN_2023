<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
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
    public function index(Request $request)
    {
        $query = RoomType::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $roomType = $query->orderBy('id', 'DESC')->get();

        return view('admin.room_type.room_type.index', compact('roomType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.room_type.room_type.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomTypeRequest $request)
    {
        $data = $request->all();
        $roomType = new RoomType();
        $roomType->name = $data['name'];
        $roomType->slug = $data['slug'];
        $roomType->description = $data['description'];
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = uploadFile('image', $request->file('image'));
            // Check if $data['image'] is a valid file path before assigning
            if ($data['image']) {
                $roomType->image = $data['image'];
            } else {
                // Handle file upload error
            }
        }
        try {
            $roomType->save();
            toastr()->success('Cảm ơn! ' . $roomType->name . ' thêm thành công!');
            return redirect()->route('room-type.list');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            toastr()->error('Đã xảy ra lỗi khi thêm phòng. Vui lòng thử lại.');
            return redirect()->back()->withInput();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roomType = RoomType::find($id);
        if (!$roomType) {
            abort(404); // Nếu không tìm thấy bản ghi, trả về trang 404 hoặc xử lý tùy ý.
        }
        return view('admin.room_type.room_type.edit', compact('roomType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomTypeRequest $request, $id)
    {
        $roomType = RoomType::find($id);
        if (!$roomType) {
            toastr()->error('Không tìm thấy loại phòng.');
            return redirect()->route('form-update-room-type', ['id' => $id]);
        }
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $resultDL = Storage::delete('/public/' . $roomType->image);
                if ($resultDL) {
                    $params['image'] = uploadFile('image', $request->file('image'));
                }
            }
            $result = RoomType::where('id', $id)->update($params);
            if ($result) {
                toastr()->success('Cập nhật thành công!');
                return redirect()->route('room-type.form-update', ['id' => $id]);
            } else {
                toastr()->error('Cập nhật thất bại. Vui lòng thử lại.');
                return redirect()->route('room-type.form-update', ['id' => $id]);
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
        RoomType::where('id', $id)->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('room-type.list');
    }

    public function list_bin(Request $request)
    {

        $query = RoomType::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status trong trash
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }

        $softDeletedRoomType = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.room_type.room_type.bin', compact('softDeletedRoomType'));
    }
    public function restore_bin(Request $request, $id)
    {
        $room = RoomType::withTrashed()->find($id);
        if ($room) {
            $room->restore();
            $room->deleted_at = null;
            $room->save();
            toastr()->success('Cập nhật thành công!');
            return redirect()->route('bin.list-room-type');
        } else {
            abort(404);
        }
    }
    public function delete_bin(Request $request, $id)
    {
        $room = RoomType::withTrashed()->find($id);

        if ($room && $room->deleted_at !== null) {
            Storage::delete('/public/' . $room->image);
            $room->forceDelete();
            toastr()->success('Xóa thành công!');
            return redirect()->route('bin.list-room-type');
        } else {
            abort(404);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $item = RoomType::find($id);

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
            RoomType::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các phòng đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các phòng đã chọn');
        }
    }

    public function delete_bin_all(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $room = RoomType::withTrashed()->whereIn('id', $ids);
            $room->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn phòng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phòng đã chọn');
        }
        return redirect()->route('room-type.list');
    }
    public function restore_bin_all(Request $request)
    {

        $ids = $request->ids;
        if ($ids) {
            $room = RoomType::withTrashed()->whereIn('id', $ids);
            $room->restore();
            toastr()->success('Thành công', 'Thành công khôi phục phòng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các phòng đã chọn');
        }
        return redirect()->route('list-room-type');
    }
}

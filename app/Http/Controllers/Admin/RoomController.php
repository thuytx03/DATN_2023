<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = Room::query();
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
        $room = $query->with('typeRoom')->orderBy('id', 'DESC')->get();
        return view('admin.room_type.room.index', compact('room'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeRoom = RoomType::orderBy('id', 'DESC')->get();
        return view('admin.room_type.room.add', compact('typeRoom'));
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
        return redirect()->route('list-room');
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
            abort(404); // Nếu không tìm thấy bản ghi, trả về trang 404 hoặc xử lý tùy ý.
        }
        $typeRoom = RoomType::orderBy('id', 'DESC')->get();
        return view('admin.room_type.room.edit', compact('room', 'typeRoom'));
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
                return redirect()->route('form-update-room', ['id' => $id]);
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
        Storage::delete('/public/' . $room->image);
        Room::where('id', $id)->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('list-room');
    }

    public function list_bin(Request $request)
    {
        $query = Room::onlyTrashed();

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
            return redirect()->route('list-bin-room');
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
            return redirect()->route('list-bin-room');
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
        return redirect()->route('list-room');
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
        return redirect()->route('list-room');
    }
}

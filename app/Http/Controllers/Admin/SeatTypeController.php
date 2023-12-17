<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeatTypeRequest;
use App\Models\SeatType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class SeatTypeController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin', ['only' => $methods]);
    }
     public function index(Request $request)
    {
        $query = SeatType::query();
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
        $seatType =$query->orderBy('id', 'DESC')->get();

        return view('admin.seats.seat_type.index', compact('seatType'));

    }

    public function store(SeatTypeRequest $request)
    {
        if($request->isMethod('POST')){
            try {
                $seatType = new SeatType();
                $seatType->name = $request->name;
                $seatType->description = $request->description;
                $seatType->status = $request->status;
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                  $seatType->image = uploadFile('seatType', $request->file('image'));
                } else {
                  $seatType->image = null;
                }
                if (!$request->slug) {
                    $seatType->slug = Str::slug($request->name);
                } else {
                    $seatType->slug = Str::slug($request->slug);
                }
                if ($seatType->save()) {
                    toastr()->success('Thêm mới loại ghế thành công!', 'success');
                    return redirect()->route('seat-type.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                dd('Error: ' . $e->getMessage());

            }
        }
        return view('admin.seats.seat_type.add');


    }

    public function edit($id)
    {
        //
    }

    public function update(SeatTypeRequest $request, $id)
    {
        $seatType=SeatType::find($id);
        if($request->isMethod('POST')){
            try {
                $seatType->name = $request->name;
                $seatType->description = $request->description;
                $seatType->status = $request->status;
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    Storage::delete('/public/' . $seatType->image);
                    $seatType->image = uploadFile('seatType', $request->file('image'));
                    $params['image'] = $request->image;
                } else {
                    $seatType->image = $seatType->image;
                }
                if (!$request->slug) {
                    $seatType->slug = Str::slug($request->name);
                } else {
                    $seatType->slug = Str::slug($request->slug);
                }
                if ($seatType->save()) {
                    toastr()->success('Cập nhật loại ghế thành công!', 'success');
                    return redirect()->route('seat-type.index');
                }
            } catch (\Illuminate\Database\QueryException $e) {
                dd('Error: ' . $e->getMessage());
            }
        }
        return view('admin.seats.seat_type.edit', compact('seatType'));

    }

    public function destroy($id)
    {
        SeatType::where('id', $id)->delete();
        toastr()->success('Xóa thành công loại ghế!');
        return redirect()->route('seat-type.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $item = SeatType::find($id);

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
            SeatType::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các loại ghế đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các loại ghế đã chọn');
        }
    }
    public function trash(Request $request)
    {
        $deleteItems = SeatType::onlyTrashed();

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
        return view('admin.seats.seat_type.trash', compact('deleteItems'));
    }

    public function restore($id)
    {
        if ($id) {
            $restore = SeatType::withTrashed()->find($id);
            $restore->restore();
            toastr()->success('Khôi phục loại ghế thành công', 'success');
            return redirect()->route('seat-type.trash');
        }
    }
    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = SeatType::withTrashed()->whereIn('id', $ids);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công khôi phục loại ghế');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các loại ghế đã chọn');
        }
        return redirect()->route('seat-type.trash');
    }
    public function permanentlyDelete($id)
    {
        $voucher = SeatType::withTrashed()->findOrFail($id);
        $voucher->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn loại ghế');
        return redirect()->route('seat-type.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = SeatType::withTrashed()->whereIn('id', $ids);
            $voucher->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn loại ghế');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các loại ghế đã chọn');
        }
        return redirect()->route('seat-type.trash');
    }
}

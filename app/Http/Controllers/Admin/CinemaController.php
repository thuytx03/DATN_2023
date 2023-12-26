<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\Province;
use App\Http\Requests\CinemaRequest;
use carbon\Carbon;
use Illuminate\Support\Str;


class CinemaController extends Controller
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
        //

        $query = Cinema::query();

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

        $cinema1 = $query->orderBy('id', 'DESC')->paginate(3);
        $provinces = Province::all();
        return view('admin.cinema.index', compact('cinema1', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $province1 = Province::all();
        return view('admin.cinema.add', compact('province1'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CinemaRequest $request)
    {
        //
        $cinema = new Cinema();
        $cinema->province_id = $request->province_id;
        $cinema->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $cinema->slug = $slug;
        $cinema->address = $request->address;
        $cinema->phone = $request->phone;
        $cinema->open_hours = $request->open_hours;
        $cinema->close_hours = $request->close_hours;
        $cinema->description = $request->description;
        if ($request->hasFile('image')) {
            $cinema->image = uploadFile('cinema', $request->file('image'));
        }
        $cinema->status = $request->status;
        $cinema->save();
        toastr()->success('Rạp chiếu ' . $request->name . ' thêm thành công!');
        return redirect()->route('cinema.add');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $cinema = Cinema::find($id);
        $province = Province::all();
        return view('admin.cinema.edit', compact('cinema', 'province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CinemaRequest $request, $id)
    {
        //
        $cinema = new Cinema();
        $cinema = Cinema::find($id);
        $cinema->province_id = $request->province_id;
        $cinema->name = $request->name;
        if ($request->slug == '') {
            $cinema->slug = $request->name;
        } else {
            $cinema->slug = $request->slug;
        }
        $cinema->address = $request->address;
        $cinema->phone = $request->phone;
        $cinema->open_hours = $request->open_hours;
        $cinema->close_hours = $request->close_hours;
        $cinema->description = $request->description;
        if ($request->hasFile('image')) {
            $cinema->image = uploadFile('cinema', $request->file('image'));
        }
        $cinema->status = $request->status;
        $cinema->save();
        toastr()->success('Rạp chiếu ' . $request->name . ' cập nhật thành công!');
        return redirect()->route('cinema.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Cinema::find($id)->delete();
        toastr()->success('Xóa rạp chiếu thành công!');
        return redirect()->route('cinema.index');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Cinema::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các rạp phim đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các rạp phim đã chọn');
        }
    }

    public function trash(Request $request)
    {
        $provinces = Province::all();
        $query = Cinema::onlyTrashed();

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

        $cinemas = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.cinema.trash', [
            'cinemas' => $cinemas, 'provinces' => $provinces
        ]);
    }
    public function permanentlyDelete($id)
    {
        $cinema = Cinema::withTrashed()->findOrFail($id);
        $cinema->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn rạp phim');
        return redirect()->route('cinema.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $cinema = Cinema::withTrashed()->whereIn('id', $ids);
            $cinema->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn rạp phim');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các rạp phim đã chọn');
        }
        return redirect()->route('voucher.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $cinema = Cinema::withTrashed()->whereIn('id', $ids);
            $cinema->restore();
            toastr()->success('Thành công', 'Thành công khôi phục rạp phim');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các rạp phim đã chọn');
        }
        return redirect()->route('cinema.trash');
    }
    public function restore($id)
    {
        if ($id) {
            $cinema = Cinema::withTrashed()->findOrFail($id);
            $cinema->restore();
            toastr()->success('Thành công', 'Thành công khôi phục rạp phim');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các rạp phim đã chọn');
        }
        return redirect()->route('cinema.trash');
    }
    public function cleanupTrash()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(1);
        Cinema::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->forceDelete();
        return redirect()->route('index.cinema')->withSuccess('Đã xoá vĩnh viễn rạp phim trong thùng rác');
    }
    public function updateStatus(Request $request, $id)
    {
        $item = Cinema::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }
}

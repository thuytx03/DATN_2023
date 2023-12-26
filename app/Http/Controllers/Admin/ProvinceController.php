<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Http\Requests\ProvinceRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProvinceController extends Controller
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
        $query = Province::query();

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

        $province1 = $query->orderBy('id', 'DESC')->paginate(3);
        return view('admin.province.index', compact('province1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.province.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinceRequest $request)
    {
        //
        $province = new Province();
        $province->name = $request->name;
        $province->slug = Str::slug($request->name);
        $province->description = $request->description;
        if ($request->hasFile('image')) {
            $province->image = uploadFile('province', $request->file('image'));
        }
        $province->status = $request->status;
        $province->save();
        toastr()->success('Khu vực ' . $request->name . ' thêm thành công!');
        return redirect()->route('province.add');
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
        $province = Province::find($id);
        return view('admin.province.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinceRequest $request, $id)
    {
        //
        $province = new Province();
        $province = Province::find($id);
        $province->name = $request->name;
        $province->slug = Str::slug($request->name);
        $province->description = $request->description;
        if ($request->hasFile('image')) {
            $province->image = uploadFile('province', $request->file('image'));
        }
        $province->status = $request->status;
        $province->save();
        toastr()->success('Khu vực ' . $request->name . ' cập nhật thành công!');
        return redirect()->route('province.index');
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
        Province::find($id)->delete();
        toastr()->success('Xóa khu vực thành công!');
        return redirect()->route('province.index');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Province::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các khu vực đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các khu vực đã chọn');
        }
    }
    public function trash(Request $request)
    {
        $query = Province::onlyTrashed();

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

        $provinces = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.province.trash', [
            'provinces' => $provinces
        ]);
    }
    public function permanentlyDelete($id)
    {
        $province = Province::withTrashed()->findOrFail($id);
        $province->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn khu vực');
        return redirect()->route('province.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $province = Province::withTrashed()->whereIn('id', $ids);
            $province->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn khu vực');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các khu vực đã chọn');
        }
        return redirect()->route('province.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $province = Province::withTrashed()->whereIn('id', $ids);
            $province->restore();
            toastr()->success('Thành công', 'Thành công khôi phục khu vực');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các khu vực đã chọn');
        }
        return redirect()->route('province.trash');
    }
    public function restore($id)
    {
        if ($id) {
            $province = Province::withTrashed()->findOrFail($id);
            $province->restore();
            toastr()->success('Thành công', 'Thành công khôi phục khu vực');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các khu vực đã chọn');
        }
        return redirect()->route('province.trash');
    }
    public function forceDelete($id)
    {
        $province = Province::withTrashed()->find($id);
        $province->forceDelete();
        toastr()->success(' Xóa khu vực thành công!', 'success');
        return redirect()->route('province.trash');
    }
    public function cleanupTrash()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(1);
        Province::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->forceDelete();
        return redirect()->route('index.province')->withSuccess('Đã xoá vĩnh viễn khu vực trong thùng rác');
    }
    public function updateStatus(Request $request, $id)
    {
        $item = Province::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }
}

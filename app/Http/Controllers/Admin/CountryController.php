<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yoeunes\Toastr\Facades\Toastr;

class CountryController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin', ['only' => $methods]);
    }
    public function index()
    {
        $country = Country::latest()->paginate(10);
        return view('admin.country.index', compact('country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CountryRequest $request)
    {
        if ($request->isMethod('POST')) {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $request->image = uploadFile('country', $request->file('image'));
            } else {
                $request->image = null;
            }
            $country = Country::create([
                'slug' => Str::slug($request->name),
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'image' => $request->image
            ]);

            return redirect()->route('country.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        return view('admin.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(CountryRequest $request, $id)
    {
        if ($request->isMethod('POST')) {
            $country = Country::find($id);
            $params = $request->except('_token', 'image');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                Storage::delete('/public/' . $country->image);
                $request->image = uploadFile('country', $request->file('image'));
                $params['image'] = $request->image;
                $params['slug'] = Str::slug($request->name);
            } else {
                $request->image = $country->image;
            }
            DB::beginTransaction();
            $country->update($params);
            DB::commit();
            toastr()->success('Cập nhật quốc gia thành công!', 'success');
        }
        return redirect()->route('country.index');
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
            $deleted = Country::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa quốc gia thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('country.index');
        }
    }

    public function trash()
    {
        $country = Country::onlyTrashed()->get();
        return view('admin.country.trash', compact('country'));
    }
    public function restore($id)
    {
        $country = Country::onlyTrashed()->find($id);
        if ($country) {
            $country->restore();
            toastr()->success('khôi phục thành công', 'success');
        } else {
            toastr()->error('Có lỗi xảy ra', 'error');
        }
        return redirect()->route('country.index');
    }
    public function delete($id)
    {
    }

    public function updateStatus(Request $request, $id)
    {
        $item = Country::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }
    public function permanentlyDelete($id)
    {
        $voucher = Country::withTrashed()->findOrFail($id);
        $voucher->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn quốc gia');
        return redirect()->route('country.trash');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Country::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các mã giảm giá đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các mã giảm giá đã chọn');
        }
    }

    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $country     = Country::withTrashed()->whereIn('id', $ids);
            $country->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn quốc gia');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các quốc gia đã chọn');
        }
        return redirect()->route('country.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $country = Country::withTrashed()->whereIn('id', $ids);
            $country->restore();
            toastr()->success('Thành công', 'Thành công khôi phục mã giảm giắ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các mã giảm giắ đã chọn');
        }
        return redirect()->route('country.trash');
    }
    public function cleanupTrash()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(1);
        Country::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->forceDelete();
        return redirect()->route('country.index')->withSuccess('Đã xoá vĩnh viễn mã giảm giá trong thùng rác');
    }

    public function search(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $countries = Country::query();
        if ($status) {
            $countries->where('status', $status);
        }

        if ($search) {
            $countries->where('name', 'like', '%' . $search . '%');
        }
        $country = $countries->paginate(10);

        if ($country) {
            return view('admin.country.index', compact('country'));
        }
    }
}

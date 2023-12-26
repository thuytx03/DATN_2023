<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foodstypes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Kalnoy\Nestedset\Node;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\MovieFoodsTypes;
use App\Models\MovieFood;
use Illuminate\Validation\Rule;

class FoodTypesController extends Controller
{

    protected $htmlSelect;
    public function __construct()
    {
        $this->htmlSelect = '';
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

        $listTypes = Foodstypes::query();

        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $listTypes->where('name', 'LIKE', '%' . $keyword . '%');
        }
        if ($request->has('status') && in_array($request->input('status'), ['active', 'unactive'])) {
            $status = $request->status;
            if ($status == 'active') {
                $status = 1;
            } elseif ($status == 'unactive') {
                $status = 0;
            }
            $listTypes->where('status', $status);
        }
        $foodTypes = $listTypes->paginate(5);
        return view('admin.Foods.foodtypes.index', compact('foodTypes'));
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $Foodstypes = Foodstypes::withTrashed()->whereIn('id', $ids);
            $Foodstypes->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá  mã giảm giá');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các đã chọn');
        }
        return redirect()->route('food_types.indexsd');
    }
    public function deleteAll(Request $request)
    {

        $ids = $request->ids;
        if ($ids) {
            Foodstypes::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các Danh Mục Đồ Ăn đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các Danh Mục Đồ Ăn đã chọn');
        }

        return back();
    }
    public function changeStatus(Request $request, $id)
    {
        $foodType = Foodstypes::find($id);

        if ($foodType) {
            $newStatus = $foodType->status == 1 ? 0 : 1;
            $foodType->status = $newStatus;
            $foodType->save();

            $movieFoodsTypes = MovieFoodsTypes::where('food_type_id', $foodType->id)->get();

            if (!empty($movieFoodsTypes)) {
                $movieFoodIds = $movieFoodsTypes->pluck('food_id')->toArray();
                $movieFood = MovieFood::whereIn('id', $movieFoodIds)->first();

                if ($movieFood) {
                    // cập nhật bên moviefood
                    $movieFood->status = $newStatus;
                    $movieFood->save();
                }
            }

            // Chuyển hướng trở lại trang danh sách (food_types.index)
            return redirect()->route('food_types.index');
        } else {
            // Nếu không tìm thấy $foodType, có thể xử lý lỗi hoặc thông báo tùy theo logic của bạn.
        }
    }
    public function indexsd(Request $request)
    {

        $listTypes = Foodstypes::onlyTrashed();


        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $listTypes->where('name', 'LIKE', '%' . $keyword . '%');;
        }

        if ($request->has('status') && in_array($request->input('status'), ['active', 'unactive'])) {
            $status = $request->input('status');
            if ($status == 'active') {
                $status = 1;
            } elseif ($status == 'unactive') {
                $status = 0;
            }
            $listTypes->where('status', $status);
        }


        $Foodstypes1 =  $listTypes->onlyTrashed()->paginate(5);




        return view('admin.Foods.foodtypes.indexSoftDelete', compact('Foodstypes1'));
    }
    public function unTrash($id)
    {
        if ($id) {
            $Undeleted = Foodstypes::withTrashed()->find($id);
            $Undeleted->restore();
            if ($Undeleted->restore()) {
                toastr()->success('khôi phục danh mục thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('food_types.indexsd');
        }
    }
    public function unTrashAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = Foodstypes::withTrashed()->whereIn('id', $ids);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công khôi ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('food_types.indexsd');
    }

    public function destroySoftDelete($id)
    {
        if ($id) {
            $data = Foodstypes::withTrashed()->where('id', $id)->first();
            if ($data) {
                MovieFoodsTypes::where('food_type_id', $data->id)->delete();
            }
            $destroySoftDelete = Foodstypes::withTrashed()->find($id);
            $abc =   $destroySoftDelete->forceDelete();
            if ($abc) {
                toastr()->success('Xóa Vĩnh Viễn thành Công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('food_types.index');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listTyoes = Foodstypes::all();
        $htmlOption = $this->getfoodsTypes($parent_id = "");
        return view('admin.Foods.foodtypes.add', compact('htmlOption'));
    }








    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->isMethod('POST')) {
                $validate = $request->validate([
                    'name' => 'required|unique:foods_types,name',
                    // check trùng tên
                ], [
                    'name.required' => 'Vui Lòng Nhập Tên',
                    'name.unique' => 'Không được nhập trùng tên'
                ]);
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $request->image = uploadFile('Foodstypes', $request->file('image'));
                } else {
                    $request->image = null;
                }
                $Foodstypes = new Foodstypes();

                $Foodstypes->name = $request->name;
                if (!empty($request->slug)) {
                    $Foodstypes->slug = $request->slug;
                } else {
                    $Foodstypes->slug = Str::slug($request->input('name'));
                }
                $Foodstypes->image = $request->image;
                $Foodstypes->description = $request->description;
                if (!empty($request->status)) {
                    $Foodstypes->status = $request->status;
                } else {
                    $Foodstypes->status = 1;
                }
                if ($request->parent_id !=  $request->id) {
                    $Foodstypes->parent_id = $request->parent_id;
                } else {
                    toastr()->error('bạn không được phép nhập', 'error');
                    return redirect()->route('food_types.add');
                }


                if ($Foodstypes->save()) {
                    toastr()->success('Thêm mới danh mục thành công!', 'success');
                    return redirect()->route('food_types.index');
                }
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
        $listTyoes = Foodstypes::all();
        $listTyoes1 = Foodstypes::find($id);
        $htmlOption = $this->getfoodsTypes($listTyoes1->parent_id);
        return view('admin.Foods.foodtypes.edit', compact('listTyoes', 'listTyoes1', 'htmlOption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        try {
            $Foodstypes = Foodstypes::find($id);
            if ($request->isMethod('POST')) {
                $validate = $request->validate([
                    'name' => ['required', Rule::unique('foods_types')->ignore($id)],
                    'slug' => [Rule::unique('foods_types')->ignore($id)],
                ], [
                    'name.required' => 'Vui Lòng Nhập Tên',
                    'name.unique' => 'Không được nhập trùng tên',
                    'slug.unique' => 'Không được nhập trùng đường dẫn'
                ]);
                $params = $request->except('_token', 'image');
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    Storage::delete('/public/' . $Foodstypes->image);
                    $request->image = uploadFile('Foodstypes', $request->file('image'));
                    $params['image'] = $request->image;
                } else {
                    $request->image = $Foodstypes->image;
                }

                if ($request->parent_id !=  $request->id) {
                    $params['parent_id'] = $request->parent_id;
                } else {
                    toastr()->error('bạn không được phép nhập', 'error');
                    return redirect()->route('food_types.edit');
                }

                $params['slug'] = Str::slug($params['name']);
                // Sử dụng DB transaction để bảo vệ tính toàn vẹn của nested set
                // DB::beginTransaction();
                $Foodstypes->update($params);
                DB::commit();
            }
            toastr()->success('Cập nhật danh mục thành công!', 'success');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                // Lỗi duplicate entry
                DB::rollBack(); // Lưu ý: Rollback transaction nếu xảy ra lỗi
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng nhập tên khác']);
            }
            toastr()->error('Có lỗi xảy ra !', 'error');
        }

        return redirect()->route('food_types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            $deleted = Foodstypes::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa danh mục thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('food_types.index');
        }
    }


    public function foodsTypesRecusive($parent_id, $id = 0, $text = '')
    {
        $listTypes = Foodstypes::all();


        foreach ($listTypes as $value) {
            if ($value['parent_id'] == $id) {
                if (!empty($parent_id) && $parent_id == $value['id']) {
                    $this->htmlSelect .= "<option selected value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
                } else {
                    $this->htmlSelect .= "<option value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
                }
                // Gom kết quả của lần gọi đệ quy vào chuỗi HTML
                // $htmlSelect .= $this->foodsTypesRecusive($parent_id, $value['id'], $text . '--');
                $this->foodsTypesRecusive($parent_id, $value['id'], $text . '--');
            }
        }


        return  $this->htmlSelect;
    }
    public function getfoodsTypes($parent_id)
    {
        $listTyoes = Foodstypes::all();
        $htmlOption = $this->foodsTypesRecusive($parent_id);
        return $htmlOption;
    }
}

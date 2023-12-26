<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovieFood;
use Illuminate\Http\Request;
use App\Models\Foodstypes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\MovieFoodsTypes;
use App\Http\Controllers\Admin\FoodTypesController;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MovieFoodsController extends Controller
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
       
        $this->checkStatus();
        
        $listfood = MovieFood::query();
        $lisfood_types = MovieFoodsTypes::query();
        $types = Foodstypes::all();
        $listfood1 = MovieFood::with('Foodstypes')->get();
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $listfood->where('name', 'LIKE', '%'.$keyword.'%');
        }
        if ($request->has('food_type_id') && $request->input('food_type_id')) {
            $food_type_id = $request->input('food_type_id');
            $listfood = $listfood->whereHas('foodstypes', function ($query) use ($food_type_id) {
                $query->where('foods_types.id', $food_type_id);
            });
        }
        if ($request->has('status') && in_array($request->input('status'), ['hethang', 'ngungkinhdoanh'])) {
            $status = $request->input('status');
            if ($status == 'hethang') {
                $status = 2;
            } elseif ($status == 'ngungkinhdoanh') {
                $status = 0;
            }
            $listfood->where('status', $status);
        }
      
        $listfood1 = $listfood->paginate(5);
       
        return view('admin.Foods.foodss.index', compact('listfood1', 'types', 'lisfood_types'));
    }
    public function checkStatus()
    {
      
        $remainingMovieFood = MovieFood::where('quantity', '=', 0)->get();
        $remainingMovieFoods = MovieFood::where('quantity', '>', 0)->get();
        foreach ($remainingMovieFood as $MovieFood2) {
          if($MovieFood2->status != 0 ) {
            if ($MovieFood2->quantity == 0) {
                $MovieFood2->status = 2;
                $MovieFood2->save();
            }
          }
            
        }
        foreach ($remainingMovieFoods as $MovieFood1) {
            if($MovieFood1->status != 0 ) {
                if ($MovieFood1->quantity > 0) {
                    $MovieFood1->status = 1;
                    $MovieFood1->save();
                }
              }
        }
      
    }
    public function changeStatus(Request $request, $id){
        
      
        if($id){
            $MovieFood = MovieFood::find($id);
            $newStatus = $MovieFood->status == 1 ? 0 : 1;
            $MovieFood->status = $newStatus;
            $MovieFood->save();
            return redirect()->route('movie-foode.index');
           }
           
      else
       {
        toastr()->error('Có lỗi xảy ra', 'error');
        return redirect()->route('food_types.index');
      }
    }
    
    

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            MovieFood::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các Danh Mục Đồ Ăn đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các Danh Mục Đồ Ăn đã chọn');
        }

        return back();
    }
    public function unTrashAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $MovieFood = MovieFood::withTrashed()->whereIn('id', $ids);
            $MovieFood->restore();
            toastr()->success('Thành công', 'Thành công khôi ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('movie-foode.index');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $MovieFood = MovieFood::withTrashed()->whereIn('id', $ids);
            $MovieFood->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn mã giảm giá');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các mã giảm giắ đã chọn');
        }
        return redirect()->route('movie-food.index');
    }
    public function unTrash($id)
    {


        if ($id) {
            $Undeleted = MovieFood::withTrashed()->find($id);
            $Undeleted->restore();
            if ($Undeleted->restore()) {
                toastr()->success('khôi phục danh mục thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('movie-foode.indexsd');
        }
    }





    public function indexsd(Request $request)
    {
        $remainingProducts = MovieFood::onlyTrashed()
            ->where('quantity', '=', 0)
            ->get();


        $listfood = MovieFood::onlyTrashed();
        $lisfood_types = MovieFoodsTypes::query();
        $types = Foodstypes::all();
        $listfood1 = MovieFood::with('Foodstypes')->get();
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $listfood->where('name', 'LIKE','%'.$keyword.'%');
        }
        if ($request->has('food_type_id') && $request->input('food_type_id')) {
            $food_type_id = $request->input('food_type_id');
            $listfood = $listfood->whereHas('foodstypes', function ($query) use ($food_type_id) {
                $query->where('foods_types.id', $food_type_id);
            });
        }


        $listfood = $listfood->onlyTrashed()->paginate(5);
        return view('admin.Foods.foodss.indexSoftDelete', compact('listfood', 'types'));
    }
    public function unTrashSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = MovieFood::withTrashed()->whereIn('id', $ids);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công Đồ Ăn');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các đồ ăn đã chọn');
        }
        return redirect()->route('movie-foode.index');
    }
    public function destroySoftDelete($id)
    {
        if ($id) {
            $data = MovieFood::withTrashed()->where('id', $id)->first();
            MovieFoodsTypes::where('food_id', $data->id)->forceDelete();
            $destroySoftDelete = MovieFood::withTrashed()->find($id);
            $abc =   $destroySoftDelete->forceDelete();
            if ($abc) {
                toastr()->success('Xóa Vĩnh Viễn thành Công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('movie-foode.index');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Foodstypes = Foodstypes::all();

        return view('admin.Foods.foodss.add', compact('Foodstypes'));
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
        $validate = $request->validate([
            'name' => 'required|unique:movie_foods,name',
            'price' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('Giá không được phép để âm.');
                    }
                },
            ],
            'quantity' => 'required'
        ], [
            'name.unique' => 'Vui lòng không nhập trùng tên',
            'name.required' => 'Vui lòng nhập Tên',
            'price.required' => 'Vui lòng nhập Giá',
            'price.numeric' => 'Giá phải là số.',
            'quantity.required' => 'Vui lòng nhập số lượng'
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $request->image = uploadFile('MovieFood', $request->file('image'));
        } else {
            $request->image = null;
        }

        $MovieFood = new MovieFood();
        $MovieFood->name = $request->name;

        if (!empty($request->slug)) {
            $MovieFood->slug = $request->slug;
        } else {
            $MovieFood->slug = Str::slug($MovieFood->name); // Fixed: Use -> instead of ['name']
        }

        $MovieFood->description = $request->description;
        $MovieFood->price = $request->price;
        $MovieFood->image = $request->image;
        $MovieFood->quantity = $request->quantity;

        if ($MovieFood->save()) {
            if (!empty($request['foodstypes'])) {
                foreach ($request['foodstypes'] as $key => $Foodstypes) {
                    $MovieFood->food_type_id = $Foodstypes[0];
                }
                $MovieFood->Foodstypes()->sync($request->input('foodstypes'));
            }

            toastr()->success('Thêm mới danh mục thành công!', 'success');
        }

        return redirect()->route('movie-foode.index');
    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->errorInfo[1] === 1062) {
            return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng sửa đường dẫn']);
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
        $MovieFood = MovieFood::all();
        $Foodstypes = Foodstypes::all();
        $data = MovieFood::where('id', $id)->first();
        $MovieFoodsTypes = MovieFoodsTypes::where('food_id', $data->id)->get();

        return view('admin.Foods.foodss.edit', compact('MovieFood', 'MovieFoodsTypes', 'data', 'Foodstypes'));
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

            if ($request->isMethod('POST')) {
                $MovieFood = MovieFood::find($id);
                $validate = $request->validate([
                    'name' => ['required', Rule::unique('movie_foods')->ignore($id)],
                    'slug' => [Rule::unique('movie_foods')->ignore($id)],
                    'price' => [
                        'required',
                        'numeric',
                        function ($attribute, $value, $fail) {
                            if ($value < 0) {
                                $fail($attribute.'không được phép để âm.');
                            }
                        },
                    ],
                    'quantity' => 'required'
                ], [
                    'name.unique' => 'Vui lòng không nhập trùng tên',
                    'name.required' => 'Vui Lòng Nhập Tên',
                    'price.required' => 'Vui Lòng Nhập Giá',
                    'price.numeric' => 'Giá phải là số.',
                    'quantity.required' => 'Vui Lòng Nhập số lượng',
                    'slug.unique'   => 'Vui Lòng không nhập trùng slug'
                ]);
                $params = $request->except('_token', 'image');
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    Storage::delete('/public/' . $MovieFood->image);
                    $request->image = uploadFile('MovieFood', $request->file('image'));
                    $params['image'] = $request->image;
                } else {
                    $request->image = $MovieFood->image;
                }
                $params['price'] = $request->price;
                $params['description'] = $request->description;
                $params['quantity'] = $request->quantity;
                $params['slug'] = Str::slug($params['name']);




                // Sử dụng DB transaction để bảo vệ tính toàn vẹn của nested set
                DB::beginTransaction();
                // Cập nhật thông tin cơ bản của danh mục
                $MovieFood->update($params);
                if ($request->has($request['foodstypes'])) {
                    foreach ($request['foodstypes'] as $key => $Foodstypes) {
                        $MovieFood->food_type_id = $Foodstypes[0];
                    }
                }
                $MovieFood->Foodstypes()->sync($request->input('foodstypes'));
                // Commit transaction nếu mọi thứ thành công
                DB::commit();
            }
            toastr()->success('Cập nhật danh mục thành công!', 'success');
        } catch (QueryException $e) {
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                // Lỗi duplicate entry
                DB::rollBack(); // Lưu ý: Rollback transaction nếu xảy ra lỗi
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng nhập tên khác']);
            }
            toastr()->error('Có lỗi xảy ra !', 'error');
        }


        return redirect()->route('movie-foode.index');
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
            $deleted = MovieFood::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa danh mục thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('movie-foode.index');
        }
    }
}

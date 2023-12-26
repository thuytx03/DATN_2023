<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipLevel;
use Illuminate\Http\Request;

use Illuminate\Database\QueryException;

class MemberShipLevelsController extends Controller
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
        $query = MembershipLevel::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        if ($request->has('status')) {
            $status = $request->input('status');
            
            if ($status == 1 || $status == 0) {
                $query->where('status', $status);
            } elseif ($status == 'all') {
                $query->get();
            }
        }
    
        $listLevel = $query->paginate(5);
    
        return view('admin.membershiplevel.index', compact('listLevel'));
    }

    public function restoreSelected(Request $request)
    {
      
        $ids = $request->ids;
        if ($ids) {
            $MembershipLevel = MembershipLevel::withTrashed()->whereIn('id', $ids);
       
            $MembershipLevel->restore();
            toastr()->success('Thành công', 'Thành công khôi phục ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('MBSL.trash');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.membershiplevel.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            // try {
                $this->validate($request, [
                    'name' => 'required|unique:membership_levels,name',
                    'min_limit' => 'nullable|min:0',
                    'max_limit' => 'nullable|integer|greater_than_field:min_limit',
                    'benefits' => 'required|integer|min:0|lt:100',
                    'benefits_food' => 'required|integer|min:0|lt:100',
                ], [
                    'name.required' => 'Vui lòng nhập Tên',
                    'name.unique' => 'Không được nhập trùng tên',
                    'max_limit.greater_than_field' => 'Hạn Mức Tối Đa phải lớn hơn Hạn Mức Tối Thiểu',
                    'benefits.integer' => 'Lợi ích phải là số nguyên',
                    'benefits.lt' => 'Lợi ích phải nhỏ hơn 100',
                    'benefits.required' => 'Không để trống lợi ích',
                    'benefits_food.integer' => 'Lợi ích phải là số nguyên',
                    'benefits_food.lt' => 'Lợi ích phải nhỏ hơn 100',
                    'benefits_food.required' => 'Không để trống lợi ích',
                  
                ]);
                $membershipLevel = new MembershipLevel();
                $membershipLevel->name = $request->input('name');
                $membershipLevel->min_limit = $request->input('min_limit');
                $membershipLevel->max_limit = $request->input('max_limit');
                $membershipLevel->benefits = $request->input('benefits');
                $membershipLevel->benefits_food = $request->input('benefits_food');
                if($request->has('status')){
                    $membershipLevel->status = $request->input('status');
                }
              
                $membershipLevel->Description = $request->input('description');
    
           
            
                if ( $membershipLevel->save()) {
                    toastr()->success('Thêm mới Cấp Độ thành công!', 'success');
                    return redirect()->route('MBSL.list');
                }
    
             // }
            //  catch (QueryException $e) {
            //     // Handle the database query exception
            //     return redirect()->back()->with('error', 'Có Lỗi xảy ra');
            // }
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
    public function edit(Request $request,$id)
    {
      
            $MembershipLevels = MembershipLevel::all();
            $membershipLevel = MembershipLevel::find($id);

            return view('admin.membershiplevel.edit', compact('membershipLevel'));
        
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
            // Step 1: Kiểm tra xem có tồn tại MembershipLevel với ID đã cho hay không
            $membershipLevel = MembershipLevel::find($id);
            
            if (!$membershipLevel) {
                return redirect()->route('MBSL.list')->with('error', 'Không tìm thấy Cấp Độ.');
            }
    
            // Step 2: Thực hiện xác thực dữ liệu gửi lên từ biểu mẫu chỉnh sửa
            $this->validate($request, [
                'name' => 'required|unique:membership_levels,name,' . $id . '|sometimes',
                'min_limit' => 'nullable|min:0',
                'max_limit' => 'nullable|integer|greater_than_field:min_limit',
                'benefits' => 'required|integer|min:0|lt:100',
                'benefits_food' => 'required|integer|min:0|lt:100',
            ], [
                'name.required' => 'Vui lòng nhập Tên',
                'name.unique' => 'Tên đã tồn tại, vui lòng chọn tên khác.',
                'max_limit.greater_than_field' => 'Hạn Mức Tối Đa phải lớn hơn Hạn Mức Tối Thiểu',
                'benefits.integer' => 'Lợi ích phải là số nguyên',
                'benefits.lt' => 'Lợi ích phải nhỏ hơn 100',
                'benefits.required' => 'Không để trống lợi ích',
                'benefits_food.integer' => 'Lợi ích phải là số nguyên',
                'benefits_food.lt' => 'Lợi ích phải nhỏ hơn 100',
                'benefits_food.required' => 'Không để trống lợi ích',
            ]);
            // Step 3: Cập nhật thông tin của MembershipLevel dựa trên dữ liệu gửi lên
            $membershipLevel->name = $request->input('name');
            $membershipLevel->min_limit = $request->input('min_limit');
            $membershipLevel->max_limit = $request->input('max_limit');
            $membershipLevel->benefits = $request->input('benefits');
            $membershipLevel->status = $request->input('status');
            $membershipLevel->benefits_food = $request->input('benefits_food');
            $membershipLevel->Description = $request->input('description');
    
            // Step 4: Lưu cập nhật vào cơ sở dữ liệu
            if ($membershipLevel->save()) {
                toastr()->success('Cập nhật Cấp Độ thành công!', 'success');
                return redirect()->route('MBSL.list');
            } else {
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật Cấp Độ.');
            }
        } catch (QueryException $e) {
            // Step 5: Handle the database query exception
            return redirect()->back()->with('error', 'Có lỗi xảy ra');
        }
    }
    
      

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id)
    {
        if ($id) {
            $deleted = MembershipLevel::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('MBSL.list');
        }
    }
    public function changeStatus(Request $request, $id){
        
      
        if($id){
            $MembershipLevel = MembershipLevel::find($id);
            $newStatus = $MembershipLevel->status == 1 ? 0 : 1;
            $MembershipLevel->status = $newStatus;
            $MembershipLevel->save();
            return redirect()->route('MBSL.list');
           }
           
      else
       {
        toastr()->error('Có lỗi xảy ra', 'error');
        return redirect()->route('MBSL.list');
      }
    }
    public function trash(Request $request)
    {
        $query = MembershipLevel::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        if ($request->has('status')) {
            $status = $request->input('status');
            
            if ($status == 1 || $status == 0) {
                $query->where('status', $status);
            } elseif ($status == 'all') {
                $query->get();
            }
        }
    

        $listLevel = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.membershiplevel.trash', [
            'listLevel' => $listLevel
        ]);
    }
    public function restore( $id)
    {
        if ($id) {
            $MembershipLevel = MembershipLevel::withTrashed()->findOrFail($id);
            $MembershipLevel->restore();
            toastr()->success('Thành công', 'Thành công khôi phục ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('MBSL.trash');
    }
    public function permanentlyDelete($id)
    {
        $MembershipLevel = MembershipLevel::withTrashed()->findOrFail($id);
        $MembershipLevel->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn ');
        return redirect()->route('MBSL.trash');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
      
        if ($ids) {
            MembershipLevel::whereIn('id', $ids)->delete();
            toastr()->success( 'Thành công xoá  đã chọn');
        } else {
            toastr()->warning( 'Không tìm thấy đã chọn');
        }
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $MembershipLevel = MembershipLevel::withTrashed()->whereIn('id', $ids);
            $MembershipLevel->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn ');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('MBSL.trash');
    }
    
  
}

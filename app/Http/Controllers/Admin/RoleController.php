<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Cinema;
use App\Models\RoleHasCinema;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', 'list_bin', 'delete_bin', 'delete_bin_all', 'restore_bin', 'restore_bin_all', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh', ['only' => $methods]);
        $this->middleware('role:Admin', ['only' => ['list_bin', 'delete_bin', 'delete_bin_all', 'restore_bin', 'restore_bin_all','create','destroy']]);
    }
    /** public function __construct()
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Role::query();

        // Lấy danh sách các vai trò của người dùng đang đăng nhập
        $userRoles = auth()->user()->getRoleNames()->toArray();

        // Lọc danh sách vai trò nếu không phải là 'Admin'
        if (!in_array('Admin', $userRoles)) {
            $query->whereIn('name', $userRoles);
        }

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lấy và sắp xếp danh sách vai trò
        $role = $query->orderBy('id', 'DESC')->whereNot('id', 1000)->get();

        return view('admin.role_permission.role.index', compact('role'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $roles = $user->getRoleNames()->toArray();

        $cinemas = Cinema::orderBy('id', 'desc'); // Bắt đầu với tất cả rạp chiếu phim

        // Nếu người dùng không phải là Admin
        if (!in_array('Admin', $roles)) {
            $allowedCinemas = RoleHasCinema::where('role_id', $user->id)->pluck('cinema_id')->toArray();
            $cinemas = $cinemas->whereIn('id', $allowedCinemas);
        }

        $cinemas = $cinemas->get(); // Lấy danh sách rạp sau khi áp dụng điều kiện

        $permission = Permission::all()->groupBy('group');
        return view('admin.role_permission.role.add', compact('permission', 'cinemas'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(RoleRequest $request)
    {

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'group' => $request->group,
        ]);

        $role->syncPermissions($request->input('permission'));
        $role->cinemas()->attach($request->input('cinema'));

        toastr()->success('Thank!  add successfully!');
        return redirect()->route('role.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            abort(404);
        }
        $user = auth()->user();
        $isAdmin = $user->hasRole('Admin');

        if (!$isAdmin && !$user->hasRole($role->name)) {
            // Nếu không phải Admin và không có quyền của vai trò này, ngăn chặn việc chỉnh sửa
            toastr()->error('Bạn không có quyền chỉnh vai trò này!');
            return redirect()->route('role.list');
        }
        $permission = Permission::all()->groupBy('group');
        $user = auth()->user();
        $isAdmin = $user->hasRole('Admin');

        $cinemas = Cinema::orderBy('id', 'desc'); // Bắt đầu với tất cả các rạp chiếu phim

        if (!$isAdmin) {
            $allowedCinemas = RoleHasCinema::where('role_id', $user->id)->pluck('cinema_id')->toArray();
            $cinemas->whereIn('id', $allowedCinemas); // Nếu không phải Admin, lọc theo các rạp cho phép
        }

        $cinemas = $cinemas->get(); // Lấy danh sách rạp chiếu phim

        $get_permission_via_role = $role->permissions; // Lấy quyền từ vai trò

        return view('admin.role_permission.role.edit', compact('role', 'permission', 'get_permission_via_role', 'cinemas'));
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
    public function update(RoleRequest $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            // Handle the case where the role with the given ID doesn't exist.
        }

        if ($request->isMethod('POST')) {
            $params = $request->except('_token', '_method', 'permission'); // Exclude '_method' and 'permission' if they're not needed.
            $role->syncPermissions($request->input('permission', [])); // Assuming 'permission' is an array.
            $cinemaIds = $request->input('cinema', []);

            // Cập nhật lại các cinema_id của role
            $role->cinemas()->sync($cinemaIds);
            $result = $role->update($params);

            if ($result) {
                toastr()->success('Cập nhật thành công!');
                return redirect()->route('role.form-update', ['id' => $id]);
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
        $role = Role::find($id);

        if (!$role) {
            abort(404);
        }
        $user = auth()->user();
        $isAdmin = $user->hasRole('Admin');

        if (!$isAdmin && !$user->hasRole($role->name)) {
            // Nếu không phải Admin và không có quyền của vai trò này, ngăn chặn việc chỉnh sửa
            toastr()->error('Bạn không có quyền xóa vai trò này!');
            return redirect()->route('role.list');
        } else {
            $role->delete();
        }
        toastr()->success('Xóa thành công!');
        return redirect()->route('role.list');
    }
    //thùng rác 
    public function list_bin(Request $request)
    {
        // Bắt đầu với tất cả vai trò đã bị xóa
        $query = Role::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lấy danh sách vai trò trong thùng rác sau khi áp dụng điều kiện lọc
        $softDeletedRoles = $query->get();

        return view('admin.role_permission.role.bin', compact('softDeletedRoles'));
    }


    public function restore_bin(Request $request, $id)
    {
        $role = Role::withTrashed()->find($id);
        if ($role) {
            $role->restore();
            $role->deleted_at = null;
            $role->save();
            toastr()->success('Cập nhật thành công!');
            return redirect()->route('role.list');
        } else {
            abort(404);
        }
    }
    public function delete_bin(Request $request, $id)
    {
        $role = Role::withTrashed()->find($id);
        if ($role && $role->deleted_at !== null) {
            // Xóa các bản ghi liên quan trong bảng pivot
            $role->permissions()->detach(); // Xóa bản ghi liên quan từ role_has_permission
            $role->users()->detach(); // Xóa bản ghi liên quan từ role_has_model
            $role->cinemas()->detach(); // Xóa bản ghi liên quan từ role_has_cinemas

            $role->forceDelete(); // Sau khi xóa các liên kết, xóa vai trò
            toastr()->success('Xóa thành công!');
            return redirect()->route('role.list');
        } else {
            abort(404);
        }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Role::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các vai trò đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các vai trò đã chọn');
        }
    }
    public function delete_bin_all(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $role = Role::withTrashed()->whereIn('id', $ids);
            $role->permissions()->detach(); // Xóa bản ghi liên quan từ role_has_permission
            $role->users()->detach(); // Xóa bản ghi liên quan từ role_has_model
            $role->cinemas()->detach(); // Xóa bản ghi liên quan từ role_has_cinemas
            $role->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn vai trò');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các vai trò đã chọn');
        }
        return redirect()->route('role.list');
    }
    public function restore_bin_all(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $role = Role::withTrashed()->whereIn('id', $ids);
            $role->restore();
            toastr()->success('Thành công', 'Thành công khôi phục vai trò');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các vai trò đã chọn');
        }
        return redirect()->route('role.list');
    }
}

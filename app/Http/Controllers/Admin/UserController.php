<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Doctrine\ORM\EntityManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh', ['only' => $methods]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập
        $query = User::query();

        // Lọc theo tên
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lọc theo trạng thái
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }

        // Lọc theo vai trò tương tự với người dùng đang đăng nhập
        $userRoles = $user->getRoleNames()->toArray();

        // Nếu người dùng có vai trò 'Admin', hiển thị tất cả người dùng
        if (in_array('Admin', $userRoles)) {
            // Không áp dụng bất kỳ điều kiện nào
        } else {
            // Người dùng không phải 'Admin' chỉ xem các vai trò tương tự với vai trò của họ và người không có vai trò
            $query->where(function ($query) use ($userRoles) {
                $query->whereHas('roles', function ($roleQuery) use ($userRoles) {
                    $roleQuery->whereIn('name', $userRoles);
                })->orWhereDoesntHave('roles');
            });
        }

        $users = $query->orderBy('id', 'DESC')->paginate(10);
        return view('admin.user.index', compact('users'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Nếu là 'Admin', lấy tất cả các vai trò
            $roles = Role::all();
        } else {
            // Nếu không phải 'Admin', lấy các vai trò của người dùng
            $roles = $user->roles;
        }

        $permissions = Permission::all(); // Lấy tất cả các quyền

        return view('admin.user.add', compact('roles', 'permissions'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $user = new User();
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender == 0 ? 'Nam' : 'Nữ';

        if ($request->hasFile('avatar')) {
            $user->avatar = uploadFile('user', $request->file('avatar'));
        }

        $user->status = $request->status;
        $user->save();

        if ($request->has('role')) {
            $user->assignRole($request->input('role'));
        }

        toastr()->success('Cảm ơn ' . $request->name . ' thêm thành công!');
        return redirect()->route('user.add');
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
        $user = User::find($id);
        if (empty($user)) {
            abort(404);
        }

        $currentUser = Auth::user();
        $isAdmin = $currentUser->hasRole('Admin');

        if (!$isAdmin && !$this->userCanEdit($user, $currentUser)) {
            toastr()->error('Bạn không có quyền chỉnh sửa người dùng này!');
            return redirect()->route('user.index');
        }

        $roles = $this->getUserRoles($isAdmin, $currentUser);
        $userRoles = $user->getRoleNames();

        return view('admin.user.edit', compact('user', 'roles', 'userRoles'));
    }
    private function userCanEdit($user, $currentUser)
    {
        $userRoles = $user->getRoleNames()->toArray();
        $currentUserRoles = $currentUser->getRoleNames()->toArray();
        $currentUserRolesWithoutAdmin = array_diff($currentUserRoles, ['Admin']);

        if (empty($userRoles)) {
            // Nếu tài khoản không có vai trò nào, cho phép sửa đổi
            return true;
        }

        // Kiểm tra xem vai trò 'Admin' có trong tài khoản đang xem xét không
        $isAdmin = in_array('Admin', $userRoles);

        // Loại bỏ vai trò 'Admin' trước khi so sánh
        $matchingRoles = array_intersect($userRoles, $currentUserRolesWithoutAdmin);

        return !empty($matchingRoles) && !$isAdmin;
    }

    private function getUserRoles($isAdmin, $currentUser)
    {
        if ($isAdmin) {
            return Role::orderBy('id', 'DESC')->get();
        } else {
            return $currentUser->roles;
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LoginRequest $request, $id)
    {
        $user = User::find($id);

        // Cập nhật thông tin người dùng từ dữ liệu gửi lên
        $user->fill([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
            'status' => $request->status,
        ]);

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $user->avatar = uploadFile('user', $request->file('avatar'));
        }

        // Kiểm tra và cập nhật mật khẩu nếu có
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Lưu thông tin người dùng
        $user->save();

        // Gán các vai trò mới từ yêu cầu gửi lên
        if ($request->filled('role')) {
            $user->roles()->sync($request->input('role'));
        } else {
            // Xóa các vai trò không được chọn
            $user->roles()->detach();
        }

        toastr()->success('Cập nhật ' . $user->name . ' thành công!');
        return redirect()->route('user.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            abort(404);
        }
        $currentUser = Auth::user();

        $currentUserRoles = $currentUser->getRoleNames()->toArray();

        if (in_array('Admin', $currentUserRoles)) {
            // Nếu là Admin, cho phép xóa người dùng và trả về thông báo thành công
            $user->delete();
            toastr()->success('Xóa người dùng thành công!');
            return redirect()->route('user.index');
        }

        // Nếu không phải là Admin, tiếp tục kiểm tra vai trò tương tự và quyền xóa
        $userRoles = $user->getRoleNames()->toArray();

        $matchingRoles = array_intersect($userRoles, $currentUserRoles);

        if (empty($matchingRoles) && empty($userRoles)) {
            // Nếu không có vai trò nào và không phải là Admin, cho phép xóa
            $user->delete();
            toastr()->success('Xóa người dùng thành công!');
            return redirect()->route('user.index');
        } elseif (empty($matchingRoles)) {
            // Nếu không có vai trò tương tự, không cho phép xóa
            toastr()->error('Bạn không có quyền xóa người dùng này!');
            return redirect()->route('user.index');
        }

        // Nếu có vai trò tương tự, không cho phép xóa
        toastr()->error('Bạn không có quyền xóa người dùng này!');
        return redirect()->route('user.index');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            User::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các người dùng đã chọn');
        } else {
            toastr()->warning('Không tìm thấy người dùng  đã chọn');
        }
    }
    public function trash(Request $request)
    {
        $query = User::onlyTrashed();
        $user = Auth::user();
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
        $userRoles = $user->getRoleNames()->toArray();

        if (in_array('Admin', $userRoles)) {
            // Không áp dụng bất kỳ điều kiện nào
        } else {
            // Người dùng không phải 'Admin' chỉ xem các vai trò tương tự với vai trò của họ và người không có vai trò
            $query->where(function ($query) use ($userRoles) {
                $query->whereHas('roles', function ($roleQuery) use ($userRoles) {
                    $roleQuery->whereIn('name', $userRoles);
                })->orWhereDoesntHave('roles');
            });
        }
        $users = $query->orderBy('id', 'DESC')->paginate(10);
        return view('admin.user.trash', [
            'users' => $users
        ]);
    }
    public function permanentlyDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn người dùng');
        return redirect()->route('user.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $user = User::withTrashed()->whereIn('id', $ids);
            $user->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn người dùng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các người dùng đã chọn');
        }
        return redirect()->route('user.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $user = User::withTrashed()->whereIn('id', $ids);
            $user->restore();
            toastr()->success('Thành công', 'Thành công khôi phục người dùng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các người dùng đã chọn');
        }
        return redirect()->route('user.trash');
    }
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        toastr()->success(' Khôi phục người dùng  thành công!', 'success');
        return redirect()->route('user.trash');
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id); // Xóa bản ghi liên quan từ role_has_permission
        $user->roles()->detach(); // Xóa bản ghi liên quan từ role_has_model
        $user->forceDelete();
        toastr()->success(' Xóa người dùng  thành công!', 'success');
        return redirect()->route('user.trash');
    }
    public function cleanupTrash()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(1);
        $user = User::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo);
        $user->roles()->detach(); // Xóa bản ghi liên quan từ role_has_model
        $user->forceDelete();
        return redirect()->route('index.user')->withSuccess('Đã xoá vĩnh viễn khu vực trong thùng rác');
    }
    public function updateStatus(Request $request, $id)
    {
        $item = user::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public function role(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::orderBy('id', 'DESC')->get();
        $permission = Permission::orderBy('id', 'DESC')->get();
        $check_role = $user->roles->first();
        return view('admin.user.role', compact('user', 'role', 'check_role', 'permission'));
    }

    public function permission(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->roles->isEmpty()) {
            toastr()->error('Error! Add roles first!');
            return redirect()->route('dashboard');
        }
        $permission = Permission::orderBy('id', 'DESC')->get();
        $name_role = $user->roles->first()->name;
        $get_permission_via_role = $user->getPermissionsViaRoles();
        return view('admin.user.permission', compact('user', 'name_role', 'permission', 'get_permission_via_role'));
    }

    public function insert_role(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->syncRoles($data['role']);
        $role_id = $user->roles->first()->id;
        toastr()->success('Cập nhật vai trò thành công!');
        return redirect()->route('admin.dashboard');
    }

    public function insert_permission(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $role_id = $user->roles->first()->id;
        $role = Role::find($role_id);
        $role->syncPermissions($data['permission']);
        toastr()->success('Cập nhật quyền thành công!');
        return redirect()->route('admin.dashboard');
    }
}

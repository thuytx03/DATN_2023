<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::orderBy('id', 'DESC')->whereNotIn('name', ['Jungx-Admin'])->get();
        return view('admin.role_permission.role.index', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::all()->groupBy('group');
        // dd($permission);
        return view('admin.role_permission.role.add', compact('permission'));
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


        toastr()->success('Thank!  add successfully!');
        return redirect()->route('list-role');
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
            abort(404); // Nếu không tìm thấy bản ghi, trả về trang 404 hoặc xử lý tùy ý.
        }
        if (($role->id == 1)) {
            abort(404);
        } else {
            $permission = Permission::all()->groupBy('group');
            $get_permission_via_role = $role->permissions;
            return view('admin.role_permission.role.edit', compact('role', 'permission', 'get_permission_via_role'));
        }
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

            $result = $role->update($params);

            if ($result) {
                toastr()->success('Cập nhật thành công!');
                return redirect()->route('form-update-role', ['id' => $id]);
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
        if ($id == 1) {
            toastr()->error('Không thể xóa vai trò này!');
            return redirect()->route('list-role');
        }
        Role::where('id', $id)->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('list-role');
    }
    //thùng rác 
    public function list_bin(Request $request)
    {
        $softDeletedRoles = Role::onlyTrashed()->get();
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
            return redirect()->route('list-bin-role');
        } else {
            abort(404);
        }
    }
    public function delete_bin(Request $request, $id)
    {
        $role = Role::withTrashed()->find($id);

        if ($role && $role->deleted_at !== null) {
            $role->forceDelete();
            toastr()->success('Xóa thành công!');
            return redirect()->route('list-bin-role');
        } else {
            abort(404);
        }
    }
}

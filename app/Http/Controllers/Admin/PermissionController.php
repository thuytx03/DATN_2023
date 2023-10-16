<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = Permission::orderBy('id', 'DESC')->get();
        return view('admin.role_permission.permission.index', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role_permission.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $data = $request->all();
        $user = new Permission();
        $user->name = $data['name'];
        $user->display_name = $data['display_name'];
        $user->group = $data['group'];
        $user->save();
        toastr()->success('Thank! ' . $data['display_name'] . ' add successfully!');
        return redirect()->route('list-permission');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            abort(404); // Nếu không tìm thấy bản ghi, trả về trang 404 hoặc xử lý tùy ý.
        }
        return view('admin.role_permission.permission.edit', compact('permission'));
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
    public function update(PermissionRequest $request, $id)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            $result = Permission::where('id', $id)->update($params);
            if ($result) {
                toastr()->success('Cập nhật thành công!');
                return redirect()->route('form-update-permission', ['id' => $id]);
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
        Permission::where('id', $id)->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('list-permission');
    }
    public function list_bin(Request $request)
    {
        $softDeletedPermissions = Permission::onlyTrashed()->get();
        return view('admin.role_permission.permission.bin', compact('softDeletedPermissions'));
    }

    public function restore_bin(Request $request, $id)
    {
        $permission = Permission::withTrashed()->find($id);
        if ($permission) {
            $permission->restore();
            $permission->deleted_at = null;
            $permission->save();
            toastr()->success('Cập nhật thành công!');
            return redirect()->route('list-bin-permission');
        } else {
            abort(404);
        }
    }
    public function delete_bin(Request $request, $id)
    {
        $permission = Permission::withTrashed()->find($id);

        if ($permission && $permission->deleted_at !== null) {
            $permission->forceDelete();
            toastr()->success('Xóa thành công!');
            return redirect()->route('list-bin-permission');
        } else {
            abort(404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('roles')->get();
        return view('admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $data = $request->all();
        $user = new User();
        $user->password = Hash::make($data['password']);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();
        toastr()->success('Cảm ơn! ' . $data['name'] . ' thêm thành công!');
        return redirect()->route('list-user');
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
        //
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
        toastr()->success('Thank! Update role successfully!');
        return redirect()->route('admin.dashboard');
    }

    public function insert_permission(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $role_id = $user->roles->first()->id;
        $role = Role::find($role_id);
        $role->syncPermissions($data['permission']);
        toastr()->success('Thank! Update permission successfully!');
        return redirect()->route('admin.dashboard');
    }
}

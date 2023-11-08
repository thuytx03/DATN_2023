<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\profileRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Doctrine\ORM\EntityManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function profile()
    {
        $user = auth()->user();
        return view('client.profiles.profile', compact('user'));
    }

    public function edit_profile(profileRequest $request)
    {   
        $user = auth()->user();

        if ($request->isMethod('post')) {
            $params = $request->except('_token');
            //dd($user, $params);
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $imageFileName = uploadFile('users', $request->file('avatar'));

                if (!empty($user->avatar)) {
                    Storage::delete('/public/' . $user->avatar);
                }
                $params['avatar'] = $imageFileName;
                //dd($params['image']);
            } else {
                $request->avatar = $user->avatar;
            }
            if ($request->filled('password')) {
                $params['password'] = bcrypt($request->input('password'));
            }
            //dd($params);
            DB::beginTransaction();
            $user->update($params);
            DB::commit();
            toastr()->success('Cập nhật thông tin thành công!', 'success');
        }

        return view('client.profiles.edit-profile', compact('user'));
    }
    public function purchase_history()
    {

        return view('client.profiles.purchase-history');
    }

    public function change_password(profileRequest $request)
    {
        $user = auth()->user();

        if ($request->isMethod('post')) {
            if (Hash::check($request->input('oldPassword'), $user->password)) {
                $user->password = bcrypt($request->input('password'));
                $user->save();
                toastr()->success('Đổi mật khẩu thành công!', 'success');
            }else{
                toastr()->error('Mật khẩu cũ không khớp', 'error');
            }
        }

        return view('client.profiles.change-password', compact('user'));
    }
}

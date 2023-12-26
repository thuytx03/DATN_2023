<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\profileRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Doctrine\ORM\EntityManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;
use App\Models\MembershipLevel;
use App\Http\Controllers\Client\BookingController;

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

    public function transaction_history()
    {
        $user = auth()->user()->id;
        $booking = Booking::where('user_id', $user)->paginate(3);

        return view('client.profiles.transaction_history', compact('booking'));
    }

    public function transaction_history_detail($id)
    {
        $booking = Booking::find($id);
        $booking_detail = BookingDetail::where('booking_id', $booking->id)->get();
        return view('client.profiles.transaction_history_detail', compact('booking','booking_detail'));
    }


    public function change_password(profileRequest $request)
    {
        $user = auth()->user();

        if ($request->isMethod('post')) {
            if (Hash::check($request->input('oldPassword'), $user->password)) {
                $user->password = bcrypt($request->input('password'));
                $user->save();
                toastr()->success('Đổi mật khẩu thành công!', 'success');
            } else {
                toastr()->error('Mật khẩu cũ không khớp', 'error');
            }
        }

        return view('client.profiles.change-password', compact('user'));
    }
    public function points(){
        $booking123 = new BookingController();
        

        $profile = new ProfileController();
      
        $user = auth()->user();
        if (!isset($user)) {
            return view('admin.auth.login');
        }else {
        $booking123->checkstatus2($user->id);
        $members = Member::where('user_id',$user->id)->first();
       $MembershipLevels = MembershipLevel::all();
       $bookings = Booking::all();
        return view('client.profiles.points',compact('members','MembershipLevels','bookings','profile'));
        }
    }


    public function member() {
        $user = auth()->user();

        if (!isset($user)) {
            return view('admin.auth.login');
        } else {
            $member = DB::table('members')->where('user_id', $user->id)->first();
            $user_name = DB::table('users')->where('id',$user->id)->first();
            $membershiplv = DB::table('membership_levels')->where('id',$member->level_id)->first();
            // Check if the member is found
            if (!$member) {
                return abort(404); // or redirect to an error page
            }

            $totalSpending = $member->total_spending;
            $limits = DB::table('membership_levels')->get();

            // Get the highest spending limit
            $highestLimit = MembershipLevel::max('min_limit');

            // Check if the highest limit is greater than zero
            if ($highestLimit > 0) {
                // Calculate the percentage spent
                $percentSpent = ($totalSpending / $highestLimit) * 100;
            } else {
                // Handle the case where $highestLimit is zero to avoid division by zero
                $percentSpent = 0;
            }

            return view('client.profiles.member-profile', compact('member', 'percentSpent', 'limits', 'totalSpending', 'highestLimit','membershiplv','user_name'));
        }
    } 

    // hàm làm tròn điểm ví dụ 0,1-0,4 sẽ lấy về số trước còn 0,5->0,9 lấy theo số sau
    function roundNumber($number)
{
  $precision = 1;

  $roundedNumber = round($number, $precision);

  $digit = $roundedNumber - floor($roundedNumber);

  if ($digit <= 0.4) {
    $roundedNumber = floor($roundedNumber);
  } else {
    $roundedNumber = ceil($roundedNumber);
  }

  return $roundedNumber;
}
}


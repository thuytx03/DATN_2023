<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\MembershipLevel;
use App\Models\Booking;

class MemBerController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();
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
        $users = User::all();
        $bookings = Booking::all();
        $MembershipLevels  = MembershipLevel::all();
        
     
        $lastYear = date('Y') - 1;
      
    
        $listLevel = $query->paginate(5);
    
        return view('admin.member.index', compact('listLevel','users','MembershipLevels','lastYear','query','bookings'));
    }
    public function changeStatus(Request $request, $id){
        
      
  
        if($id){
            $Member = Member::find($id);
            $newStatus = $Member->status == 1 ? 0 : 1;
            $Member->status = $newStatus;
            $Member->save();
            return redirect()->route('member.list');
           }
           
      else
       {
        toastr()->error('Có lỗi xảy ra', 'error');
        return redirect()->route('MBSL.list');
      }
    }
}

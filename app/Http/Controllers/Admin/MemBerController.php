<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\MembershipLevel;
use App\Models\Booking;
use App\Models\ShowTime;
use App\Http\Controllers\Client\BookingController;

class MemBerController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin', ['only' => $methods]);
    }
    public function index(Request $request)

    {
        $bookingstatus = new BookingController();
        $bookingstatus->checkStatus();
        $query = Member::query();

        $membernumber = new MemBerController();
        // Search condition
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('card_number', 'like', '%' . $search . '%');
        }
        $lastYear = date('Y') - 1;
        // Status condition
        if ($request->has('status')) {
            $status = $request->input('status');

            if ($status == 1 || $status == 0) {
                $query->where('status', $status);
            } elseif ($status == 'all') {
                // Do nothing here, no need to call $query->get() without conditions
            }
        }

        // Retrieve necessary data
        $users = User::all();
        $bookings = Booking::all();
        $ShowTimes = ShowTime::all();
        $MembershipLevels  = MembershipLevel::all();

        // Pagination
        $listLevel = $query->get();

        return view('admin.member.index', compact('listLevel', 'users', 'MembershipLevels', 'lastYear', 'query', 'bookings', 'ShowTimes', 'membernumber'));
    }

    public function restoreSelected(Request $request)
    {

        $ids = $request->ids;
        if ($ids) {
            $Member = Member::withTrashed()->whereIn('id', $ids);

            $Member->restore();
            toastr()->success('Thành công', 'Thành công khôi phục ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('member.trash');
    }
    public function restore($id)
    {
        if ($id) {
            $Member = Member::withTrashed()->findOrFail($id);
            $Member->restore();
            toastr()->success('Thành công', 'Thành công khôi phục ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('member.trash');
    }


    public function changeStatus(Request $request, $id)
    {



        if ($id) {
            $Member = Member::find($id);
            $newStatus = $Member->status == 1 ? 0 : 1;
            $Member->status = $newStatus;
            $Member->save();
            return redirect()->route('member.list');
        } else {
            toastr()->error('Có lỗi xảy ra', 'error');
            return redirect()->route('member.list');
        }
    }
    public function edit($id)
    {

        $member = Member::find($id);
        $membershipLevels = MembershipLevel::all();
        return view('admin.member.edit', compact('member', 'membershipLevels'));
    }
    function destroy($id)
    {
        if ($id) {
            $deleted = Member::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('member.list');
        }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        if ($ids) {
            Member::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá  đã chọn');
        } else {
            toastr()->warning('Không tìm thấy đã chọn');
        }
    }
    public function trash(Request $request)
    {
        $query = Member::onlyTrashed();

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

        $lastYear = date('Y') - 1;
        $users = User::all();
        $bookings = Booking::all();
        $ShowTimes = ShowTime::all();
        $MembershipLevels  = MembershipLevel::all();
        $listLevel = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.member.trash', compact('listLevel', 'users', 'MembershipLevels', 'lastYear', 'query', 'bookings', 'ShowTimes'));
    }

    public function update(Request $request, $id)
    {
        // Kiểm tra dữ liệu đầu vào từ biểu mẫu
        $request->validate([
            'level_id' => [
                'required', // Đảm bảo cấp độ được chọn
                function ($attribute, $value, $fail) use ($id) {
                    $member = Member::find($id);

                    if ($member) {
                        $selectedLevel = MembershipLevel::find($value);
                        if ($selectedLevel) {
                            // Kiểm tra nếu người dùng muốn giảm cấp
                            if ($selectedLevel->id < $member->level_id) {
                                if ($member->total_spending < $selectedLevel->min_limit || ($selectedLevel->max_limit !== null && $member->total_spending > $selectedLevel->max_limit)) {
                                    $fail("Không thể giảm cấp độ này vì số tiền khách hàng tiêu không nằm trong hạn mức.");
                                }
                            }
                        }
                    }
                },
            ],
            // Thêm các quy tắc kiểm tra dữ liệu khác (nếu cần)
        ]);

        // Tìm thành viên cần cập nhật
        $member = Member::find($id);



        if ($member) {
            // Cập nhật các trường thông tin thành viên
            $member->level_id = $request->input('level_id');
            $member->card_number = $request->input('card_number');

            if ($request->has('cong_current_bonus_points')) {
                $congPoints = $request->input('cong_current_bonus_points');
                // Thực hiện phép cộng
                $member->current_bonus_points += $congPoints;
                $member->total_bonus_points += $congPoints;
            } else {
                $member->current_bonus_points = $request->input('current_bonus_points');
                $member->total_bonus_points = $request->input('total_bonus_points');
            }

            if ($request->has('tru_current_bonus_points')) {
                $truPoints = $request->input('tru_current_bonus_points');
                // Thực hiện phép trừ
                $member->current_bonus_points -= $truPoints;
                $member->total_bonus_points -= $truPoints;
            } else {
                $member->current_bonus_points = $request->input('current_bonus_points');
                $member->total_bonus_points = $request->input('total_bonus_points');
            }


            if ($request->has('status')) {
                $member->status = $request->input('status');
            }

            // Cập nhật các trường thông tin khác nếu cần

            // Lưu thông tin thành viên đã cập nhật
            $member->save();

            return redirect()->route('member.list')->with('success', 'Cập nhật thành viên thành công.');
        }

        return redirect()->back()->with('error', 'Không tìm thấy thành viên.');
    }
    public function permanentlyDelete($id)
    {
        $Member = Member::withTrashed()->findOrFail($id);
        $Member->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn ');
        return redirect()->route('member.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $Member = Member::withTrashed()->whereIn('id', $ids);
            $Member->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn ');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy ');
        }
        return redirect()->route('member.trash');
    }



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

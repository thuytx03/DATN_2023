<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\RoleHasCinema;
use App\Models\Room;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\Member;

class BookingsController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh|Staff-Booking-HaNoi|Staff-Booking-HaiPhong|Staff-Booking-ThaiBinh|Staff-Booking-NamDinh|Staff-Booking-NinhBinh', ['only' => $methods]);
    }
    public function index(Request $request)
    {
        $query = Booking::query();
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            $query->get();
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = Showtime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds
            // if ($showtimeIds) {
                $query->whereIn('showtime_id', $showtimeIds);
            // }
        }
        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $bookings = $query->orderBy('id', 'DESC')->paginate(5);

        return view('admin.booking.index', [
            'bookings' => $bookings
        ]);
    }

    public function detail($id)
    {
        $booking = Booking::find($id);
        $booking_detail = BookingDetail::where('booking_id', $booking->id)->get();
        return view('admin.booking.detail', [
            'title' => 'Chi tiết hoá đơn',
            'booking' => $booking,
            'booking_detail' => $booking_detail
        ]);
    }

    public function confirm($id)
    {
        $booking = Booking::find($id);
        $booking->status = 3;
        $booking->save();
        return redirect()->back();
    }
    public function unConfirm($id)
    {
        $booking = Booking::find($id);
        $booking->status = 2;
        $booking->save();
        return redirect()->back();
    }
    public function cancel(Request $request, $id)
    {
        $booking = Booking::find($id);

        $cancelReason = $request->input('cancel_reason');
        $booking->cancel_reason = $cancelReason;
        $booking->status = 4;
        $booking->save();




        // Thực hiện các hành động khác sau khi huỷ đơn hàng
        toastr()->success('Đơn hàng đã được huỷ thành công!');
        return redirect()->back();
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Booking::whereIn('id', $ids)->delete();
            BookingDetail::where('booking_id', $ids)->delete();
            toastr()->success('Thành công xoá các hoá đơn đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các hoá đơn đã chọn');
        }
    }

    public function trash(Request $request)
    {
        $query = Booking::onlyTrashed();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $bookings = $query->orderBy('id', 'DESC')->paginate(5);

        return view('admin.booking.trash', [
            'bookings' => $bookings
        ]);
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $booking = Booking::withTrashed()->whereIn('id', $ids);
            $booking_detail = BookingDetail::withTrashed()->whereIn('booking_id', $ids);
            $booking->forceDelete();
            $booking_detail->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn hoá đơn');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các hoá đơn đã chọn');
        }
        return redirect()->route('booking.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $booking = Booking::withTrashed()->whereIn('id', $ids);
            $booking_detail = BookingDetail::withTrashed()->whereIn('booking_id', $ids);
            $booking->restore();
            $booking_detail->restore();
            toastr()->success('Thành công', 'Thành công khôi phục hoá đơn');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các hoá đơn đã chọn');
        }
        return redirect()->route('booking.trash');
    }
}

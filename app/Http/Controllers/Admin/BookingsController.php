<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use App\Models\Member;

class BookingsController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query();

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
        $members = Member::all();

        $member = $members->where('user_id', $booking->user_id)->first();

        if ($member) {
            // Nếu thành viên tồn tại, cập nhật giá trị total_bonus_points
            $member->total_bonus_points += $booking->total;
            $member->current_bonus_points += $booking->total;

            // Lưu các thay đổi vào cơ sở dữ liệu nếu cần
            $member->save();

            // In ra giá trị mới của total_bonus_points để kiểm tra

        } else {
            // Xử lý trường hợp không tìm thấy thành viên
            dd('Thành viên không tồn tại');
        }





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
            toastr()->success( 'Thành công xoá các hoá đơn đã chọn');
        } else {
            toastr()->warning( 'Không tìm thấy các hoá đơn đã chọn');
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

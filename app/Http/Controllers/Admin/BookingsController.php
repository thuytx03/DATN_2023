<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;

class BookingsController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('permission:booking',['only'=>['index','detail','confirm','unConfirm','cancel']]);

    }
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

        // Thực hiện các hành động khác sau khi huỷ đơn hàng
        toastr()->success('Đơn hàng đã được huỷ thành công!');
        return redirect()->back();
    }
}

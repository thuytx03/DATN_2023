<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\UserVoucher;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherUnlocked;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VouchersController extends Controller
{
    public function vouchers(Request $request)
    {
        $vouchers = Voucher::query();
        if ($request->has('trangthai')) {
            if ($request->input('trangthai') == 'saphethan') {
                $vouchers = Voucher::where('end_date', '>=', now())
                    ->orderBy('end_date', 'asc')
                    ->orderByRaw('end_date - NOW() ASC')
                    ->paginate(5);
                $vouchers1 = $vouchers;
            } elseif ($request->input('trangthai') == 'moi') {


                $vouchers1 = $vouchers->latest()->paginate(5);
            }
        } else {
            $vouchers1 = $vouchers->latest()->paginate(5);
        }
        if ($request->has('giamgia')) {
            if ($request->input('giamgia') == 'theophantram') {
                $vouchers = Voucher::where('type', '=', 2)
                    ->paginate(5);
                $vouchers1 = $vouchers;
            } elseif ($request->input('giamgia') == 'theogia') {
                $vouchers = Voucher::where('type', '=', 1)
                    ->paginate(5);
                $vouchers1 = $vouchers;
            }
        }


        return view('client.vouchers.vouchers-list', compact('vouchers1'));
    }

    public function detailVouchers($id)
    {
        $vouchers = Voucher::query();
        $vouchers1 = $vouchers->find($id);
        $user = auth()->user()->id;
        // dd($user);
        $voucher_unlocked = VoucherUnlocked::where('user_id', $user)
            ->where('voucher_id', $vouchers1->id)->first();
        $member = Member::where('user_id', $user)->first();

        // dd($member->total_bonus_points);
        if (!$voucher_unlocked || !$voucher_unlocked->unlocked) {

            if ($vouchers1->poin > 0 && $member->current_bonus_points < $vouchers1->poin) {
                return redirect()->back()->with('error', 'Số điểm của bạn không đủ để đổi mã giảm giá. ');
            }
            if ($vouchers1->poin > 0) {
                $voucherUnlocked = VoucherUnlocked::updateOrCreate(
                    ['user_id' => $user, 'voucher_id' => $vouchers1->id],
                    ['unlocked' => true, 'status' => false],
                );
                $member->current_bonus_points -= $vouchers1->poin;
                $member->save();
            }
        }
        return view('client.vouchers.vouchers-detail', compact('vouchers1'));
    }

    public function exchangePoin(Request $request)
    {
        $voucher = Voucher::where('poin', '!=', null)->where('poin', '!=', '')->where('status', 1)->paginate(12);
        $user = auth()->user();
        $unlockedVoucherIds = VoucherUnlocked::where('user_id', $user->id)->where('status', 0)->pluck('voucher_id')->toArray();
        return view('client.vouchers.exchangePoin', compact('voucher', 'unlockedVoucherIds'));
    }


    public function apllyVouchers(Request $request)
    {
        $voucher = Voucher::where('code', $request->code)->first();

        // if (session()->has('voucher')) {
        //     toastr()->warning('Bạn đã áp dụng một mã giảm giá rồi.');
        //     return back();
        // }

        if (!$voucher) {
            toastr()->error('Mã giảm giá không tồn tại');
            return back();
        }
        $now = Carbon::now();
        if ($now->isBefore($voucher->start_date)) {
            toastr()->error('Mã giảm giá chưa đến ngày sử dụng');
            return back();
        } elseif ($now->isAfter($voucher->end_date)) {
            toastr()->error('Mã giảm giá đã hết hạn');
            return back();
        }
        if ($voucher->status == 2) {
            toastr()->error('Mã giảm giá không hoạt động');
            return back();
        }
        if ($voucher->quantity == 0) {
            toastr()->error('Mã giảm giá đã hết lượt sử dụng');
            return back();
        }
        $user = auth()->user()->id;
        // level được áp mã
        if (isset($voucher->level_id)) {
            $member = Member::where('user_id', $user)->first();
            if ($voucher->level_id != $member->level_id) {
                toastr()->error('bạn không có quyền hạn sử dụng mã giảm giá này');
                return back();
            }
        }

        $userUnlocked = VoucherUnlocked::where('user_id', auth()->id())
            ->where('voucher_id', $voucher->id)
            ->first();
        if ($voucher->poin > 0 && $userUnlocked) {
            if ($userUnlocked->status == 1 && $userUnlocked) {
                toastr()->error('Bạn đã sử dụng mã giảm giá này trước đó. Vui lòng đổi mã để sử dụng lần nữa!');
                return back();
            }
        }elseif ($voucher->poin == null && !$userUnlocked) {
            $userVoucher = UserVoucher::where('user_id', $user)->where('voucher_id', $voucher->id)->first();
            if ($userVoucher && !$userUnlocked ) {
                toastr()->error('Bạn chỉ được sử dụng mã giảm giá này một lần duy nhất');
                return back();
            }
        }else {
            toastr()->error('Bạn chưa đổi mã giảm giá này!');
            return back();
        }



        //end level

        $totalPrice = $request->totalPrice;
        $discount = 0;
        $totalPriceVoucher = 0;

        if ($voucher->type == 1 && $voucher->min_order_amount == "" && $voucher->max_order_amount == "") {
            // Giảm tất cả hoá đơn theo %
            $discount = $totalPrice * ($voucher->value / 100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif (
            $voucher->type == 1 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount >= $totalPrice
            && $voucher->min_order_amount != "" && $voucher->max_order_amount != ""
        ) {
            // Giảm theo % đối với khoảng đơn hàng cụ thể
            $discount = $totalPrice * ($voucher->value / 100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 1 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount == "") {
            // Giảm theo % đối với đơn hàng trên mức tối thiểu
            $discount = $totalPrice * ($voucher->value / 100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 1 && $voucher->min_order_amount == "" && $voucher->max_order_amount >= $totalPrice) {
            // Giảm theo % đối với đơn hàng trên mức tối thiểu
            $discount = $totalPrice * ($voucher->value / 100);
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount == "" && $voucher->max_order_amount == "") {
            // Giảm tất cả hoá đơn theo giá
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount >= $totalPrice) {
            // Giảm theo giá đối với khoảng đơn hàng cụ thể
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount <= $totalPrice && $voucher->max_order_amount == "") {
            // Giảm theo giá đối với đơn hàng trên mức tối thiểu
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } elseif ($voucher->type == 2 && $voucher->min_order_amount == "" && $voucher->max_order_amount >= $totalPrice) {
            // Giảm theo giá đối với đơn hàng trên mức tối thiểu
            $discount = $voucher->value;
            $totalPriceVoucher = $totalPrice - $discount;
        } else {
            // Thông báo lỗi khi mã giảm giá không áp dụng
            if ($voucher->min_order_amount != "" && $voucher->max_order_amount != "") {
                $error = 'Mã giảm giá áp dụng cho đơn từ ' . number_format($voucher->min_order_amount, 0, ',', '.') . ' VNĐ' . ' đến ' . number_format($voucher->max_order_amount, 0, ',', '.') . ' VNĐ';
            } elseif ($voucher->min_order_amount != "") {
                $error = 'Mã giảm giá áp dụng cho đơn từ ' . number_format($voucher->min_order_amount, 0, ',', '.') . ' VNĐ';
            } elseif ($voucher->max_order_amount != "") {
                $error = 'Mã giảm giá áp dụng cho đơn không quá ' . number_format($voucher->max_order_amount, 0, ',', '.') . ' VNĐ';
            }
            toastr()->error($error);
            return back();
        }


        Session::put('voucher', [
            'code' => $voucher->code,
            'discount' => $discount,
            'totalPriceVoucher' => $totalPriceVoucher,
        ]);
        toastr()->success('Áp mã giảm giá thành công');
        return back();
    }
}

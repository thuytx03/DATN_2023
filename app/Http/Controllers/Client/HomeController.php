<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        }else {
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
    public function detail($id)
    {
        $vouchers = Voucher::query();
        $vouchers1 =    $vouchers->find($id);

        return view('client.vouchers.vouchers-detail', compact('vouchers1'));
    }
}

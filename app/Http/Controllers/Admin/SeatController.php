<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeatRequest;
use App\Models\Cinema;
use App\Models\Province;
use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $room = $query->orderBy('id', 'DESC')->get();

        foreach ($room as $seatCount) {
            $seatCount->seat_count = Seat::where('room_id', $seatCount->id)->count();

        }
        return view('admin.seats.seat.index', compact('room'));
    }

    public function store(SeatRequest $request)
    {
        $province = Province::all();
        $rooms = Room::all();

        if ($request->isMethod('POST')) {
            $vipQuantity = $request->input('vip_quantity');
            $standardQuantity = $request->input('standard_quantity');
            $coupleQuantity = $request->input('couple_quantity');
            $room_id = $request->room_id;
            $columns = 10; // Số lượng cột mỗi hàng
            $rows = range('A', 'Z'); // Mảng các chữ cái từ A đến Z

            $vipSeatsToAdd = $vipQuantity;
            $standardSeatsToAdd = $standardQuantity;
            $coupleSeatsToAdd = $coupleQuantity;

            foreach ($rows as $row) {
                for ($col = 1; $col <= $columns; $col++) {
                    if ($vipSeatsToAdd > 0) {
                        $seat = new Seat();
                        $seat->room_id = $room_id;
                        $seat->seat_type_id = 1;
                        $seat->row = $row;
                        $seat->column = $col;
                        $seat->save();
                        $vipSeatsToAdd--;
                    } elseif ($standardSeatsToAdd > 0) {
                        $seat = new Seat();
                        $seat->room_id = $room_id;
                        $seat->seat_type_id = 2;
                        $seat->row = $row;
                        $seat->column = $col;
                        $seat->save();
                        $standardSeatsToAdd--;
                    } elseif ($coupleSeatsToAdd > 0) {
                        $seat = new Seat();
                        $seat->room_id = $room_id;
                        $seat->seat_type_id = 3;
                        $seat->row = $row;
                        $seat->column = $col;
                        $seat->save();
                        $coupleSeatsToAdd--;
                    } else {
                        break; // Dừng khi số lượng ghế đã thêm đủ
                    }
                }
            }
            toastr()->success('Thành công thêm mới ghế!');
            return redirect()->back()->with('message', 'Ghế đã được thêm thành công!');
        }
        return view('admin.seats.seat.add', compact('province'));
    }

    public function update(SeatRequest $request, $room_id)
    {
        // Lấy thông tin về các ghế của phòng
        $seats = Seat::where('room_id', $room_id)->get();

        if ($request->isMethod('POST')) {
            // Xác định số hàng và số cột
            $columns = 10; // Số lượng cột mỗi hàng
            $rows = range('A', 'Z'); // Mảng các chữ cái từ A đến Z

            // Xác thực số lượng ghế theo loại
            $vipQuantity = max(0, (int)$request->input('vip_quantity'));
            $standardQuantity = max(0, (int)$request->input('standard_quantity'));
            $coupleQuantity = max(0, (int)$request->input('couple_quantity'));

            // Tính toán số lượng ghế ban đầu theo từng loại
            $vipSeatsCount = $seats->where('seat_type_id', 1)->count();
            $standardSeatsCount = $seats->where('seat_type_id', 2)->count();
            $coupleSeatsCount = $seats->where('seat_type_id', 3)->count();

            // Tính toán sự thay đổi yêu cầu về số lượng ghế
            $vipQuantityChange = $vipQuantity - $vipSeatsCount;
            $standardQuantityChange = $standardQuantity - $standardSeatsCount;
            $coupleQuantityChange = $coupleQuantity - $coupleSeatsCount;

            // Xác định xem có đủ ghế để đáp ứng sự thay đổi không
            $totalChange = $vipQuantityChange + $standardQuantityChange + $coupleQuantityChange;

            if ($totalChange > 0) {
                // Kiểm tra xem có đủ ghế trống để thêm mới
                $availableSeatsCount = $columns * count($rows);
                if ($totalChange > $availableSeatsCount) {
                    toastr()->error('Không đủ ghế để cập nhật yêu cầu!');
                    return redirect()->back();
                }

                // Tìm hàng đầu tiên có ghế trống
                $startRow = '';
                foreach ($rows as $row) {
                    $seatCountInRow = $seats->where('row', $row)->count();
                    if ($seatCountInRow < $columns) {
                        $startRow = $row;
                        break;
                    }
                }

                if ($startRow === '') {
                    toastr()->error('Không đủ ghế để cập nhật yêu cầu!');
                    return redirect()->back();
                }

                $rowIndex = array_search($startRow, $rows);
                $columnIndex = 1;

                // Thêm ghế cho từng loại
                foreach (['vip', 'standard', 'couple'] as $type) {
                    $quantityToAdd = ${$type . 'QuantityChange'};
                    if ($quantityToAdd > 0) {
                        for ($i = 0; $i < $quantityToAdd; $i++) {
                            if ($columnIndex > $columns) {
                                $columnIndex = 1;
                                $rowIndex++;
                            }

                            // Kiểm tra xem có cần chuyển sang hàng tiếp theo không
                            if ($rowIndex >= count($rows)) {
                                toastr()->error('Không đủ ghế để cập nhật yêu cầu!');
                                return redirect()->back();
                            }

                            Seat::create([
                                'room_id' => $room_id,
                                'row' => $rows[$rowIndex],
                                'column' => $columnIndex,
                                'seat_type_id' => ($type === 'vip') ? 1 : (($type === 'standard') ? 2 : 3),
                            ]);

                            $columnIndex++;
                        }
                    }
                }

                toastr()->success('Cập nhật ghế thành công!');
            } elseif ($totalChange < 0) {
                // Loại bỏ ghế cho từng loại
                foreach (['vip', 'standard', 'couple'] as $type) {
                    $quantityToRemove = abs(${$type . 'QuantityChange'});
                    if ($quantityToRemove > 0) {
                        $seatsOfType = $seats->where('seat_type_id', ($type === 'vip') ? 1 : (($type === 'standard') ? 2 : 3));
                        $seatsToRemove = $seatsOfType->sortByDesc('row')->take($quantityToRemove);

                        foreach ($seatsToRemove as $seat) {
                            $seat->delete(); // Xoá bản ghi ghế
                        }
                    }
                }

                toastr()->success('Cập nhật ghế thành công!');
            }

            return redirect()->route('seat.index');
        }

        // Tải thông tin về các ghế trong phòng và loại ghế của chúng
        $seats = Seat::where('room_id', $room_id)->get();
        $vipSeatsCount = $seats->where('seat_type_id', 1)->count();
        $standardSeatsCount = $seats->where('seat_type_id', 2)->count();
        $coupleSeatsCount = $seats->where('seat_type_id', 3)->count();

        return view('admin.seats.seat.edit', compact('seats', 'vipSeatsCount', 'standardSeatsCount', 'coupleSeatsCount'));
    }

    function destroy($roomId) {
        $seat=Seat::where('room_id', $roomId)->delete();
        if($seat){
            toastr()->success('Cập nhật ghế thành công!');

        }else{
            toastr()->warning('Cập nhật ghế thất bại!');

        }
        return redirect()->route('seat.index');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        if ($ids) {
            Seat::whereIn('room_id', $ids)->delete();
            toastr()->success('Thành công xoá các ghế đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các ghế đã chọn');
        }
    }

    public function getCinemas($provinceId)
    {
        $cinemas = Cinema::where('province_id', $provinceId)->get();
        return response()->json($cinemas);
    }
  

    public function getRooms($cinemaId)
    {
        $rooms = Room::where('cinema_id', $cinemaId)->get();

        $roomsWithoutSeats = Room::whereNotIn('id', function ($query) {
            $query->select('room_id')->from('seats');
        })->where('cinema_id', $cinemaId)->get();

        return response()->json($roomsWithoutSeats);
    }
}

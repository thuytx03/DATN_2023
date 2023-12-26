<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeatRequest;
use App\Models\Cinema;
use App\Models\Province;
use App\Models\RoleHasCinema;
use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh|Staff-Seat-Hanoi|Staff-Seat-HaiPhong|Staff-Seat-ThaiBinh|Staff-Seat-NamDinh|Staff-Seat-NinhBinh', ['only' => $methods]);
    }
    public function index(Request $request)
    {
        $user = auth()->user();
        $roles = $user->roles()->pluck('id')->toArray();
        $isAdmin = in_array('Admin', $user->getRoleNames()->toArray());

        $query = Room::query();

        // If the user is not an admin, filter rooms by cinema
        if (!$isAdmin) {
            $userCinemas = RoleHasCinema::whereIn('role_id', $roles)->pluck('cinema_id')->toArray();
            $query->whereIn('cinema_id', $userCinemas);
        }

        // Apply search and status filters
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }

        // Get rooms and their seat counts
        $rooms = $query->withCount('seats')->orderBy('id', 'DESC')->get();

        foreach ($rooms as $room) {
            $room->seat_count = Seat::where('room_id', $room->id)->count();
        }

        return view('admin.seats.seat.index', compact('rooms'));
    }


    public function store(Request $request)
    {

        $user = auth()->user();
        $isAdmin = $user->hasRole('Admin');

        $province = $rooms = [];

        if ($isAdmin) {
            // Nếu người dùng là Admin, hiển thị tất cả thông tin
            $province = Province::all();
            $rooms = Room::all();
        } else {
            // Nếu không phải là Admin, lấy thông tin dựa trên quyền của người dùng
            $cinemaIds = RoleHasCinema::whereIn('role_id', $user->roles()->pluck('id'))->pluck('cinema_id')->toArray();

            // Lấy thông tin tỉnh dựa trên các cinema_id của người dùng
            $province = Province::whereIn('id', function ($query) use ($cinemaIds) {
                $query->select('province_id')->from('cinemas')->whereIn('id', $cinemaIds);
            })->get();

            // Lấy thông tin phòng dựa trên các cinema_id của người dùng
            $rooms = Room::whereIn('cinema_id', $cinemaIds)->get();
        }

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
                    if ($standardSeatsToAdd > 0) {
                        $seat = new Seat();
                        $seat->room_id = $room_id;
                        $seat->seat_type_id = 1;
                        $seat->row = $row;
                        $seat->column = $col;
                        $seat->save();
                        $standardSeatsToAdd--;
                    } elseif ($vipSeatsToAdd > 0) {
                        $seat = new Seat();
                        $seat->room_id = $room_id;
                        $seat->seat_type_id = 2;
                        $seat->row = $row;
                        $seat->column = $col;
                        $seat->save();
                        $vipSeatsToAdd--;
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

    public function update(Request $request, $room_id)
    {
        $user = auth()->user();

        // Kiểm tra xem người dùng có vai trò là Admin không
        if ($user->hasRole('Admin')) {
            // Nếu là Admin, không áp dụng bất kỳ ràng buộc nào với cinema_id
            $room = Room::find($room_id);
        } else {
            // Nếu không phải Admin, kiểm tra xem room_id thuộc các phòng mà người dùng có quyền truy cập hay không
            $cinemaIds = RoleHasCinema::whereIn('role_id', $user->roles()->pluck('id'))->pluck('cinema_id')->toArray();
            $room = Room::whereIn('cinema_id', $cinemaIds)->find($room_id);
        }

        if (!$room) {
            toastr()->error('Bạn không có quyền truy cập vào phòng này!');
            return redirect()->route('seat.index');
        }
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

    public function destroy($roomId)
{
    $user = auth()->user();

    // Kiểm tra vai trò của người dùng
    if ($user->hasRole('Admin')) {
        // Nếu là Admin, không áp dụng bất kỳ ràng buộc nào với việc xóa ghế
        $seatsDeleted = Seat::where('room_id', $roomId)->delete();
    } else {
        // Nếu không phải Admin, kiểm tra xem room_id thuộc các phòng mà người dùng có quyền truy cập hay không
        $cinemaIds = RoleHasCinema::whereIn('role_id', $user->roles()->pluck('id'))->pluck('cinema_id')->toArray();
        $room = Room::whereIn('cinema_id', $cinemaIds)->find($roomId);

        if (!$room) {
            toastr()->error('Bạn không có quyền xóa ghế trong phòng này!');
            return redirect()->route('seat.index');
        }

        // Xóa các ghế của phòng
        $seatsDeleted = Seat::where('room_id', $roomId)->delete();
    }

    if ($seatsDeleted) {
        toastr()->success('Xóa ghế thành công!');
    } else {
        toastr()->warning('Không có ghế để xóa hoặc xảy ra lỗi khi xóa ghế!');
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

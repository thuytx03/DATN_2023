<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Cinema extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    public $table = 'cinemas';
    public $fillable = ['name', 'slug', 'address', 'phone', 'open_hours', 'close_hours', 'description', 'status', 'province_id'];

    public function checkAndSetStatus()
    {
        $now = Carbon::now();
        // Kiểm tra nếu ngày hiện tại vượt qua end_date
        if ($now > $this->end_date) {
            $this->status = 3; // Cập nhật trạng thái thành 3 (hết hạn)
            $this->save(); // Lưu thay đổi vào cơ sở dữ liệu
        }
        if ($this->quantity == 0) {
            $this->status = 4; // Cập nhật trạng thái thành 4 (hết vé)
            $this->save();
        }
    }
    public function checkAndUpdateStatus()
    {
        $now = Carbon::now();
        // Kiểm tra nếu ngày hiện tại vượt qua end_date
        if ($now > $this->end_date) {
            $this->status = 3; // Cập nhật trạng thái thành 3 (hết hạn)
            $this->save(); // Lưu thay đổi vào cơ sở dữ liệu
        }else{
            $this->status = 1;
            $this->save();
        }
        if ($this->quantity == 0) {
            $this->status = 4; // Cập nhật trạng thái thành 4 (hết vé)
            $this->save();
        }else{
            $this->status = 1;
            $this->save();
        }
    }
}

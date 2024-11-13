<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'User'; // Tên bảng trong cơ sở dữ liệu
    public $timestamps = false; // Nếu không dùng cột `created_at` và `updated_at`
}

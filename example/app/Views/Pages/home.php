<?php
use App\Models\User;
$users = User::all();
// Hiển thị dữ liệu
foreach ($users as $user) {
    echo $user->username; // Giả sử có cột name trong bảng users
}

<?php
require_once "Config/database.php";
// gọi service provider
use App\Services\ServiceProvider;

// Lấy các service
$services = ServiceProvider::getServices();

// Sử dụng dragonballService
$dragonballs = $services['dragonballService']->getALL(); 

// sử dụng userService
$dataLogin = $services['userService']->login([
    'username' => 'emilys',
    'password' => 'emilyspass'
]);

print_r($dataLogin);





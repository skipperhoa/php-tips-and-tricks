<?php

namespace App\Services;
use Symfony\Component\HttpClient\HttpClient;

// Chúng ta gọi các service ở đây 
use App\Services\DragonballService;
use App\Services\UserService;

// Xuất các lớp
class ServiceProvider {
    private static $client;

    public static function initialize() {
        self::$client = HttpClient::create(['verify_peer' => false, 'verify_host' => false]);
    }

    /** setup các service */

    public static function getUserService() {
        return new UserService(self::$client);
    }

    public static function getDragonballService() {
        return new DragonballService(self::$client);
    }
    // Xuất tất cả các service
    public static function getServices() {
        return [
            'userService' => self::getUserService(),
            'dragonballService' => self::getDragonballService(),
        ];
    }

    
}
// Đảm bảo gọi initialize trước khi sử dụng
ServiceProvider::initialize();



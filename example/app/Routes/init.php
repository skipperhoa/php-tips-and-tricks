<?php 
namespace App\Routing;

/**
 * @method static \Illuminate\Routing\Route get(string $uri, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route post(string $uri, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route put(string $uri, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route patch(string $uri, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route delete(string $uri, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route options(string $uri, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route any(string $uri, array|string|callable|null $action = null)
 */
class MyRouter
{
    /**
     * Đăng ký route GET mới
     *
     * @param  string $uri
     * @param  array|string|callable|null $action
     * @return \Illuminate\Routing\Route
     */

     // http://localhost:8000/lap-trinh-laravel-1 
     
    public function get(string $uri, array|string|callable|null $action = null)
    {
        // Gọi phương thức get gốc của Laravel để đăng ký route
        
    }

    // Bạn có thể thêm các phương thức khác như post, put, delete, v.v...
}

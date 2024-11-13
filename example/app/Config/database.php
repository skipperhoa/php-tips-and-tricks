<?php 
require __DIR__.'/../../../vendor/autoload.php'; // Ensure Composer autoload is required
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$capsule = new Capsule;
$host = 'db';  // Tên dịch vụ MySQL trong Docker Compose
$db_name = 'db_hoanguyencoder';  // Tên cơ sở dữ liệu
$username = 'hoanguyencoder';  // Tên người dùng
$password = '12345678';  // Mật khẩu
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $host,
    'database'  => $db_name,
    'username'  => $username,
    'password'  => $password,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();


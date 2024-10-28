<?php
require '../../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
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
// get users
$user_count = Capsule::table('User')->count(); 
$users = Capsule::table('User')->where('id', 1)->get();
$results = Capsule::select('select * from User where id = ?', [1]);
$result_row = Capsule::table('User')->pluck('id', 'username');

Capsule::table('User')->orderBy('id')->chunk(100, function (Collection $users) {
    foreach ($users as $user) {
        echo $user->username . "<br>";
    }
});
$users_with_alias = Capsule::table('User')
            ->select('username', 'email as user_email')
            ->get();
$users_with_join_post = Capsule::table('User')
            ->join('Post', 'User.id', '=', 'Post.user_id')
            ->get();
            
var_dump($users, $results, $result_row, $users_with_alias, $users_with_join_post);

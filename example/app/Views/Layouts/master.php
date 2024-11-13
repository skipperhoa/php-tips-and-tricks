<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoa Nguyen Coder</title>
</head>
<body>
<?php 
    // Định nghĩa các trang hợp lệ
    $allowed_pages = ['home', 'category', 'post', 'about', 'contact', '404'];

    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    // Kiểm tra và gán giá trị '404' nếu `$page` không hợp lệ
    $page = in_array($page, $allowed_pages) ? $page : '404';
    //header
    include_once "Views/Blocks/header.php";

    $result = match ($page) {
        'home' => include_and_capture("Views/Pages/home.php"),

        'category' => include_and_capture("Views/Pages/category.php"),

        'post' => include_and_capture("Views/Pages/post.php"),

        'about', 'contact' => include_and_capture("Views/Pages/about.php"),

        '404' => include_and_capture("Views/Pages/404.php"),
        
        default => 'Trang không tồn tại',
    };
    echo $result;

    //footer
    include_once "Views/Blocks/footer.php";

    // Hàm tùy chỉnh để lấy nội dung của tệp
    function include_and_capture($file) {
        
        if (file_exists($file)) {
            ob_start(); 
            include $file;
            return ob_get_clean();
        } else {
            return "File not found: $file";
        }
    }
?>
</body>
</html>
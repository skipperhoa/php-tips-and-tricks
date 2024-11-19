<?php 
/* Install:  composer require symfony/cache  */
require '../../vendor/autoload.php';
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
$cache = new FilesystemAdapter();
$cacheKey = 'news.latest_123';
$latestNews = $cache->getItem($cacheKey);
// Nếu isHit() trả về true: Điều này có nghĩa là mục cache đã được lưu trước đó 
// và vẫn còn hợp lệ (chưa hết hạn)
if (!$latestNews->isHit()) {
    $news = "Hoa Nguyen Coder";
    echo "Đang lưu vào cache...\n";  
    // 60 seconds = 1 minute
    $latestNews->expiresAfter(60); 
    $latestNews->set($news);
    $cache->save( $latestNews);
} else {
    $news = $latestNews->get();
}

echo $news."\n"; 

// hoặc dùng cách này
$value = $cache->get($cacheKey, function (ItemInterface $item): string {
    echo "Đang lưu vào cache...\n";  
    $item->expiresAfter(60);

    $computedValue = 'Hoa Nguyen Coder';

    return $computedValue;
}); 


echo $value."\n"; 





?>
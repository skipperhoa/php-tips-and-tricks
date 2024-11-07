
<?php

class SlugHelper
{
    public static function slug($title, $separator = '-', $language = 'en', $dictionary = ['@' => 'at'])
    {
        $title = $language ? static::ascii($title, $language) : $title;
        
        // Convert all dashes/underscores into separator
        $flip = $separator === '-' ? '_' : '-';
        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

        // Thay thế các từ trong từ điển (dictionary)
        foreach ($dictionary as $key => $value) {
            $dictionary[$key] = $separator . $value . $separator;
        }
        $title = str_replace(array_keys($dictionary), array_values($dictionary), $title);

        // loại bỏ các ký tự không hợp lệ, như dấu câu, ký tự đặc biệt, chỉ giữ lại chữ cái, 
        // chữ số, dấu phân cách (separator) và khoảng trắng
        $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', strtolower($title));

        // các dấu phân cách và khoảng trắng liên tiếp sẽ được thay thế bằng một dấu phân cách duy nhất
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);
        
       // trim : loại bỏ các dấu phân cách thừa ở đầu và cuối chuỗi
        return trim($title, $separator);
    }

    private static function ascii($title, $language)
    {
        if ($language == 'vi') {
            // Bảng chuyển đổi dấu tiếng Việt thành không dấu
            $replacements = [
                'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
                'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
                'â' => 'a', 'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
                'é' => 'e', 'è' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
                'ê' => 'e', 'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
                'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
                'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
                'ô' => 'o', 'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
                'ơ' => 'o', 'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
                'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
                'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
                'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
                'đ' => 'd', // Chú ý, 'đ' trong tiếng Việt sẽ được chuyển thành 'd'
                'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
            ];

            // Thay thế ký tự có dấu bằng không dấu
            $title = strtr($title, $replacements);
        }

        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title);
    }
}

	$array_title = array(
	  "Hướng dẫn lập trình web cơ bản!",
	  "Học ngôn ngữ lập trình Laravel 10",
	  "Học về Asp.net core 2",
	  'Học về "Laravel-10"',
	  'Học về "Laravel 11"',
	  "Hướng  __   dẫn   __ lập    trình   web    cơ   bản!",
	  "Hướng  --   dẫn ---   lập  --  trình  -- web   -- cơ  -- bản!",
	  );
	  
	foreach($array_title as $title){
	  echo SlugHelper::slug($title,'-','en')."\n";
	}



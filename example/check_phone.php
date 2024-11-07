<?php
$array_number_phone = array(
    "0961234567", // Viettel
    "0977654321", // Viettel
    "+84981234567", // Viettel (quốc tế)
    "+14155552671", // Mỹ (quốc tế)
    "0033123456789", // Pháp (quốc tế)
    "+447911123456", // Anh (quốc tế)
    "0862345678", // Viettel
    "0912345678", // Vinaphone
    "0948765432", // Vinaphone
    "+61412345678" // Úc (quốc tế)
);

$_GET['contry'] = 'default'; // Ví dụ :  mình tự đặt giá trị 
$contry = (isset($_GET['contry']) && trim($_GET['contry'])!="")?$_GET['contry']:'default';

$pattern = match ($contry) {
	'vietnam'=>"/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/",
	
	'quocte' =>"/^(\+|00)[1-9][0-9]{1,3}[0-9]{4,14}$/",
	
	default => "/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$|^(\+|00)[1-9][0-9]{1,3}[0-9]{4,14}$/",
};
echo $pattern;
$results = array_map(function ($value) use ($pattern) {
	
    return preg_match($pattern, $value) ? true : false;
    
}, $array_number_phone);

var_dump($results);

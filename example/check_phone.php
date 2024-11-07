<?php
$array_number_phone = array(
    /** list phone */
);

$_GET['contry'] = 'default'; 

$contry = (isset($_GET['contry']) && trim($_GET['contry'])!="")?$_GET['contry']:'default';

$pattern = match ($contry) {

	'vietnam'=>"/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/",
	
	'quocte' =>"/^(\+|00)[1-9][0-9]{1,3}[0-9]{4,14}$/",
	
	default => "/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$|^(\+|00)[1-9][0-9]{1,3}[0-9]{4,14}$/",
};
$results = array_map(function ($value) use ($pattern) {
	
    return preg_match($pattern, $value) ? true : false;
    
}, $array_number_phone);

var_dump($results);

?>

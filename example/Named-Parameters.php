<?php

//Named Parameters: bạn có thể thay đổi thứ tự của các tham số, 
//miễn là bạn chỉ định tên của tham số đúng với tên trong định nghĩa của hàm


//Example 1: 
function createUser($name, $role = 'user', $isActive = true) {
    
    echo $name."-".$role;
}

createUser(name: 'Hòa Nguyễn', isActive: false, role:"admin");




//Example 2:
class CartService{
	
	public function add(int $id, string $title, bool $isActive = true) : string {
		return "$id, $title đã được thêm vào giỏ hàng";
	}
}

$cart = new CartService;
echo $cart->add(1, "Phone", true)."\n";
echo $cart->add(id: 2, isActive: true, title: "hoa")."\n";





//Example 3:
function sendEmail(string $from, string $to, string $subject, string $message,
 bool $isHtml = false) {
    echo "From: $from\n";
    echo "To: $to\n";
    echo "Subject: $subject\n";
    echo "Message: $message\n";
    echo "Is HTML: " . ($isHtml ? 'Yes' : 'No') . "\n";
}

//Gọi hàm với Named Arguments
sendEmail(
	from: "hoanguyen@example.com",
	to: "recipient@example.com", 
	message: "This is a test email. Hòa Nguyễn Coder", 
	subject: "Hòa Nguyễn Coder", 
	isHtml: true);


/// Example 4
	function addProductToCart($id, $name, $quantity = 1, $price = 0) {
		echo "Sản phẩm: $name (ID: $id), Số lượng: $quantity, Giá: $price\n";
	}
	function updateProductInCart($id, $name = null, $quantity = null, $price = null) {
	    echo "Cập nhật sản phẩm ID: $id\n";
	    if ($name !== null) {
	        echo "- Tên mới: $name\n";
	    }
	    if ($quantity !== null) {
	        echo "- Số lượng mới: $quantity\n";
	    }
	    if ($price !== null) {
	        echo "- Giá mới: $price\n";
	    }
	    echo "Cập nhật thành công!\n";
	}
	
	// Object không theo thứ tự của function
	$product = (object) [
		'name' => 'Laptop',
		'id' => 101,
		'price' => 1500,
		'quantity' => 2
	];
	
	// Sử dụng Named Parameters để thêm sản phẩm vào giỏ hàng
	addProductToCart(
		id: $product->id,
		name: $product->name,
		price: $product->price,
		quantity: $product->quantity
	);

	// Object thông tin cần update
	$updateData = (object) [
		'id' => 101,
		'quantity' => 5, // Chỉ thay đổi số lượng
		'price' => 1800   // Và giá
	];

	// Sử dụng Named Parameters để cập nhật sản phẩm
	updateProductInCart(
		id: $updateData->id,
		quantity: $updateData->quantity,
		price: $updateData->price
	);


	
	
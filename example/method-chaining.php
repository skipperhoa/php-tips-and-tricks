<?php
/* 
Method Chaining in PHP
*/
class Car {
    private $color;
    private $model;
    private $year;
    public function setColor($color) {
        $this->color = $color;
        return $this; // Trả về đối tượng hiện tại để tiếp tục chuỗi phương thức
    }

    public function setModel($model) {
        $this->model = $model;
        return $this; // Trả về đối tượng hiện tại
    }

    public function setYear($year) {
        $this->year = $year;
        return $this; // Trả về đối tượng hiện tại
    }
    public function getColor() {
        return $this->color; // Trả về màu sắc
    }

    public function getModel() {
        return $this->model; // Trả về mẫu xe
    }

    public function getYear() {
        return $this->year; // Trả về năm sản xuất
    }
}


$car = new Car();

$car->setColor('red')->setModel('Sedan')->setYear(2023);

echo "Car Model: " . $car->getModel() . ", Color: " . $car->getColor() . ", Year: " . $car->getYear();



?>
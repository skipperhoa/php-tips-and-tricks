<?php
require_once "../Config/database.php";

$capsule::schema()->create('comments', function ($table) {
    $table->increments('id');
    $table->string('content')->unique();
    $table->timestamps();
});

?>
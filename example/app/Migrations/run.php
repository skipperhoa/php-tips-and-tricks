<?php 

    //create datablase
    try {
        require_once "../Schema/init.php";
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

?>

<?php
//echo "Hello"

require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');

$query = "DELETE FROM kursantet";
    if(mysqli_query($link, $query)){
        echo "U fshine";
    }else{
        echo "Su fshine";
    }
?>
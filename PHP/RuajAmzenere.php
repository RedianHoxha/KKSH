<?php
    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

    $id= test_input(mysqli_real_escape_string( $link,$_POST['id-txt']));
    $amza= test_input(mysqli_real_escape_string( $link,$_POST['amza-txt']));
    $seria=test_input( mysqli_real_escape_string( $link,$_POST['deshmi-txt']));

    $vendosamzen = "update kursant set Amza= '$amza', NrSerisDeshmis = '$seria', Statusi= 'perfunduar' where ID = '$id'";
    
    if($runupdetin  =mysqli_query($link, $vendosamzen))
    {
        $quryupdetostatusinkursantit = "update organizimkursantesh set statusi = 'Perfunduar' where  idkursanti = '$id';";
        mysqli_query($link, $quryupdetostatusinkursantit);
        header('location: ../confirm/confirmpage.php');
    }
    else
    {
        echo "<script>
        alert('Something went wrong! Try again!');
        window.location.href='../confirm/confirmpage.php';
        </script>";
    }
?>
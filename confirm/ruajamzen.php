<?php
//$link = mysqli_connect("localhost", "root", "", "kksh");
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
if (!$link) {
  die('Could not connect: ' . mysqli_error($con));
}

$idkusanti = encryptValues($_GET['id']);
$amza = encryptValues($_GET['amza']);
$seri = encryptValues($_GET['seri']);

$statusi = 'perfunduar';

if($amza == '' && $seri == ''){
    $statusi = 'Munges';
}


$vendosamzen = "UPDATE kursantet SET Amza= '$amza', NrSerisDeshmis = '$seri', Statusi= '$statusi' WHERE PersonalId = '$idkusanti' and Statusi = 'pabere'";
if($runupdetin = mysqli_query($link, $vendosamzen)){
    $quryupdetostatusinkursantit = "UPDATE organizimkursantesh1 SET statusi = '$statusi' WHERE  idkursanti = '$idkusanti' and statusi = 'pabere';";
    if(mysqli_query($link, $quryupdetostatusinkursantit)){
        echo "Me sukses ";
    }else{
        echo "<script>
        alert('Something went wrong douring change status! Try again!');
        window.location.href='../confirm/confirmpage.php';
        </script>";
    }
}else{
    echo "<script>
    alert('Something went wrong! Try again!');
    window.location.href='../confirm/confirmpage.php';
    </script>";
}

?>
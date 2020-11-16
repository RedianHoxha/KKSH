<?php

    $link = mysqli_connect("localhost", "root", "", "kksh");

    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $emri= mysqli_real_escape_string( $link,$_POST['emri-txt']);
    $mbiemri= mysqli_real_escape_string( $link,$_POST['mbiemri-txt']);
    $atesia= mysqli_real_escape_string( $link,$_POST['atesia-txt']);
    $id= mysqli_real_escape_string( $link,$_POST['id-txt']);
    $datelindja= mysqli_real_escape_string( $link,$_POST['datelindja-txt']);
    $vendbanim= mysqli_real_escape_string( $link,$_POST['vendbanim-txt']);
    $tel= mysqli_real_escape_string( $link,$_POST['tel-txt']);
    $dega= mysqli_real_escape_string( $link,$_POST['dega']);
    $datakursit= mysqli_real_escape_string( $link,$_POST['datakursit']);
    $orari= mysqli_real_escape_string( $link,$_POST['orari']);

    $shtokursant = "insert into kursant(ID,Emri,Mbiemri,Atesia,Datelindja,Vendbanimi,Telefoni,Dega,Datakursit,Orari)
    values ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$dega', '$datakursit','$orari');";
    //echo $shtokursant;
    
    if($resultinsert = mysqli_query($link, $shtokursant))
    {
       header('location:../HTML/Inputerpage.php');
    }
    else
    {
       echo "Dicka shkoi gabim ne rregjistrimine kursantit!";
    }

   //echo gettype($tel);
   //  echo gettype($datakursit);
   //  $shtokursant = "insert into kursant(ID,Emri,Mbiemri,Atesia,Datelindja,Vendbanimi,Telefoni,Dega,Datakursit,Orari)
   //   values ( ?,?,?,?,?,?,?,?,?,?);";
   //   //echo $shtokursant;
   //   $stmt = mysqli_stmt_init($link);
   //    if(!mysqli_stmt_prepare($stmt,$shtokursant))
   //    {
   //       echo  'Prove e deshtuar';
   //    }
   //    else
   //    {
   //       mysqli_stmt_bind_param($stmt, "ssssssssss" ,$id,$emri,$mbiemri,$atesia,$datelindja,$vendbanim,$tel,$dega,$datakursit,$orari);
   //       mysqli_stmt_execute($stmt);
   //        //$result = mysqli_stmt_get_result($stmt);
   //        //$row =mysqli_fetch_assoc($result);
   //        //echo $result;
   //        //$rreshta =  mysqli_num_rows($result);
         
   //          if(!mysqli_stmt_execute($stmt))
   //          {
   //             header('location:../PHP/Inputerpage.php');
   //          }
   //          else
   //          {
   //             echo "Dicka shkoi gabim ne rregjistrimine kursantit!";
   //          }
   //    }



?>
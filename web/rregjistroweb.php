<?php
require_once('../php/extra_function.php');
    $link = mysqli_connect("localhost", "root", "", "kksh");
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $emri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['name'])));
    $mbiemri= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['surname'])));
    $datelindja= test_input(mysqli_real_escape_string( $link,$_POST['bday']));
    $atesia= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['father'])));
    $id= encryptValues(test_input( mysqli_real_escape_string( $link,$_POST['id'])));
    $email= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['email'])));
    $tel= test_input(mysqli_real_escape_string( $link,$_POST['phone']));
    $paymentnumber= test_input(mysqli_real_escape_string( $link,$_POST['paymentnumber']));
    $vendbanim= encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['adress'])));
    $qyteti= test_input(mysqli_real_escape_string( $link,$_POST['city']));
    $datakursit= test_input( mysqli_real_escape_string( $link,$_POST['datakursit']));
    if(isset($_POST['select']))
    {
      if(isset($_POST["g-recaptcha-response"]))
      {
        $captcha_error = '';
        
        if(empty($_POST['g-recaptcha-response']))
        {
          $captcha_error = 'Captcha is required';
        }
        else
        {
          $secret_key = '6LfwjbwdAAAAACdTuLJYmkk17zwmu0wdyoP1FTS4';
        
          $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

          $response_data = json_decode($response);

          if(!$response_data->success)
          {
            $captcha_error = 'Captcha verification failed';
          }
        }

        if($captcha_error == '')
        {
            $idkursi= test_input( mysqli_real_escape_string( $link,$_POST['select']));
            $querymerrtedhena = "SELECT * FROM programijavor WHERE idkursi = $idkursi;";
            $resulttedhenash = mysqli_query($link, $querymerrtedhena);
            $rowtedhena = mysqli_fetch_array($resulttedhenash);
            $idklase = $rowtedhena['idklase'];
            $orari = $rowtedhena['orari'];
      
            $sqlurlqyteti = "SELECT * FROM `qyteti` where EmriDeges = '$qyteti';";
            $resultsqlurlqyteti = mysqli_query($link, $sqlurlqyteti);
            $row = mysqli_fetch_array($resultsqlurlqyteti);
            $url = $row['Adresa'];
            $idQyteti = $row['IDQyteti'];

            $shtokursant = "insert into kursantet(PersonalID, Emri, Mbiemri, Atesia, Datelindja, Vendbanimi,Telefoni, Dega, Datakursit, Orari, Email, BankPayment, Statusi)
            values ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$idQyteti', '$datakursit','$orari','$email','$paymentnumber','pabere');";
            
            if($resultinsert = mysqli_query($link, $shtokursant))
            {
              $quryshto = "insert into organizimkursantesh1(idkursi, idkursanti,statusi ) values ('$idkursi','$id', 'pabere');";
              $resultorganizim = mysqli_query($link, $quryshto);
              if($resultorganizim == 1)
              {
                $data = array(
                  'success'  => true,
                  'datakursit' => $datakursit,
                  'orari' => $orari,
                  'url' => $url
                  );
              }
              else
              {
                echo "<script>
                alert('Something went wrong11! Try again!');
                window.location.href='webpage.php';
                </script>";
              }
            }
            else
            {
              echo "<script>
              alert('Something went wrongw222! Try again!');
              window.location.href='webpage.php';
              </script>";
            } 

        }
        else
        {
          $data = array(
          'success'  => false,
          'captcha_error'  => $captcha_error
          );
        }
        echo json_encode($data);
      }
    }
    else
    {
      $data = array(
        'success'  => false,
        'selected_error'  => 'Ploteso kalendarin'
        );

        echo json_encode($data);
    }
?>
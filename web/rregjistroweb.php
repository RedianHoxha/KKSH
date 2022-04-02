<?php
require_once('../php/extra_function.php');
include('../authenticate/dbconnection.php');
    //$link = mysqli_connect("localhost", "root", "", "kksh");
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $now = date('Y-m-d');

if(isset($_POST["name"]))
{
    $emri='';
    $mbiemri='';
    $datelindja='';
    $atesia='';
    $id='';
    $email='';
    $tel='';
    $paymentnumber='';
    $vendbanim='';
    $qyteti='';
    $datakursit='';
    $gjinia='';
    $idkursi='';
    $bank='';

    $emri_error='';
    $mbiemri_error='';
    $gjinia_error='';
    $personalid_error='';
    $datelindje_error='';
    $atesia_error='';
    $email_error='';
    $tel_error='';
    $adresa_error='';
    $referenca_error='';
    $qyteti_error='';
    $datakursit_error='';
    $select_error='';
    $bank_error='';
    $captcha_error='';
    
  $patternId = "/[A-Z]\d{8}[A-Z]$/";
  $patternbank="";

 if(empty($_POST["name"]))
 {
  $emri_error = 'First name is required';
 }
 else
 {
  $emri = encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['name'])));
 }

 if(empty($_POST["surname"]))
 {
  $mbiemri_error = 'Last name is required';
 }
 else
 {
  $mbiemri = encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['surname'])));
 }

 if(empty($_POST["bday"]))
 {
  $datelindje_error = 'Birthday is required';
 }
 else
 {
  $datelindja = test_input(mysqli_real_escape_string( $link,$_POST['bday']));
 }

 if(empty($_POST["father"]))
 {
  $atesia_error = 'Your father name is required';
 }
 else
 {
  $atesia = encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['father'])));
 }

 if(empty($_POST["id"]))
 {
  $personalid_error = 'Personal Id is required';
 }
 else
 {
   if(preg_match($patternId, $_POST["id"])){
    $id = encryptValues(test_input( mysqli_real_escape_string( $link,$_POST['id'])));
   }else{
    $personalid_error = 'Invalid Personal Id';
   }
 }

 if(empty($_POST["email"]))
 {
  $email_error = 'Email is required';
 }
 else
 {
  if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
  {
   $email_error = 'Invalid Email';
  }
  else
  {
   $email =  encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['email'])));
  }
 }

 if(empty($_POST["phone"]))
 {
  $tel_error = 'Phone Number is required';
 }
 else
 {
   if(strlen($_POST["phone"])== 10){
    $tel = test_input(mysqli_real_escape_string( $link,$_POST['phone']));
   }else{
    $tel_error = 'Invalid Phone Number';
   }
 }


 if(empty($_POST["my_select_box"])){
  $bank_error = 'Choose a Bank to see Reference Number Format';
  $referenca_error = 'Payment Number is required';
 }else{
  if(empty($_POST["paymentnumber"]))
  {
   $referenca_error = 'Payment Number is required';
  }
  else
  {
    switch ($_POST["my_select_box"])
    {
        case "../Images/credinsbank.jpeg":
          $patternbank="/\d{15}-\d{3}$/";
          break;

        case "../Images/tiranabank.jpegg":
          $patternbank="/\d{15}$/";
          break;

        case "../Images/bkt.jpeg":
          $patternbank="/\d{3}[a-zA-Z]{4}\d{9}$/";
          break;

        case "../Images/intesa.jpeg":
          $patternbank="/[a-zA-Z]{3}\d{13}$/";
          break;

        case "../Images/raiffeisen.jpeg":
          $patternbank="/\d{8}$/";
          break;
    }

    if(preg_match($patternbank, $_POST["paymentnumber"]))
    {
      $paymentnumber = test_input(mysqli_real_escape_string($link,$_POST["paymentnumber"]));
    }else{
      $referenca_error = 'Invalid Payment Number';
    }
  }
 }


 if(empty($_POST["adress"]))
 {
  $adresa_error = 'Address is required';
 }
 else
 {
  $vendbanim = encryptValues(test_input(mysqli_real_escape_string( $link,$_POST['adress'])));
 }
 
 if(empty($_POST["city"]))
 {
  $qyteti_error = 'City is required';
 }
 else
 {
  $qyteti = test_input(mysqli_real_escape_string( $link,$_POST['city']));
 }

 if(empty($_POST["datakursit"]))
 {
  $datakursit_error = 'Data of Course is required';
 }
 else
 {
  $datakursit = test_input( mysqli_real_escape_string( $link,$_POST['datakursit']));
 }

 if(empty($_POST["gjinia"]))
 {
  $gjinia_error = 'Gender is required';
 }
 else
 {
  $gjinia = test_input(mysqli_real_escape_string( $link,$_POST['gjinia']));
 }

 if(empty($_POST["select"]))
 {
  $select_error = 'Choose Course';
 }
 else
 {
  $idkursi = test_input( mysqli_real_escape_string( $link,$_POST['select']));
 }

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

 if($emri_error == '' && $mbiemri_error == '' && $gjinia_error == '' && $personalid_error == ''&&  $datelindje_error == ''&& $atesia_error == ''&& $email_error == ''&& $tel_error == '' && $adresa_error == ''&& $referenca_error == ''&& $qyteti_error == ''&& $datakursit_error == ''  && $select_error == '' && $captcha_error == '')
 {

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

    $shtokursant = "INSERT INTO kursantet(PersonalID, Emri, Mbiemri, Atesia, Datelindja, Vendbanimi,Telefoni, Dega, Datakursit, Orari, Email, BankPayment, Statusi, IdKursi, DataRregjistrimit, Gjinia)
    VALUES ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$idQyteti', '$datakursit','$orari','$email','$paymentnumber','pabere', '$idkursi', '$now', '$gjinia');";
            
    if($resultinsert = mysqli_query($link, $shtokursant)){

        $quryshto = "INSERT INTO organizimkursantesh1(idkursi, idkursanti,statusi ) VALUES ('$idkursi','$id', 'pabere');";
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
          alert('Something went reserving a chair! Try again!');
          window.location.href='webpage.php';
          </script>";
        }
    }else{
        echo "<script>
        alert('Something wentcreating user! Try again!');
        window.location.href='webpage.php';
        </script>";
    }
 }
 else
 {
  $data = array(
    'success'  => false,
    'emri_error' => $emri_error,
    'mbiemri_error' =>$mbiemri_error,
    'gjinia_error' => $gjinia_error,
    'personalid_error' => $personalid_error,
    'datelindje_error' => $datelindje_error,
    'atesia_error' => $atesia_error,
    'email_error' => $email_error,
    'tel_error' => $tel_error,
    'adresa_error' => $adresa_error,
    'referenca_error' => $referenca_error,
    'qyteti_error' => $qyteti_error,
    'datakursit_error' => $datakursit_error,
    'selected_error'  => $select_error,
    'bank_error'  => $bank_error,
    'captcha_error'  => $captcha_error
  );
 }
 echo json_encode($data);
}

?>
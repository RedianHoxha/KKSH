<?php
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
    //$link = mysqli_connect("localhost", "root", "", "kksh");
    if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $now = date('Y-m-d');
    $min  = 1;
    $max  = 15;
    $num1 = rand( $min, $max );
    $num2 = rand( $min, $max );
    $sum  = $num1 + $num2;

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
    $quizresult='';
    $hiddensum='';

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
    $question_error='';
    
  $patternId = "/[a-zA-Z]\d{8}[a-zA-Z]$/";
  $patternbank="";

 if(empty($_POST["name"]))
 {
  $emri_error = 'First name is required';
 }
 else
 {
  $emri = encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['name']))));
 }

 if(empty($_POST["surname"]))
 {
  $mbiemri_error = 'Last name is required';
 }
 else
 {
  $mbiemri = encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['surname']))));
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
  $atesia = encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['father']))));
 }

 if(empty($_POST["id"]))
 {
  $personalid_error = 'Personal Id is required';
 }
 else
 {
   if(preg_match($patternId, $_POST["id"])){
    $idgetfromuser = test_input( mysqli_real_escape_string( $link,$_POST['id']));
    $idcapital = strtoupper($idgetfromuser);
    $id = encryptValues($idcapital);

    $checkIfExist = "SELECT * FROM kursantet WHERE PersonalId = '$id' AND statusi = 'pabere';";
    $resultofexist = mysqli_query($link, $checkIfExist);
    $rowexist = mysqli_num_rows($resultofexist);
    if($rowexist){
      $personalid_error = 'Your Id is used before! Call at 042228199/0672063455 to fix your problem!';
    }
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
        case "../images/credinsbank.jpeg":
          $patternbank="/\d{15}-\d{3}$/";
          $bankName = "credins";
          break;

        case "../images/tiranabank.jpeg":
          $patternbank="/\d{15}$/";
          $bankName = "tirana";
          break;

        case "../images/bkt.jpeg":
          $patternbank="/\d{3}[a-zA-Z]{4}\d{9}$/";
          $bankName = "bkt";
          break;

        case "../images/intesa.jpeg":
          $patternbank="/[a-zA-Z]{3}\d{13}$/";
          $bankName = "intesa";
          break;

        case "../images/raiffeisen.jpeg":
          $patternbank="/\d{8}$/";
          $bankName = "raiffeisen";
          break;
    }
    if(preg_match($patternbank, $_POST["paymentnumber"]))
    {
      $paymentnumber = strtoupper(test_input(mysqli_real_escape_string($link,$_POST["paymentnumber"])));
      $checkifthispaymentexist = "SELECT * FROM kursantet WHERE BankPayment = '$paymentnumber'";
      $resultofexistpayment = mysqli_query($link, $checkifthispaymentexist);
      $paymentexist = mysqli_num_rows($resultofexistpayment);
      if($paymentexist){
        $referenca_error = 'This Payment Number is used before!';
      }

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
  $vendbanim = encryptValues(ucfirst(test_input(mysqli_real_escape_string( $link,$_POST['adress']))));
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

 if(empty($_POST["quiz"])){
  $question_error = 'Please fill the boxh with sum of the numbers!';
 }else{
  $quizresult = test_input( mysqli_real_escape_string( $link,$_POST['quiz']));
  $hiddensum  = test_input( mysqli_real_escape_string( $link,$_POST['hiddensum']));
   if($quizresult != $hiddensum){
    $question_error = 'Your answer is incorrect';
   }
 }

 if(empty($_POST["select"]))
 {
  $select_error = 'Choose Course';
 }
 else
 {
  $idkursi = test_input( mysqli_real_escape_string( $link,$_POST['select']));
 }



 if($emri_error == '' && $mbiemri_error == '' && $gjinia_error == '' && $personalid_error == ''&&  
    $datelindje_error == ''&& $atesia_error == ''&& $email_error == ''&& $tel_error == '' && 
    $adresa_error == ''&& $referenca_error == ''&& $qyteti_error == ''&& 
    $datakursit_error == ''  && $select_error == '' && $question_error == '')
 {

    $querymerrtedhena = "SELECT * FROM programijavor WHERE idkursi = $idkursi;";
    $resulttedhenash = mysqli_query($link, $querymerrtedhena);
    $rowtedhena = mysqli_fetch_array($resulttedhenash);
    $idklase = $rowtedhena['idklase'];
    $orari = $rowtedhena['orari'];

    $sqlgetnameofclass="SELECT * FROM klasa WHERE ID = '$idklase'";
    $resultemriklases = mysqli_query($link, $sqlgetnameofclass);
    $rowemriklases = mysqli_fetch_array($resultemriklases);
    $emriklases = decrypt($rowemriklases['Emri']);

    $sqlurlqyteti = "SELECT * FROM `qyteti` where EmriDeges = '$qyteti';";
    $resultsqlurlqyteti = mysqli_query($link, $sqlurlqyteti);
    $row = mysqli_fetch_array($resultsqlurlqyteti);
    $idQyteti = $row['IDQyteti'];

    if($emriklases === 'KlasaD'){
      $url = 'https://goo.gl/maps/HSvocghFuFUKqVGaA';
    }else{
      $url = $row['Adresa'];
    }

    $shtokursant = "INSERT INTO kursantet(PersonalId, Emri, Mbiemri, Atesia, Datelindja, Vendbanimi,Telefoni, Dega, Datakursit, Orari, Email, BankPayment, Statusi, IdKursi, DataRregjistrimit, Gjinia, Amza, NrSerisDeshmis, BankName)
    VALUES ( '$id', '$emri', '$mbiemri', '$atesia','$datelindja', '$vendbanim', '$tel' , '$idQyteti', '$datakursit','$orari','$email','$paymentnumber','pabere', '$idkursi', '$now', '$gjinia', '', '', '$bankName');";
            $resultinsert = mysqli_query($link, $shtokursant) or die(mysqli_error($link));
    if($resultinsert){

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
          alert('Something went wrong during reserving a chair! Try again!');
          window.location.href='webpage.php';
          </script>";
        }
    }else{
        echo "<script>
        alert('Something went wrong during creating user! Try again!');
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
    'question_error' => $question_error
  );
 }
 echo json_encode($data);
}


?>
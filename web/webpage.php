<?php
require_once('../php/extra_function.php');
$link = mysqli_connect("localhost", "root", "", "kksh");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

?>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" type="text/css" href="webpage.css" />
<!-- <link rel="stylesheet" type="text/css" href="test.css" /> -->

<head>
   <script>
      function showclass(str) 
      {
          document.getElementById("txtHint").innerHTML = str;
          var city  = document.getElementById("city").value;
          var data = str.toString();
          if (str == "") 
          {
              document.getElementById("txtHint").innerHTML = "";
              return;
          } else 
          {
              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = function() 
              {
                  if (this.readyState == 4 && this.status == 200) 
                  {
                      document.getElementById("txtHint").innerHTML = this.responseText;
                  }
              };
              xmlhttp.open("GET",`afishoklasatweb.php?data=${str}&id=${city}`,true);
              xmlhttp.send();
          }
      }

      function showclassCity(city) 
      {
          document.getElementById("txtHint").innerHTML = str;
          var str  = document.getElementById("datakursit").value;
          var data = str.toString();
          if (str == "") 
          {
              document.getElementById("txtHint").innerHTML = "";
              return;
          } else 
          {
              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = function() 
              {
                  if (this.readyState == 4 && this.status == 200) 
                  {
                      document.getElementById("txtHint").innerHTML = this.responseText;
                  }
              };
              xmlhttp.open("GET",`afishoklasatweb.php?data=${str}&id=${city}`,true);
              xmlhttp.send();
          }
      }

      $(document).ready(function(){
         $('#captcha_form').on('submit', function(event)
         {
            event.preventDefault();
            $.ajax({
               url:"rregjistroweb.php",
               method:"POST",
               data:$(this).serialize(),
               dataType:"json",
               beforeSend:function()
                  {
                     $('#register').attr('disabled','disabled');
                  },
                  success:function(data)
                  {
                     $('#register').attr('disabled', false);
                     if(data.success)
                     {
                        $('#captcha_form')[0].reset();
                        $('#captcha_error').text('');
                        document.getElementById("txtHint").innerHTML = '';
                        grecaptcha.reset();
                        if (window.confirm(`Rregjistrimi u krye me sukses!\nParaqituni ne daten : ${data.datakursit} , Ora: ${data.orari} prane zyrave te Kryqit te Kuq Shqiptar!\nDuhet te keni me vete :\n1->Mandatin e pageses\n 2->Karten e Identitetit\nKliko 'OK' per te pare vendodhjen ne harte`)) 
                        {
                           window.location.href=`${data.url}`;
                        };
                     }
                     else
                     {
                        $('#captcha_error').text(data.captcha_error);
                     }
                  },
                  error:function(par1, par2, par3)
                  {
                     console.log(par1.responseText);
                  }
            })
         });
      });
  </script>
</head>

<body>
<section class="get-in-touch">
<div id="header">
<img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="kksh_logo">
   <h1 class="title">Welcome</h1>
   <img src="../images/kksh_logo2.PNG" alt="Simply Easy Learning" id="kksh_logo">
</div>  
<div id="form">
   <form id="captcha_form" class="contact-form row" action="rregjistroweb.php" method="POST">
      <div class="form-field col-lg-4">
         <input name="name" class="input-text js-input" type="text" required>
         <label class="label" for="name">Emri</label>
      </div>
      <div class="form-field col-lg-4">
        <input name="surname" class="input-text js-input" type="text" required>
        <label class="label" for="surname">Mbiemri</label>
     </div>
     <div class="form-field col-lg-4">
        <input name="id" class="input-text js-input" type="text" required>
        <label class="label" for="id">ID</label>
     </div>
     <div class="form-field col-lg-6">
      <input name="bday" class="input-text js-input" type="date" required>
      <label class="label" for="bday">Datelindja</label>
      </div>
     <div class="form-field col-lg-6">
        <input name="father" class="input-text js-input" type="text" required>
        <label class="label" for="father-name">Atesia</label>
     </div>
      <div class="form-field col-lg-6">
         <input name="email" class="input-text js-input" type="email">
         <label class="label" for="email">E-mail</label>
      </div>
      <div class="form-field col-lg-6 ">
         <input name="phone" class="input-text js-input" type="number" required>
         <label class="label" for="phone-number">Numri Telefonit</label>
      </div>
      <div class="form-field col-lg-6 ">
            <select id="city" name="city" onchange=showclassCity(this.value)>
               <?php $sqlquery="Select * from qyteti";
                  $qytetet=mysqli_query($link, $sqlquery);
                  while ($row = mysqli_fetch_array($qytetet)) { ?>
               <option value="<?php echo $row['EmriDeges']; ?>"><?php echo $row['EmriDeges']; ?></option>
               <?php } ?>
            </select>
        <label class="label" for="city">Qyteti</label>
     </div>
     <div class="form-field col-lg-6 ">
         <input name="adress" class="input-text js-input" type="text" required>
         <label class="label" for="address">Adresa Banimit</label>
      </div>
     <div class="form-field col-lg-6 ">
        <input name="paymentnumber" class="input-text js-input" type="text" required>
        <label class="label" for="paymentnumber">Numri i pageses</label>
     </div>
     <div class="form-field col-lg-6 ">
         <input id="datakursit" class="input-text js-input"  type="date"  name="datakursit" onchange="showclass(this.value)" required>
         <label class="label" for="address">Data dhe Orari i Kursit</label>    
     </div>
     <div class="form-field col-lg-12 ">
         <div id="txtHint"></div>
      </div>
      <div class="form-field col-lg-6">
      <div class="g-recaptcha" data-sitekey="6LfwjbwdAAAAAIjvSq7c6CXVKuA3BRy5vs8TMAJX" require></div>
      <span id="captcha_error" class="text-danger"></span>   
      </div>
      <div class="form-field col-lg-6">
         <input class="submit-btn" type="submit" name="register" id="register" value="Submit">
      </div>
   </form>
</div>
</section>
</body>

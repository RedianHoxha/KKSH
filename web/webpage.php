<?php
require_once('../php/extra_function.php');
$link = mysqli_connect("localhost", "root", "", "kksh");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
    }

?>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>-->
<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
<div id="header" class="d-flex justify-content-around">
<img src="../images/kkshlogo.PNG" alt="Simply Easy Learning" id="kksh_logo" class="p-2">
   <p class="title p-2 ">Kryqi I Kuq Shqiptar</p>
   <img src="../images/kksh_logo2.PNG" alt="Simply Easy Learning" id="kksh_logo100" class="p-2">
</div>
    <div class="d-flex justify-content-start">
        <p>Ju lutem plotesoni formen me te dhenat tuaja!</p>
    </div>
<div id="form" class="shadow p-3 mb-5 bg-white rounded">
   <!--styles to be applied and form validations -->
   <form id="captcha_form" class="contact-form row g-3 needs-validation" action="rregjistroweb.php" method="POST" novalidate>
<!--      <div class="form-field col-lg-4">-->
<!--         <input name="name" class="input-text js-input" type="text" required>-->
<!--         <label class="label" for="name">Emri</label>-->
<!--      </div>-->

       <div class="col-md-6 position-relative">
           <label for="validationTooltip01" class="form-label">Emri</label>
           <input type="text" class="form-control" name="name" id="validationTooltip01" required placeholder="Emri...">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem plotesoni Emrin.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip02" class="form-label">Mbiemri</label>
           <input type="text" class="form-control" name="surname" id="validationTooltip02" required placeholder="Mbiemri...">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem plotesoni Mbiemrin.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip03" class="form-label">ID</label>
           <input type="text" class="form-control" name="id" id="validationTooltip03" pattern="^[A-Z]\d{9}[A-Z]$" required placeholder="psh: J257489657P">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem plotesoni ID e sakte.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip04" class="form-label">Datelindja</label>
           <input type="date" class="form-control" name="bday" id="validationTooltip04" required placeholder="Datelindja...">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem plotesoni Datelindjen.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip05" class="form-label">Atesia</label>
           <input type="text" class="form-control" name="father" id="validationTooltip05" required placeholder="Atesia...">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem plotesoni Atesine.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip06" class="form-label">E-mail</label>
           <input type="email" class="form-control" name="email" id="validationTooltip06" required placeholder="Email...">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem vendosni E-Mailin e sakte.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip07" class="form-label">Numri i Telefonit</label>
           <input type="number" class="form-control" name="phone" id="validationTooltip07" pattern="^\\d{10}$" required placeholder="psh: emer.mbiemer@gmail.com">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem vendosni numrin 10 shifror.
           </div>
       </div>

      <div class="col-md-6 position-relative">
          <label for="validationTooltip08" class="form-label">Qyteti</label>
          <select id="city" name="city" class="form-select" onchange=showclassCity(this.value) required>
              <option selected disabled value="">-- Zgjidh qytetin --</option>
               <?php $sqlquery="Select * from qyteti";
                  $qytetet=mysqli_query($link, $sqlquery);
                  while ($row = mysqli_fetch_array($qytetet)) { ?>
               <option value="<?php echo $row['EmriDeges']; ?>"><?php echo decrypt($row['EmriDeges']); ?></option>
               <?php } ?>
            </select>
          <div class="invalid-feedback">
              Ju lutem zgjidhni nje qytet.
          </div>
     </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip09" class="form-label">Adresa Banimit</label>
           <input type="text" class="form-control" name="adress" id="validationTooltip09" required placeholder="Adresa...">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem vendosni adresen tuaj.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip10" class="form-label">Numri i pageses</label>
           <input type="text" class="form-control" name="paymentnumber" id="validationTooltip10" required placeholder="Mund te duhet validim">
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem vendosni numrin e pageses.
           </div>
       </div>

       <div class="col-md-6 position-relative">
           <label for="validationTooltip11" class="form-label">Data dhe Orari i Kursit</label>
           <input type="date" class="form-control" name="datakursit" id="datakursit" onchange="showclass(this.value)" required>
           <div id="validationServerUsernameFeedback" class="invalid-feedback">
               Ju lutem zgjidhni daten e kursit.
           </div>
       </div>
      <div class="form-field col-6">
      <div class="g-recaptcha" data-sitekey="6LfwjbwdAAAAAIjvSq7c6CXVKuA3BRy5vs8TMAJX" style="text-align: -webkit-center" require></div>
      <span id="captcha_error" class="text-danger"></span>
      </div>
       <div class="form-field col-lg-12">
           <div id="txtHint"></div>
       </div>
      <div class="form-field col-md-12 text-center">
         <input class="submit-btn" type="submit" name="register" id="register" value="Submit">
      </div>
   </form>


    <!--      <div class="form-field col-lg-4">-->
    <!--        <input name="surname" class="input-text js-input" type="text" required>-->
    <!--        <label class="label" for="surname">Mbiemri</label>-->
    <!--     </div>-->
    <!--     <div class="form-field col-lg-4">-->
    <!--        <input name="id" class="input-text js-input" type="text" required>-->
    <!--        <label class="label" for="id">ID</label>-->
    <!--     </div>-->
    <!--     <div class="form-field col-lg-6">-->
    <!--      <input name="bday" class="input-text js-input" type="date" required>-->
    <!--      <label class="label" for="bday">Datelindja</label>-->
    <!--      </div>-->
    <!--     <div class="form-field col-lg-6">-->
    <!--        <input name="father" class="input-text js-input" type="text" required>-->
    <!--        <label class="label" for="father-name">Atesia</label>-->
    <!--     </div>-->
    <!--      <div class="form-field col-lg-6">-->
    <!--         <input name="email" class="input-text js-input" type="email">-->
    <!--         <label class="label" for="email">E-mail</label>-->
    <!--      </div>-->
    <!--      <div class="form-field col-lg-6 ">-->
    <!--         <input name="phone" class="input-text js-input" type="number" required>-->
    <!--         <label class="label" for="phone-number">Numri Telefonit</label>-->
    <!--      </div>-->
    <!--     <div class="form-field col-lg-6 ">-->
    <!--         <input name="adress" class="input-text js-input" type="text" required>-->
    <!--         <label class="label" for="address">Adresa Banimit</label>-->
    <!--      </div>-->
    <!--     <div class="form-field col-lg-6 ">-->
    <!--        <input name="paymentnumber" class="input-text js-input" type="text" required>-->
    <!--        <label class="label" for="paymentnumber">Numri i pageses</label>-->
    <!--     </div>-->
    <!--     <div class="form-field col-lg-6 ">-->
    <!--         <input id="datakursit" class="input-text js-input"  type="date"  name="datakursit" onchange="showclass(this.value)" required>-->
    <!--         <label class="label" for="address">Data dhe Orari i Kursit</label>    -->
    <!--     </div>-->
</div>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</section>
</body>

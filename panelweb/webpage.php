<?php
require_once('../methods/extra_function.php');
require_once('rregjistroweb.php');
include('../authenticate/dbconnection.php');
//$link = mysqli_connect("localhost", "root", "", "kksh");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="webpage.css" />

<head>
    <script>
        function showclass(str) {
            document.getElementById("txtHint").innerHTML = str;
            var city = document.getElementById("city").value;
            var data = str.toString();
            if (city == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                //xmlhttp.open("GET", `afishowebsakt.php?data=${str}&id=${city}`, true);
                xmlhttp.open("GET", `afishoklasatweb.php?data=${str}&id=${city}`, true);
                xmlhttp.send();
            }
        }

        function showclassCity(city) {
            document.getElementById("txtHint").innerHTML = str;
            var str = document.getElementById("datakursit").value;
            var data = str.toString();
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                // xmlhttp.open("GET", `afishowebsakt.php?data=${str}&id=${city}`, true);
                xmlhttp.open("GET", `afishoklasatweb.php?data=${str}&id=${city}`, true);
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
                     if(data.success){
                        $('#captcha_error').text('');
                        $('#name_error').text('');
                        $('#mbiemri_error').text('');
                        $('#gjinia_error').text('');
                        $('#personalid_error').text('');
                        $('#datelindje_error').text('');
                        $('#atesia_error').text('');
                        $('#tel_error').text('');
                        $('#adresa_error').text('');
                        $('#referenca_error').text('');
                        $('#qyteti_error').text('');
                        $('#selected_error').text('');
                        $('#bank_error').text('');
                        $('#datakursit_error').text('');
                        $('#question_error').text('');


                        document.getElementById("txtHint").innerHTML = '';
                        if (window.confirm(`Rregjistrimi u krye me sukses!\nParaqituni në datën : ${data.datakursit} , Ora: ${data.orari} pranë zyrave të Kryqit të Kuq Shqiptar!\nDuhet të keni me vete ne diten e kursit:\n1->Mandatin e pageses\n2->Kartën e Identitetit\n3->Një fotografi për dokument\nKliko 'OK' për të parë vendodhjen në hartë`))
                        {
                           window.location.href=`${data.url}`;
                        };
                     }else{
                        $('#emri_error').text(data.emri_error);
                        $('#mbiemri_error').text(data.mbiemri_error);
                        $('#gjinia_error').text(data.gjinia_error);
                        $('#personalid_error').text(data.personalid_error);
                        $('#datelindje_error').text(data.datelindje_error);
                        $('#atesia_error').text(data.atesia_error);
                        $('#tel_error').text(data.tel_error);
                        $('#adresa_error').text(data.adresa_error);
                        $('#referenca_error').text(data.referenca_error);
                        $('#qyteti_error').text(data.qyteti_error);
                        $('#selected_error').text(data.selected_error);
                        $('#bank_error').text(data.bank_error);
                        $('#datakursit_error').text(data.datakursit_error);
                        $('#question_error').text(data.question_error);
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
            <img src="../images/kkshlogo.png" alt="Simply Easy Learning" id="kksh_logo" class="p-2">
            <p class="title p-2 ">Kryqi I Kuq Shqiptar</p>
            <img src="../images/kksh_logo2.png" alt="Simply Easy Learning" id="kksh_logo100" class="p-2">
        </div>
        <div class="d-flex justify-content-start">
            <p>Ju lutem plotësoni formën me të dhënat tuaja!</p>
        </div>
        <div id="form" class="shadow p-3 mb-5 bg-white rounded">
            <form id="captcha_form" class="contact-form row g-3" action="rregjistroweb.php" method="POST">
                <div class="col-md-4 position-relative">
                    <label class="form-label">Emri</label><span style="color:#ff0000">*</span>
                    <input type="text" class="form-control" name="name" id="name"  require placeholder="Emri...">
                    <span id="emri_error" class="text-danger"></span>
                </div>

                <div class="col-md-4 position-relative">
                    <label for="validationTooltip02" class="form-label">Mbiemri</label><span style="color:#ff0000">*</span>
                    <input type="text" class="form-control" name="surname" id="surname"  require placeholder="Mbiemri...">
                    <span id="mbiemri_error" class="text-danger"></span>
                </div>

                <div class="col-md-4 position-relative">
                    <label  class="form-label">Gjinia</label><span style="color:#ff0000">*</span>
                    <select id="gjinia" name="gjinia" require class="form-select" >
                        <option selected disabled value="">-- Gjinia --</option>
                        <option value="M">Mashkull</option>
                        <option value="F">Femer</option>
                    </select>
                    <span id="gjinia_error" class="text-danger"></span>
                </div>

                <div class="col-md-6 position-relative">
                    <label  class="form-label">ID</label><span style="color:#ff0000">*</span>
                    <input type="text" class="form-control" name="id" require placeholder="J3XXXXXX7P">
                    <span id="personalid_error" class="text-danger"></span>
                </div>

                <div class="col-md-6 position-relative">
                    <label  class="form-label">Datëlindja</label><span style="color:#ff0000">*</span>
                    <input type="date" class="form-control" name="bday" require placeholder="Datëlindja...">
                    <span id="datelindje_error" class="text-danger"></span>
                </div>

                <div class="col-md-6 position-relative">
                    <label class="form-label">Emri i Babait</label><span style="color:#ff0000">*</span>
                    <input type="text" class="form-control" name="father" require  placeholder="EMri i Babait...">
                    <span id="atesia_error" class="text-danger"></span>
                </div>

                <div class="col-md-6 position-relative">
                    <label  class="form-label">E-mail</label>
                    <input type="email" class="form-control" name="email"  placeholder="Email...">
                </div>

                <div class="col-md-6 position-relative">
                    <label class="form-label">Numri i Telefonit</label><span style="color:#ff0000">*</span>
                    <input type="number" class="form-control" name="phone"  require placeholder="06xxxxxxxx">
                    <span id="tel_error" class="text-danger"></span>
                </div>
                <div class="col-md-6 position-relative">
                    <label  class="form-label">Adresa Banimit</label><span style="color:#ff0000">*</span>
                    <input type="text" class="form-control" name="adress" require  placeholder="Adresa...">
                    <span id="adresa_error" class="text-danger"></span>
                </div>
                <div class="col-md-6 position-relative">
                    <label class="form-label">Banka</label><span style="color:#ff0000">*</span>
                    <select id="my_select_box" name="my_select_box" require class="form-select" >
                        <option selected disabled value="">-- Zgjidh Bankën --</option>
                        <option value="../images/credinsbank.jpeg">Credins Bank</option>
                        <option value="../images/tiranabank.jpeg">Tirana Bank</option>
                        <option value="../images/bkt.jpeg">Banka Kombetare Tregtare</option>
                        <option value="../images/raiffeisen.jpeg">Raiffeisen Bank</option>
                    </select>
                    <span id="bank_error" class="text-danger"></span>
                </div>

                <div class="col-md-6 position-relative">
                    <label  class="form-label">Referenca pagesës</label><span style="color:#ff0000">*</span>
                    <input type="text" class="form-control" name="paymentnumber" require  placeholder="Ref pageses">
                    <span id="referenca_error" class="text-danger"></span>
                </div>
                <div class="col-md-12 position-relative" id="popup" style="display: none;">
                    <img id="my_changing_image" src="" />
                </div>
                <div class="col-md-6 position-relative">
                    <label  class="form-label">Qyteti</label><span style="color:#ff0000">*</span>
                    <select id="city" name="city" class="form-select" require onchange="showclassCity(this.value)" >
                        <option selected disabled value="">-- Zgjidh qytetin --</option>
                        <?php $sqlquery = "Select * from qyteti";
                        $qytetet = mysqli_query($link, $sqlquery);
                        while ($row = mysqli_fetch_array($qytetet)) { ?>
                            <option value="<?php echo $row['EmriDeges']; ?>"><?php echo decrypt($row['EmriDeges']); ?></option>
                        <?php } ?>
                    </select>
                    <span id="qyteti_error" class="text-danger"></span>
                </div>
                <div class="col-md-6 position-relative">
                    <label class="form-label">Data e Kursit</label><span style="color:#ff0000">*</span>
                    <input type="date" class="form-control" name="datakursit" id="datakursit" require onchange="showclass(this.value)" >
                    <span id="datakursit_error" class="text-danger"></span>
                </div>
                <div class="form-field col-lg-12">
                    <div id="txtHint"></div>
                    <span id="selected_error" class="text-danger"></span>
                </div>
                <div class="row rowquestion">
                    <div class="col-md-6">
                        <label class="form-label questionQuiz"> Ju lutem plotesoni me rezultatin e sakte!
                            <?php echo $num1 . '+' . $num2; ?>=?<span style="color:#ff0000">*</span>
                        </label>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="quiz"  require placeholder="Shuma">
                        <input type="hidden" name="hiddensum" value=<?php echo $sum?>>
                        <span id="question_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-field col-md-12 text-center">
                    <input class="submit-btn" type="submit" name="Submit" id="Submit" value="Submit">
                </div>
            </form>
        </div>
        <script>
            $('#my_select_box').change(function() {
                let popup = document.querySelector("#popup").style.display = "block"
                $('#my_changing_image').attr('src', $('#my_select_box').val());
            });
        </script>
    </section>
</body>
<?php
session_start();
require_once('../methods/extra_function.php');
include('../authenticate/dbconnection.php');
if (!isset($_SESSION['user'])) {
    echo "Please Login again";
    session_destroy();
    echo "<script>
        alert('Session Ended');
        window.location.href='../panelstaf/index.php';
        </script>";
} else {
    $now = time();
    if ($now > $_SESSION['expire']) {
        session_destroy();
        echo "<script>
            alert('Session Ended');
            window.location.href='../panelstaf/index.php';
            </script>";
    } else {
        $user = $_SESSION['user'];
        $iduseri = $_SESSION['UserID'];
        $_SESSION['expire'] = $_SESSION['expire'] + (3 * 60);
        if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        } else {
            $query = "SELECT * FROM staf WHERE ID = '$iduseri';";
            $staf = mysqli_query($link, $query);
            $row = mysqli_fetch_array($staf);
            $dega = $row['Degakupunon'];
            $roli = decrypt($row['Roli']);
            $pageRole = "Financa";
            $result = strcmp($roli, $pageRole);

            if ($result != 0) {
                session_destroy();
                echo "<script>
                    alert('Session Ended');
                    window.location.href='../panelstaf/index.php';
                    </script>";
            }
        }
    }
}
?>

<!DOCTYPE html>

<head>
    <title>Kryqi i Kuq Shqiptar</title>
    <link rel="stylesheet" type="text/css" href="../css/admindegestilizime.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#organizim_javor').after('<div id="nav"></div>');
            var rowsShown = 12;
            var rowsTotal = $('#organizim_javor tbody tr').length;
            var numPages = rowsTotal / rowsShown;
            for (i = 0; i < numPages; i++) {
                var pageNum = i + 1;
                $('#nav').append('<a href="#" class="btn" rel="' + i + '">' + pageNum + '</a> ');
            }
            $('#organizim_javor tbody tr').hide();
            $('#organizim_javor tbody tr').slice(0, rowsShown).show();
            $('#nav a:first').addClass('active');
            $('#nav a').bind('click', function () {

                $('#nav a').removeClass('active');
                $(this).addClass('active');
                var currPage = $(this).attr('rel');
                var startItem = currPage * rowsShown;
                var endItem = startItem + rowsShown;
                $('#organizim_javor tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                    css('display', 'table-row').animate({
                        opacity: 1
                    }, 300);
            });
        });
    </script>
</head>

<body></br>
    <div id="add_button">
        <!-- <button class="btn btn-info" onclick="location.href = 'shtokolone.php';" id="addbutton" >Shto kolonen e bankes</button>  -->
        <button class="btn btn-secondary" onclick="location.href = 'financapage.php';" id="myButton">Klasat</button>
        <button class="btn btn-danger" onclick="location.href = '../authenticate/logout.php';" id="myButton"> Dil
            <?php echo decrypt($user) ?>
        </button><br>
    </div></br>
    <div id="top-page-right">
        <form action="searchpayment.php" method="POST">
            <input class="form-group mx-sm-3 mb-2" type="text" name="search" id="search"
                placeholder="Id, Emer, Mbiemr, Reference">
            <button class="btn btn-secondary" type="submit" id="search-button">Search</button>
        </form>
    </div></br>
    <div id="tabela">
        <table id="organizim_javor" class="table table-bordered">
            <tr>
                <th>Emri</th>
                <th>Mbiemri</th>
                <th>Atesia</th>
                <th>ID Personale</th>
                <th>Banka</th>
                <th>Referenca e Pageses</th>
                <th>Data Rregjistrimit</th>
                <th>Data e kursit</th>
                <th>Orari i Kursit</th>
                <th>Instruktori</th>
                <th>Klasa</th>
            </tr>
            <tr>
                <?php
                    $firstday = date('Y-m-d');
                    //$lastday = date('Y-m-d', strtotime("sunday 0 week"));
                    $sqlquery = "SELECT * FROM kursantet WHERE statusi='pabere' AND Datakursit >= '$firstday';";
                    $kursantet = mysqli_query($link, $sqlquery);
                    while ($row = mysqli_fetch_array($kursantet)) {

                        $idkursi = $row['IdKursi'];
                        $sqlkursi = "SELECT * FROM programijavor WHERE idkursi = '$idkursi';";
                        $kursi = mysqli_query($link, $sqlkursi);
                        $rowkursi = mysqli_fetch_array($kursi);

                        $idKlase = $rowkursi['idklase'];
                        $idInstruktori = $rowkursi['idinstruktori'];
                        $sqlInstruktori = "SELECT * FROM staf WHERE ID =  '$idInstruktori';";
                        $instruktori = mysqli_query($link, $sqlInstruktori);
                        $rowInstruktori = mysqli_fetch_array($instruktori);

                        $sqlklasa = "SELECT * FROM klasa WHERE ID = $idKlase";
                        $runsqlklasa = mysqli_query($link, $sqlklasa);
                        $rowklasa = mysqli_fetch_array($runsqlklasa);

                    ?>
                <td>
                    <?php echo decrypt($row['Emri']); ?>
                </td>
                <td>
                    <?php echo decrypt($row['Mbiemri']); ?>
                </td>
                <td>
                    <?php echo decrypt($row['Atesia']); ?>
                </td>
                <td>
                    <?php echo decrypt($row['PersonalId']); ?>
                </td>
                <td>
                    <?php echo $row['BankName']; ?>
                </td>
                <td>
                    <?php echo $row['BankPayment']; ?>
                </td>
                <td>
                    <?php echo $row['DataRregjistrimit']; ?>
                </td>
                <td>
                    <?php echo date('d/m/Y', strtotime($rowkursi['data'])); ?>
                </td>
                <td>
                    <?php echo $rowkursi['orari']; ?>
                </td>
                <td>
                    <?php echo decrypt($rowInstruktori['Emri']); ?>
                    <?php echo decrypt($rowInstruktori['Mbiemri']); ?>
                </td>
                <td>
                    <?php echo decrypt($rowklasa['Emri']); ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
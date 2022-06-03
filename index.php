<!DOCTYPE html>
<html lang="en">
    
<!-- Bestemmer navnet på nettsiden i taben, tilatter at html skal få filer fra css og tilatter norsk bokstaver som å,æ,ø-->
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/style.css" rel="stylesheet" type="text/css">
    <title>Data fra Raspberry Pi</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses', 'gond'],
          ['2004',  1000,      400,     1000],
          ['2005',  1170,      460,     700],
          ['2006',  660,       1120,    800],
          ['2007',  1030,      540,     900]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

    </head>

    <!-- Body viser at her skal det ligge stoffet og main er hoved stoffet i dette tilfellet-->
    <body style="margin: 0px;">
        <main>

              <!-- Bestemmer at det skal bli en div under navnet header og bestemmer navnet-->
                <div class="header">
                    <h1>Raspberry <span class="special color">Pi</span></h1>
                    <img src="Illustrasjoner/icon/moon.png" id="icon">
                </div>  

                <!--bildet-->
                <div class="center">
                    <img src="Illustrasjoner/pix2022-05-13_104503.624366.jpg">
                </div>
        </main>


<?php 

    //sql kode som kobler til databasen 
    $host = "piasvg.mysql.database.azure.com";
    $user = "spagetti";
    $passw = "Pasta2022";
    $db = "spagetti";

    $kobling = new \mysqli($host, $user, $passw, $db);

    if ($kobling->connect_error) {
        die("Noe gikk galt: " . $kobling->connect_error);
    } else {
        echo "";
    }


    //sql kode som henter ut data fra databasen
    $sql = "SELECT Dato, Temperature, Humidity, Pressure, RomID

    FROM temperatur, rom";

    $chartArray = [];

    $resultat = $kobling->query($sql);
    echo "<Table>"; // Starter tabellen
        echo "<tr>"; // Lager en rad med overskrifter
        echo "<th>Temperature</th>"; // Overskriftene
        echo "<th>Pressure</th>";
        echo "<th>Humidity</th>";
        echo "<th>Dato</th>";
        echo "<th>Rom</th>";

        // Gir hver attribute en forkortelse
        echo "</tr>";
        while($rad = $resultat->fetch_assoc()) {
        $DT = $rad["Dato"];
        $TM = $rad["Temperature"];
        $PR = $rad["Pressure"];
        $HM = $rad["Humidity"];
        $ROM = $rad["RomID"];

        // Viser overskriftene og svarene 
        echo "<tr>";
        echo "<td>$TM</td>";
        echo "<td>$PR</td>";
        echo "<td>$HM</td>";
        echo "<td>$DT</td>";
        echo "<td>$ROM</td>";

        echo "</tr>";

        $data = [
            "dato" => $DT,
            "temp" => $TM,
            "pressure" => $PR,
            "humidity" => $HM,
            "rom" => $ROM
        ];

        

        $chartArray[] = $data;

        
    }
    echo "<script>var data = " . json_encode($chartArray) . "</script>";
    echo "</table>";
?>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>



    <script>
            var icon = document.getElementById("icon");
            icon.onclick = function(){
                document.body.classList.toggle("light-theme");
                if(document.body.classList.contains("light-theme")){
                    icon.src = "Illustrasjoner/icon/sun.png";
                } else {
                icon.src = "Illustrasjoner/icon/moon.png";
            }
            }

        </script>
    </body>
</html>
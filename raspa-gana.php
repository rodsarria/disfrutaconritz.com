<?
    $mysqli = new mysqli("localhost", "appstouc_ritz", "Start123!", "appstouc_ritz");
    if ($mysqli === false)
    {
       echo("ERROR: Could not connect. " . mysqli_connect_error());
    }

    session_start();
    $gano = $_SESSION['gano'];
    $id =  $_SESSION['id'];
    $probabilidad = "";

    $sql = "SELECT * FROM probabilidad";

    if ($result = $mysqli->query($sql))
    {
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_array())
            {
                 $probabilidad = $row[1];
            }
        }
    }

    $counter = 0;
    $sql = "SELECT * FROM premios";

    if ($result = $mysqli->query($sql))
    {
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_array())
            {
                $data['id'][$counter] = $row[0];
                $data['premio'][$counter] = $row[1];
                $data['min'][$counter] = $row[2];
                $data['max'][$counter] = $row[3];
                $data['stock'][$counter] = $row[4];
                $counter++;
            }
        }
    }

    $stock = false;

    if($data['stock'][0]>0||$data['stock'][1]>0||$data['stock'][2]>0) $stock = true;
    $randomNum = rand(1,100);
    $win = "sigue-intentando.html";

    $cartilla = "cartilla-sigue-intentando.png";

    $gano = "no";

    if($stock == true && $gano == "no" && $randomNum<=$probabilidad)
    {
        $win = "ganaste.html";

        for($i=0;$i<3;$i++)
        {
            if($randomNum>=$data['min'][$i] && $randomNum<=$data['max'][$i])
            {
                if($data['stock'][$i]>0)
                {
                    $cartilla = "cartilla-".$data['premio'][$i].".png";
                    break;
                }
                else
                {
                    $i=0;
                    $randomNum = rand(1,100);
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="es-419">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Ritz</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arvo:400,400i,700,700i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700">
    <link rel="stylesheet" href="assets/css/modal-comprobante.css">
    <link rel="stylesheet" href="assets/css/modal-terminos.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>

            body 
            { 
                text-align: center; 
            }

            #scratchcard 
            { 
                display: block; max-width: 520px; max-height: 220px; margin: 40px auto;
            }

    </style>
</head>

<body style="min-height: 100%;min-height: 100vh;display: flex;align-items: center;background: url(&quot;assets/img/bg.png&quot;) center / cover no-repeat;font-family: 'Source Sans Pro', sans-serif;color: var(--white);font-size: 20px;line-height: 24px;">
    <div class="container" style="margin-right: auto;margin-left: auto;max-width: 600px;padding-top: 30px;padding-bottom: 30px;">
        <div class="row">
            <div class="col text-center"><img src="assets/img/logo-campana-ritz.png" style="max-width: 75%;"></div>
        </div>
        <div class="row">
            <div class="col intro text-center">
                <h1 class="py-3">RASPA AQUÍ</h1><img src="assets/img/flecha.png" style="max-width: 40%;padding: 20px;">
            </div>
        </div>
        <div class="row">
            <div id="scratchcard"></div>
            <span id="counter" style="display: none">0</span><span></span>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/modal-comprobante.js"></script>
    <script type="text/javascript" src="assets/js/scratch.min.js"></script>
    <script>
            function callback(d) 
            { 
                d.container.style.backgroundImage = 'url(assets/images/demo1-end.gif)'; d.container.innerHTML = ''; 

                setTimeout(goPage, 5000);
            }

            function goPage()
            {
                window.location.href = "<? echo $win; ?>";
            }

            function percent(p) 
            { 
                document.getElementById("counter").innerHTML = p; 
            }

            window.onload = function() 
            {
                createScratchCard
                (
                    {
                        "container":document.getElementById("scratchcard"),
                        "background":"assets/img/<? echo $cartilla; ?>",
                        "foreground":"assets/img/foreground.jpg",
                        "percent":70,
                        "coin":"assets/images/coin2.png",
                        "thickness":18,
                        "counter":"percent",
                        "callback":"callback"
                    }
                );
            }

    </script>

</body>

</html>
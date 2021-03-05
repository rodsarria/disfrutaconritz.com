<?
    $mysqli = new mysqli("localhost", "appstouc_ritz", "Start123!", "appstouc_ritz");
    if ($mysqli === false)
    {
       echo("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $name = $_POST['name'];
    $DNI = $_POST['DNI'];
    $ticket = $_POST['ticket'];
    $date = $_POST['date'];
    $amount = $_POST['amount']; 
    $phone = $_POST['phone'];

    $gano = false;
    $found = false;

    if(isset($_POST['submit'])) 
    {
        //echo "NEPE";
        session_start();
        $_SESSION['gano'] = "no";
        $_SESSION['id'] = "";

        $sql = "SELECT id,nombre,DNI,telefono,factura,fechaCompra,montoTicket,fecha,gano FROM participante WHERE DNI='$DNI'";

        if ($result = $mysqli->query($sql))
        {
            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_array())
                {
                     if($row[7]=="Si")
                     {
                        $gano = true;
                     }
                     
                     $found = true;

                     //echo "FOUND";

                     $_SESSION['id'] = $row[0];
                     break;

                }
            }
        }

        $_SESSION['gano']  = $gano;


        if($found==false)
        {
            //echo "FOUND2";
            $sql = "INSERT INTO participante (nombre,DNI,telefono,factura,fechaCompra,montoTicket) VALUES ('$name','$DNI','$phone','$ticket','$date','$amount')";

            if ($mysqli->query($sql) === true)
            {
                $lastID = $mysqli->insert_id;
                $_SESSION['id'] = $lastID;
            }
            else echo "ERROR: Could not execute query: $sql. " . $mysqli->error;
        
        }
        
        echo ' <script type="text/javascript">window.location.href = "raspa-gana.php";</script>';
    }

    
?>

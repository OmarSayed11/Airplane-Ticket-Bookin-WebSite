<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="passtyle.css">
    <title>Document</title>
    <?php
    require_once('../connection.php');
    session_start();

    // Check user authentication
    if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'passenger') {
        header('Location: ../login.php');
        exit();
    }

    // Logout logic
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: ../login.php');
        exit();
    }

    $userEmail = $_SESSION['user_email'];
    $userId = $_SESSION['user_id'];
    ?>
</head>
<body>
    <?php
        include_once('./header.php');
    ?>
    <form method="post" action="search.php" class="searchhh">
        <label class="">From</label>
        
        <select name="from" class="select-style">
            <option>SELECT</option>
            <?php
            $result = $con->query("SELECT * FROM cities");

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $option = '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    echo $option;
                }
            }
            ?>
        </select>
    
        <label class="">To</label>
        <select name="to" class="select-style">
            <option>SELECT</option>
            <?php
            $result = $con->query("SELECT * FROM cities");

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $option = '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    echo $option;
                }
            }
            ?>
        </select>
        <input class="search" type="submit" value="search" />
    </form>
    <div class="ticcontainer" >

    <?php
    $z = "";
    $current = "";

    if (isset($_POST['from'])) {
        $from = $_POST['from'];
        
        $result = $con->query("SELECT name FROM cities WHERE id=$from");

        if ($result && $result->num_rows > 0) {
            $current = $result->fetch_array(MYSQLI_ASSOC);
            $z = "WHERE fromX='" . $current['name'] . "'";

            if (!isset($_POST['to'])) {
                $to = $_POST['to'];
                $result2 = $con->query("SELECT name FROM cities WHERE id=$to");

                if ($result2 && $result2->num_rows > 0) {
                    $wanted = $result2->fetch_array(MYSQLI_ASSOC);
                    $z .= " AND toX='" . $wanted['name'] . "'";
                }
            }
        }
       
    }
    

    $flightQuery = "SELECT * FROM flight $z";
    $flightResult = $con->query($flightQuery);

    if ($flightResult) {
        if ($flightResult->num_rows > 0) {
            while ($x = $flightResult->fetch_array(MYSQLI_ASSOC)) {
                $pe=$con->query("SELECT logoImg FROM company WHERE id=".$x['companyId']."");
                $pep=$pe->fetch_array(MYSQLI_ASSOC);
                  echo '    
            <a class="ticket" href="flight.php?from='.$x['id'].' & companyId='.$x['companyId'].'">
            
              <div class="logoimgg" ><img src="img/'.$pep['logoImg'].'"/></div>
              <div class="fromtickt">
              <div class="from">'.$x['fromX'].'</div>
              <div class="starttime">'.date_format(new DateTime($x['startTime']), 'H:i').'</div>
              <div class="startdate">'.date_format(new DateTime($x['startTime']), 'F j').'</div>
          
              </div >
              <div class="iconnn"><img src="img/icon.png" alt="icon"></div>
              <div class="fromtickt">
              <div class="from">'.$x['toX'].'</div>
              <div class="endtime">'.date_format(new DateTime($x['endTime']), 'H:i').'</div>
              <div class="enddate">'.date_format(new DateTime($x['endTime']), 'F j').'</div>
              </div>
          </a>
                  ';
                  $pe='';
                  $pep='';
            }
        } else {
            echo "Sorry, there are no flights with the selected information.";
        }
    } else {
        echo "Error executing the query: " . $con->error;
    }
    ?>
    </div>
    <?php
        include_once('./footer.php');
    ?>
</body>
</html>

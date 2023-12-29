<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="compstyle.css">
    <title>Document</title>
    <?php
        require_once('../connection.php');
        session_start();
        if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'company') {
            // Redirect to the login page if not logged in as a company
            header('Location: ../login.php');
            exit();
        }
        if (isset($_POST['logout'])) {
            // Destroy the session
            session_destroy();

            // Redirect to the login page
            header('Location: ../login.php');
            exit();
        }
        $userEmail = $_SESSION['user_email'];
        $userId=$_SESSION['user_id'];
    ?>
</head>
<body>
    <?php
        include_once('./header.php');
    ?>
        <div class="disccc dad">
        <div class="add">Selected</div>
        <div class="addf">Flight</div>
    </div>
         <div class="ticcontainer" >

    <?php
       if (isset($_GET['from']) && $_GET['from'] !== '' && isset($_GET['companyId']) && $_GET['companyId'] !== '') {
        $flightId = $_GET['from'];
        $companyId=$_GET['companyId'];
        $pe=$con->query("SELECT logoImg FROM company WHERE id=".$userId."");
      $pep=$pe->fetch_array(MYSQLI_ASSOC);
        $query = "SELECT * FROM flight WHERE id = $flightId";
        $result = $con->query($query);
    
        if ($result === false) {
            echo "Error executing query: " . $con->error;
        } else {
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
       
                    echo '    
  <form class="flighttick" method="post" action="flight.php?edit='.$_GET['from'].' & companyId='.$_GET['companyId'].'">
  
    <div class="logimgg" ><img src="img/'.$pep['logoImg'].'"/></div>
    <div class="fromttt">
    <div class="from">'.$row['fromX'].'</div>
    <div class="starttime">'.date_format(new DateTime($row['startTime']), 'H:i').'</div>
    <div class="startdate">'.date_format(new DateTime($row['startTime']), 'F j').'</div>

    </div >
    <div class="iconnn"><img src="img/icon.png" alt="icon"></div>
    <div class="fromttt">
    <div class="from">'.$row['toX'].'</div>
    <div class="endtime">'.date_format(new DateTime($row['endTime']), 'H:i').'</div>
    <div class="enddate">'.date_format(new DateTime($row['endTime']), 'F j').'</div>

    </div>
    <div class="numpasspen">NUM PASSENGER PENDING:'.$row['numPassPending'].'</div>
    <div class="numpassreg">NUM PASSENGER REGISTERED:'.$row['numPassRegistered'].'</div>
    <div class="fees">FEES:'.$row['fees'].'$</div>
    <div  class="aaa">ITERNARY:'.$row['iternary'].'</div>
    
    <a class="cancelbtn" href="cancel.php?from='.$_GET['from'].' & companyId='.$_GET['companyId'].'">CANCEL FLIGHT</a>
    <input  class="setcomp" type="submit"  value="Set Completed">

</form>
        ';
                } else {
                
    echo '<div style="position: absolute;top:280px;color:green;margin-left:100px;font-weight:bold;font-size:22px">No rows found for flight ID: $flightId</div>';
                }
            }
        }
        ?>
        </div>
          
            <?php
            if (isset($_GET['edit']) && $_GET['edit'] !== '' && isset($_GET['companyId']) && $_GET['companyId'] !== '') {
                $flightId = $_GET['edit'];
                $companyId=$_GET['companyId'];

            $completed = 'completed';
          

            $r=$con->query("UPDATE flight SET isCompleted='completed' WHERE id=" . $flightId."");       
            if ($r === false ) {
                echo "Failed to update flight: " . $con->error;
                exit();
            }else{
                echo '<div style="position: absolute;top:280px;color:green;margin-left:100px;font-weight:bold;font-size:22px">Flight is updated successfully</div>';
            }
        }    
            ?>
            <?php
                include_once('./footer.php');
            ?>
           <script defer type="text/javascript" src="app.js"></script>
 
</body>
</html>



         
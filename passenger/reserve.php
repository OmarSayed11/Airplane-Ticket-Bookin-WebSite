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
        if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'passenger') {
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
<?php
    $flightId = $payment = '';
    
    if (isset($_GET['flightId']) && isset($_POST['paymentType'])) {
        $flightId = $_GET['flightId'];
        $payment = $_POST['paymentType'];

               $checkExisting = $con->query("SELECT * FROM passengerflight WHERE flightId = '$flightId' AND passengerId = '$userId'");
        if ($checkExisting->num_rows > 0) {
        echo "Flight is already reserved by the user.";
        exit();
}else{
    $r = $con->query("SELECT * FROM flight WHERE id=".$flightId."");
    if ($r === false) {
        echo "Failed to fetch flight details: " . $con->error;
        exit();
    }

    $row = $r->fetch_assoc();
    if ($row === null) {
        echo "Flight not found";
        exit();
    }

    if ($payment === 'fromAccount') {
        $checkbalance=$con->query("SELECT accountBalance FROM passenger WHERE id='$userId'");
        $checkit=$checkbalance->fetch_array(MYSQLI_ASSOC);
        // var_dump($checkit['accountBalance']);
        $checkfees=$con->query("SELECT fees FROM flight WHERE id='$flightId'");
        $checkfeesit=$checkfees->fetch_array(MYSQLI_ASSOC);
        // var_dump($checkfeesit['fees']);
        if($checkit['accountBalance'] >= $checkfeesit['fees']) {
            $r2 = $con->query("UPDATE  passenger SET accountBalance=accountBalance -" . $row['fees']." WHERE id=".$userId."");
        $r3 = $con->query("UPDATE company SET accountBalance = accountBalance + " . $row['fees'] . " WHERE id=" . $row['companyId']);
        
        if ($r2 === false || $r3 === false) {
            echo "Failed to update balances: " . $con->error;
            exit();
        }
        $r4 = $con->query("INSERT IGNORE INTO passengerflight (flightId, passengerId ,status) VALUES ('$flightId', '$userId','registered')");
        if ($r4 === false) {
                if ($con->errno == 1062) { // MySQL error code for duplicate entry
                     echo "Flight is reserved before.";
                 } else {
                     echo "Failed to reserve the flight: " . $con->error;
                 }
                 exit();
             }
        $r5=$con->query("UPDATE flight SET numPassRegistered =numPassRegistered +1 WHERE id='$flightId'");
        }
        else {
            echo "Sorry!! ,You don't have enough money in you'r account balance";
            exit();
        }
        

    
    } elseif ($payment === 'cash') {
        $r4 = $con->query("INSERT IGNORE INTO passengerflight (flightId, passengerId,status) VALUES ('$flightId', '$userId','pending')");
        if ($r4 === false) {
                if ($con->errno == 1062) { // MySQL error code for duplicate entry
                     echo "Flight is reserved before.";
                 } else {
                     echo "Failed to reserve the flight: " . $con->error;
                 }
                 exit();
             }
        $r5=$con->query("UPDATE flight SET numPassPending =numPassPending +1 WHERE id='$flightId'");         
            }
    
    
}
       
    }
?>  <div class="ticcontainer">
<?php
if(isset($_GET['flightId'])==true && $_GET['flightId']!=''){
    $r=$con->query("SELECT * FROM flight WHERE id=".$_GET['flightId']."");
    $row=$r->fetch_array(MYSQLI_ASSOC);
    $pe=$con->query("SELECT logoImg FROM company WHERE id=".$row['companyId']."");
    $pep=$pe->fetch_array(MYSQLI_ASSOC);
    echo '  
    <div class="flighttick">
        <div class="logimgg"><img src="img/'.$pep['logoImg'].'"/></div>
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
        <div class="aaa">ITERNARY:'.$row['iternary'].'</div>
        <div class="completed">Is Completed or Not:' . $row['isCompleted'] . '</div>
    ';
}
?>
<form method="post" action="" class="paymenttt">
    <label>PaymentType:
        <select name="paymentType">
            <option value="fromAccount" <?= $payment=== 'fromAccount' ? 'selected' : ''; ?>>From Account</option>
            <option value="cash" <?= $payment=== 'cash' ? 'selected' : ''; ?>>Cash</option>
        </select>
    </label>
    <input type="submit" value="CheckOut">
</form>
</div>
</div>
<?php
        // header('Location: index.php');
        ?>
        <?php
            include_once('./footer.php');
        ?>
</body>
</html>



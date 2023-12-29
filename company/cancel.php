<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    $successMessage = "";
        if(isset($_GET['from'])==true && $_GET['from']!='' && isset($_GET['companyId']) && $_GET['companyId'] !== ''){
            $flightId=$_GET['from'];
            $companyId=$_GET['companyId'];

            // var_dump($_GET['from']);
            // var_dump($_GET['companyId']);
            // $checkExisting = $con->query("SELECT * FROM passengerflight WHERE flightId = '$flightId' ");
            $r=$con->query("SELECT fees FROM flight where id=$flightId");
            $row=$r->fetch_array(MYSQLI_ASSOC);
            //  var_dump($row['fees']);
             $fees=$row['fees'];
            $r2 = $con->query("UPDATE  passenger SET accountBalance=accountBalance +" . $row['fees']." WHERE id IN (SELECT passengerId FROM passengerflight WHERE flightId = $flightId AND status = 'registered')");
            if ($r2 === false) {
                echo "Failed to update passenger balances: " . $con->error;
                exit();
            }
             $r3 = $con->query("UPDATE company SET accountBalance = accountBalance - ($fees * (SELECT COUNT(passengerId) FROM passengerflight WHERE flightId = $flightId AND status = 'registered')) WHERE id = $companyId");
             if ($r3 === false) {
                echo "Failed to update company balance: " . $con->error;
                exit();
            }

            $deleteFlight = $con->query("DELETE FROM flight WHERE id = $flightId");
            if ($deleteFlight === false) {
                echo "Failed to delete flight from the flight table: " . $con->error;
                exit();
            }
            $deletePassengerFlight = $con->query("DELETE FROM passengerflight WHERE flightId = $flightId");

            if ($deletePassengerFlight === false) {
                echo "Failed to delete passengerflight records: " . $con->error;
                exit();
            }
             if($r2==true && $r3==true && $deleteFlight==true && $deletePassengerFlight==true ){
                $successMessage = "COMPANY and PASSENGER Balance are Updated successfully, and the flight is removed from Both Tables";
            }
            if (!empty($successMessage)) {
                header("Location: flights.php?successMessage=" . urlencode($successMessage));
                exit();
            }
            
        }
        
    ?>
        <script defer type="text/javascript" src="app.js"></script>

</body>
</html>
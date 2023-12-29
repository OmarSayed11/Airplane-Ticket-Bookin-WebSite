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
$userId = $_SESSION['user_id'];
$name = $iternary = $fees = $startTime = $endTime = $maxPassenger =$from=$to= $errors = '';
$numPassPending = '';
$numPassRegistered = '';

    if (
        isset($_POST['name']) && $_POST['name'] != '' &&
        isset($_POST['iternary']) && $_POST['iternary'] != "" &&
        isset($_POST['fees']) && $_POST['fees'] != "" &&
        isset($_POST['startTime']) && $_POST['startTime'] != "" &&
        isset($_POST['endTime']) && $_POST['endTime'] != "" &&
        isset($_POST['maxPassenger']) && $_POST['maxPassenger'] != "" &&
        isset($_POST['from']) && $_POST['from'] != "" &&
        isset($_POST['to']) && $_POST['to'] != "" 

    ) {
        $name = $_POST['name'];
        $iternary = $_POST['iternary'];
        $fees = $_POST['fees'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $maxPassenger = $_POST['maxPassenger'];
        $from=$_POST['from'];
        $to=$_POST['to'];
        $isCompleted='pending';
        if (empty($name)) {
            $errors['name'] = 'Invalid name';
        }
        if (empty($endTime) || empty($iternary) || empty($fees) || empty($startTime) || empty($maxPassenger)||empty($from) || empty($to)) {
            $errors['others'] = 'All fields are required';
        }
        $r=$con->query("SELECT name FROM cities WHERE id=".$from."");
        $current=$r->fetch_array(MYSQLI_ASSOC);
        $r2=$con->query("SELECT name FROM cities WHERE id=".$to."");
        $wanted=$r2->fetch_array(MYSQLI_ASSOC);

        if (empty($errors)) {
            $stmtAddFlight = $con->prepare("INSERT INTO flight (name, iternary, fees, startTime, endTime, companyId, maxPassengers,fromX,toX,numPassPending,numPassRegistered,isCompleted) VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)");
            $stmtAddFlight->bind_param('sssssiissiis', $name, $iternary, $fees, $startTime, $endTime, $userId, $maxPassenger,$current['name'],$wanted['name'],$numPassPending,$numPassRegistered,$isCompleted);
            $stmtAddFlight->execute();

            // Check if the insertion was successful
            if ($stmtAddFlight->affected_rows > 0) {
                echo "Flight added successfully!";
                header('Location: index.php');
            } else {
                echo "Failed to add flight!";
            }

            // Close the statement
            $stmtAddFlight->close();
        }
    }

?>
    <script>
        function validateCities() {
            var fromCity = document.getElementById("from").value;
            var toCity = document.getElementById("to").value;

            if (fromCity === toCity) {
                alert("From and To cities cannot be the same. Please choose again.");
                return false;
            }

            return true;
        }
    </script>

</head>
<body>
         <?php
            include_once('./header.php');
        ?> 
        <div class="disccc">
            <div class="add">ADD</div>
            <div class="addf">FLIGHT</div>
        </div>
    <form method="post" onsubmit="return validateCities();" class="custom-form">

    <div class="form-group">
    <label class="lab" for="name">Name:</label>
    <input class="inpp" type="text" name="name" required>
    </div>
    
    <div class="form-group">
    <label class="lab" for="iternary">Iternary:</label>
    <input class="inpp" type="text" name="iternary" required>
    </div>
    
    <div class="form-group">
    <label class="lab" for="fees">Fees:</label>
    <input class="inpp" type="number" name="fees"  required>
    </div>
    
    <div class="form-group">
    <label class="lab" for="maxPassenger">Max Passenger:</label>
    <input class="inpp" type="number" name="maxPassenger"  required>
    </div>

    <div class="form-group">
    <label class="lab" for="startTime">Start Time:</label>
    <input class="inpp" type="datetime-local" name="startTime"  required>
    </div>
    
    <div class="form-group">
    <label class="lab" for="endTime">End Time:</label>
    <input class="inpp" type="datetime-local" name="endTime"  required>
    </div>
    
    <div class="form-group">
    <label class="lab" for="from">From:</label>
    <select class="inpp" name="from" id="from">
        <?php
        require_once('../connection.php');
        $result = $con->query("SELECT * FROM cities");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            echo '<option class="inpp" value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        ?>
    </select>
    </div>
        
    <div class="form-group">
    <label class="lab" for="to">To:</label>
    <select class="inpp" name="to" id="to">
        <?php
        require_once('../connection.php');
        $result = $con->query("SELECT * FROM cities");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        ?>
    </select>
    </div>
    
    <input class="subbb" type="submit" name="Submit" value="Submit">
        
    </form>
    <?php
         include_once('./footer.php');
    ?>
        <script defer type="text/javascript" src="app.js"></script>

</body>
</html>
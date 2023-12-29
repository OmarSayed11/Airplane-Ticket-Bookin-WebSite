
    <div class="navvv">
      <div class="logo">
        <?php
              $p=$con->query("SELECT * FROM company WHERE id=$userId");
        $pp=$p->fetch_array(MYSQLI_ASSOC); ?>
        <div class="icon">
          <img src="img/<?php echo $pp['logoImg'] ;  ?>" alt="src" />
        </div>
        <div class="compname"><?php echo $pp['name'];  ?></div>
      </div>
      <div class="info">
        <a href="index.php" class="home hom">Home</a>
        <a href="flights.php" class="home">Flights</a>
        <a href="addFlight.php" class="home">Add Flight</a>
        <a href="profile.php" class="home">Profile</a>
        <button class="mess" onclick="toggleMsgCont()">Message</button>
        <form method="post">
          <button class="logout" type="submit" name="logout">Logout</button>
        </form>
      </div>
    </div>
    <?php
$message = $con->query("SELECT * FROM msgtocomp WHERE companyId='$userId' AND status='sent from passenger' ");
echo '<form method="post" class="msgform" action=""  id="msgForm" >';

while ($msg = $message->fetch_assoc()) {
    $passengerId = $msg['passengerId'];
    $passname = $msg['passname'];
    $companyid = $msg['companyId'];
    $messageText = $msg['message'];
    echo '
    <div class="msgcont">
        <div>Passenger <b>ID</b>: ' . $passengerId . ' </div>
        <div>Passenger <b>Name</b>: ' . $passname . ' </div>
        <div>Passenger <b>Message</b>: ' . $messageText . ' </div>
        <input type="hidden" name="passid" value="' . $passengerId . '">
        <input type="text" name="msg" placeholder="send message">
        <input type="submit" name="sendMsg" value="send message">
    </div>';
}

echo '</form>';
              
if (isset($_POST['msg']) && !empty($_POST['msg']) && isset($_POST['sendMsg']) && !empty($_POST['sendMsg']) && isset($_POST['passid']) && !empty($_POST['passid'])) {
    $passengerId = $_POST['passid'];
    $message = $_POST['msg'];

    // Insert the message into the database
    $sendMsg = $con->query("INSERT INTO msgtocomp (companyId, passengerId, passname, message, status) VALUES ($userId, $passengerId, '$passname', '$message', 'sent from company')");

    if ($sendMsg === true) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message: " . $con->error;
    }
     header("Location: index.php");
}
?>
 
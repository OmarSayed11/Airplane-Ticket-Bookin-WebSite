<div class="navvv">
      <div class="logo">
        <?php
         if (isset($_POST['logout'])) {
            // Destroy the session
            session_destroy();

            // Redirect to the login page
            header('Location: ../login.php');
            exit();
        }
              $p=$con->query("SELECT * FROM passenger WHERE id=$userId");
        $pp=$p->fetch_array(MYSQLI_ASSOC); ?>
        <div class="icon">
          <img src="img/<?php echo $pp['photo'] ; ?>" alt="src" />
        </div>
        <div class="compname"><?php echo $pp['name'];  ?></div>
      </div>
      <div class="info">
        <a href="index.php" class="home hom">Home</a>
        <a href="flights.php" class="home">Flights</a>
        <a href="search.php" class="home">Search</a>
        <a href="profile.php" class="home">Profile</a>
        <a href="currentFlights.php" class="home">Current Flights</a>
        <a href="completedFlights.php" class="home">Completed Flights</a>
        <button class="mess" onclick="toggleMsgCont()">Message</button>
        <button  class="mess" onclick="toggleMsgCont2()">My Messages</button>
        <form method="post">
          <button class="logout" type="submit" name="logout">Logout</button>
        </form>
      </div>
    </div>
    <div style="position: fixed;top: 55px;font-size: 17px;font-weight: bold;z-index: 800;left:140px;color: greenyellow;"><?php echo $pp['email'] ; ?></div>
    <div style="position: fixed;top: 56px;font-size: 17px;font-weight: bold;z-index: 800;left:265px;color: greenyellow;">:<?php echo $pp['tel'] ; ?></div>

 
 <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['send_message'])==true && $_POST['send_message']!='' && isset($_POST['company_id'])==true && $_POST['company_id']!='' && isset($_POST['message'])==true && $_POST['message']!='' ){
               $b=$con->query("SELECT * FROM passenger WHERE id=$userId");
               $k=$b->fetch_array(MYSQLI_ASSOC);
               $passname=$k['name'];
                $companyId=$_POST['company_id'];
                $message=$_POST['message'];
                $r2=$con->query("INSERT INTO msgtocomp ( passengerId,passname,companyId, message,status) VALUES ( $userId,'$passname',$companyId, '$message','sent from passenger')");
                if ($r2 === true) {
                    echo "Message sent successfully!";
                } else {
                    echo "Failed to send message: " . $con->error;
                }
                header("Location: index.php");
            }
        }



         $r=$con->query("SELECT id , name FROM company");
         if ($r === false) {
             echo "Failed to fetch companies: " . $con->error;
            } else{
                echo '
                <form method="post" action="#" class="msgform hh" id="msgForm">
                <div class="msgcontainer">
                <div class="comps">
                <label class="labbb">Select Company:</label>
                <select class="ssinp" name="company_id">
            ';
            while($row=$r->fetch_array(MYSQLI_ASSOC)){
                echo '
                <option value="' . $row['id'] . '">' . $row['name'] . '</option>
                ';
            }   
            echo '    </select>
                </div>
                <div class="compss">
                <label class="lab">Message:</label>
                <textarea name="message" class="messg" placeholder="Type your message here"></textarea>
                </div>
                <input type="submit" name="send_message" value="Send Message">
                </div>
                </form>
                ';
        }
            
    
    ?>
<?php
     
     $message = $con->query("SELECT * FROM msgtocomp WHERE passengerId=$userId AND status='sent from company' ");
     echo '<div method="post" class="msgform dd" action=""  id="msgForm2" >';
     
     while ($msg = $message->fetch_assoc()) {
         $passengerId = $msg['passengerId'];
         $passname = $msg['passname'];
         $companyid = $msg['companyId'];
         $k=$con->query("SELECT * FROM company WHERE id=$companyid");
         $kk=$k->fetch_array(MYSQLI_ASSOC);
         $messageText = $msg['message'];
         echo '
         <div class="msgcont">
             <div>Company <b>ID</b>: ' . $companyid . ' </div>
             <div>Company <b>Name</b>: ' . $kk['name'] . ' </div>
             <div>Company <b>Message</b>: ' . $messageText . ' </div>
         </div>';
     }
     
     echo '</div>';
     ?>
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
        <section class="slidercontainer">
      <div class="slider-wrapper" id="sliderWrapper">
        <div class="sliderrr">
          <img id="slide-1" src="img/france.png" alt="" />
          <img id="slide-2" src="img/italy.png" alt="" />
          <img id="slide-3" src="img/swisra.png" alt="" />
        </div>
        <div class="slider-nav" id="sliderNav">
          <a href="#" onclick="goToSlide(0)" class="active"></a>
          <a href="#" onclick="goToSlide(1)" ></a>
          <a href="#" onclick="goToSlide(2)"></a>
        </div>
      </div>
    </section>

        <div  class="aboutcont">
            
                <div  class="aboutimggg"><img style="width: 100%;height: 100%;" src="img/about2.png" alt=""></div>
                <div   class="abouttcontt">
                    <div class="textabout">ABOUT US</div>
                    <h1 class="abouth" >We Provide Best Tour <br> Packages In Your Budget</h1>
                    <div class="aboutd"><?php $pe=$con->query("SELECT name FROM company WHERE id=".$userId."");
                        $ppp=$pe->fetch_array(MYSQLI_ASSOC);
                    echo $ppp['name'];?> Airways is the second-largest airline in the United Arab Emirates, <br>headquartered in Abu Dhabi. Established in 2003,<br> offering both passenger and cargo services to destinations worldwide. Known for its luxurious amenities and innovative services</div>
                    <div  class="aboutimg" >
                    <div class="daaa" style="width: 250px;height: 250px;margin-right: 20px;margin-left: 50px;"><img style="width: 100%;height: 100%;object-fit: cover;" src="img/italy.png" alt=""></div>
                    <div class="daaa" style="width: 250px;height: 250px;"><img style="width: 100%;height: 100%;object-fit: cover;" src="img/n3.png" alt=""></div>
                 </div>
                    <a href="addFlight.php"  class="book">ADD FLIGHT</a>
                </div>
            
        </div>
        <div class="hbl" >
        <div class="hblo">
            <div class="hblimg" ><img  src="img/price.png"></div>
            <div >

            <div class="xxx" >Competitive Price</div>
            <div class="hbldisc" >Our company takes pride in <br>offering products and services at<br> a competitive price point.</div>
        </div>
        </div>
        <div class="hblo" >
            <div class="hblimg"><img  src="img/service.png"></div>
            <div >
                <div class="xxx" >Best Service</div>
                <div class="hbldisc" >At our company, delivering the best <br>service is not just a commitment <br> it's a passion. </div>
            </div>
            
        </div>
        <div class="hblo" >
            <div class="hblimg"><img  src="img/icon3.png"></div>
            <div>
            <div class="xxx" >Worldwide Coverage</div>
            <div class="hbldisc"  >With a commitment to global<br> excellence, our company extends<br> its reach far and wide</div>

        </div>
        </div>
    </div>

        
    <!-- <button type="submit" name="logout">Logout</button> -->
    <!-- <h1 style="margin-top: 200px;">Welcome, <?php echo $userEmail; ?>!</h1>
    <h1>Welcome, <?php echo $userId; ?>!</h1> -->
    <!-- <ul>
        <li><a href="flights.php"> Flights</a></li>
        <li><a href="addFlight.php">Add Flight</a></li>
        <li><a href="profile.php">Company Profile</a></li>
        <li><a href="messages.php">Messages</a></li>
        Add more links based on your project documentation -->
    <!-- </ul> -->
    <!-- <button style="margin-left: 750px;" onclick="toggleMsgCont()">Messages</button> -->
       

     <!-- Display additional information about the company -->
     <div class="ticcontainer" >
    <?php
    $stmtCompanyInfo = $con->prepare("SELECT * FROM company WHERE email = ?");
    $stmtCompanyInfo->bind_param('s', $_SESSION['user_email']);
    $stmtCompanyInfo->execute();
    $resultCompanyInfo = $stmtCompanyInfo->get_result();

    if ($resultCompanyInfo->num_rows > 0) {
        $row = $resultCompanyInfo->fetch_assoc();
    } else {

    }
      $pe=$con->query("SELECT logoImg FROM company WHERE id=".$userId."");
      $pep=$pe->fetch_array(MYSQLI_ASSOC);
      $p=$con->query("SELECT * FROM flight WHERE companyId=".$userId."");
      while($flights=$p->fetch_array(MYSQLI_ASSOC)){

        echo '    
  <a class="ticket" href="flight.php?from='.$flights['id'].' & companyId='.$flights['companyId'].'">
  
    <div class="logoimgg" ><img src="img/'.$pep['logoImg'].'"/></div>
    <div class="fromtickt">
    <div class="from">'.$flights['fromX'].'</div>
    <div class="starttime">'.date_format(new DateTime($flights['startTime']), 'H:i').'</div>
    <div class="startdate">'.date_format(new DateTime($flights['startTime']), 'F j').'</div>

    </div >
    <div class="iconnn"><img src="img/icon.png" alt="icon"></div>
    <div class="fromtickt">
    <div class="from">'.$flights['toX'].'</div>
    <div class="endtime">'.date_format(new DateTime($flights['endTime']), 'H:i').'</div>
    <div class="enddate">'.date_format(new DateTime($flights['endTime']), 'F j').'</div>
    </div>
</a>
        ';
      }


    ?>
         </div>
<?php
    include_once('./footer.php');
?>
    <script defer type="text/javascript" src="app.js"></script>

</body>
</html>





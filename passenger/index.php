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
      <a href="flights.php" class="book bk" >BOOK NOW</a>
    </section>


    <div  class="aboutcont">
            
            <div  class="aboutimggg"><img style="width: 100%;height: 100%;" src="img/about2.png" alt=""></div>
            <div   class="abouttcontt">
                <div class="textabout">ABOUT US</div>
                <h1 class="abouth" >We Provide Best Tour <br> Packages In Your Budget</h1>
                <div class="aboutd"> Airways is the second-largest airline in the United Arab Emirates, <br>headquartered in Abu Dhabi. Established in 2003,<br> offering both passenger and cargo services to destinations worldwide. Known for its luxurious amenities and innovative services</div>
                <div  class="aboutimg" >
                    <div class="daaa" style="width: 250px;height: 250px;margin-right: 20px;margin-left: 50px;"><img style="width: 100%;height: 100%;object-fit: cover;" src="img/italy.png" alt=""></div>
                    <div class="daaa" style="width: 250px;height: 250px;"><img style="width: 100%;height: 100%;object-fit: cover;" src="img/n3.png" alt=""></div>
                </div>
                <a href="flights.php"  class="book">BOOK NOW</a>
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
    
    <?php
    $stmtCompanyInfo = $con->prepare("SELECT * FROM passenger WHERE email = ?");
    $stmtCompanyInfo->bind_param('s', $_SESSION['user_email']);
    $stmtCompanyInfo->execute();
    $resultCompanyInfo = $stmtCompanyInfo->get_result();

    if ($resultCompanyInfo->num_rows > 0) {
        $row = $resultCompanyInfo->fetch_assoc();
    } else {

    }

    //   echo '
    //   <p>Passenger Name:  '.$row['name'].'  </p>
    //   <p>Passenger Email:  '.$row['email'].' </p>
    //   <p>Passenger Image: '.$row['photo'].' </p>
    //  <p>Telephone: '.$row['tel'].'</p>
    //   ';
    ?>
    <?php
        // $r=$con->query("SELECT * FROM flight ");
        // while($row=$r->fetch_array(MYSQLI_ASSOC)){
        //     echo '
        //     <a href="flight.php?from='.$row['id'].' && companyId='.$row['companyId'].'" style="border: 2px solid black;display: flex;flex-direction: column; margin-top:20px;" />
        //     <div>Company Id:<div>'.$row['companyId'].'</div></div>
        //     <div>Flight Name:<div>'.$row['name'].'</div></div>
        //     <div>iternary:<div>'.$row['iternary'].'</div></div>
        //     <div>fees<div>'.$row['fees'].'</div></div>
        //     <div>Start Time:<div>'.$row['startTime'].'</div></div>
        //     <div>end Time:<div>'.$row['endTime'].'</div></div>
        //     <div>From:<div>'.$row['fromX'].'</div></div>
        //     <div>To:<div>'.$row['toX'].'</div></div>
     
        //     ';
        // }

    ?>
    <div class="ticcontainer" >
    <?php
    
      $p=$con->query("SELECT * FROM flight ");
      while($flights=$p->fetch_array(MYSQLI_ASSOC)){
      $pe=$con->query("SELECT logoImg FROM company WHERE id=".$flights['companyId']."");
      $pep=$pe->fetch_array(MYSQLI_ASSOC);
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
        $pe='';
        $pep='';
    }


    ?>
         </div>
    <?php
        include_once('./footer.php');
    ?>
    <script defer type="text/javascript" src="app.js"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="compstyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
       
        if (isset($_GET['successMessage'])) {
            echo '<script>alert("' . htmlspecialchars($_GET['successMessage']) . '");</script>';
        }
    ?>
</head>
<body>  
    <?php
        include_once('./header.php');
    ?>
     <div class="disccc dad">
        <div class="add">Our</div>
        <div class="addf">Flights</div>
    </div>
        
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
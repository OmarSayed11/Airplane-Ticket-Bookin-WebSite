<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <?php
        require_once('./connection.php');
        session_start();
        if (isset($_SESSION['user_email']) && $_SESSION['user_type'] == 'passenger') {
          header('Location: passenger/index.php');
          exit();
      }elseif(isset($_SESSION['user_email']) && $_SESSION['user_type'] == 'company') {
        // Redirect to the login page if not logged in as a company
        header('Location: company/index.php');
        exit();
    }
    ?>
</head>
<body>
        <!-- <form method="post" action="login.php" >
            <label>Email:<input type="text" name="email"></label>
            <label>Password:<input type="password" name="password"></label>
            <input type="submit" value="Submit">
        </form> -->

        <section class="container">
  <div class="login-container">
    <div class="circle circle-one"></div>
    <div class="form-container">
      <img src="assets/airplane.png" alt="illustration" class="illustration" />
      <h1 class="opacity">LOGIN</h1>
      <form method="post" action="login.php">
        <input
          placeholder="EMAIL"
          type="email"
          id="email"
          class="form-control"
          name="email"
          required
        />
        <input
          placeholder="PASSWORD"
          type="password"
          id="password"
          class="form-control"
          name="password"
          required
        />
        <button
          class="opacity"
          type="submit"
          value="SUBMIT"
          id="login"
        >
          SUBMIT
        </button>
      </form>
      <div class="register-forget opacity">
        <a
          type="button"
          class="btn btn-primary"
          id="signup"
          href="index.php"
          >SIGNUP</a
        >
      </div>
    </div>
    <div class="circle circle-two"></div>
  </div>
  <div class="theme-btn-container"></div>
</section>

        <?php
            $email =$password ="";
            $errors = [];
            if(isset($_POST['email'])==true && $_POST['email']!="" &&
            isset($_POST['password'])==true && $_POST['password']!="")
            {
                $email=$_POST['email'];
                $password=$_POST['password'];
                if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $errors['email']='Invalid email address';
                }
                if(empty($password)){
                    $errors['password']='invalid password';
                }
            }
            $stmtCompany = $con->prepare("SELECT * FROM company WHERE email = ?");
            $stmtCompany->bind_param('s', $email);
            $stmtCompany->execute();

            // Get the result
            $resultCompany = $stmtCompany->get_result();
            

            // SQL query to retrieve user data based on the provided email (passenger)
            $stmtPassenger = $con->prepare("SELECT * FROM passenger WHERE email = ?");
            $stmtPassenger->bind_param('s', $email);
            $stmtPassenger->execute();

            // Get the result
            $resultPassenger = $stmtPassenger->get_result();

            // Check if the user exists in the company table
            if ($resultCompany->num_rows > 0) {
                $user = $resultCompany->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, user is authenticated
                    //store user information
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_type'] = 'company';
                    // Redirect to the company page
                    header('Location: company/index.php');
                    exit();
                } else {
                    // Incorrect password
                    echo "Incorrect password!";
                }
                
            } elseif ($resultPassenger->num_rows > 0) {
            // User exists in the passenger table
              $user = $resultPassenger->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, user is authenticated
                //store user information
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = 'passenger';
                // Redirect to the passenger page
                header('Location: passenger/index.php');
                exit();
            } else {
                // Incorrect password
                echo "Incorrect password!";
            }
        } 


        
        ?>
</body>
</html>
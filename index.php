<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>

    <?php
        require_once('./connection.php');
        include('./connection.php');
?>
</head>
<body>
    <?php
        $email = $name = $password = $tel = $type = '';
        $errors = [];
    ?>
        <!-- <form method="post" action="">
            <label>Email:<input type="text" name="email" value=""></label>
            <label>Name:<input type="text" name="name" value=""></label>
            <label>Password:<input type="password" name="password" value=""></label>
            <label>Telephone:<input type="telephone" name="tel" value=""></label>
            <label>Type:
                <select name="type">
                    <option value="company" ''>  Company</option>
                    <option value="passenger" > Passenger</option>
                </select>
        </label>
        <br>
            <input type="submit" name="register" value="SignUp">
            <a href="login.php">LOGIN</a>
        </form> -->
        <section class="container">
  <div class="login-container">
    <div class="circle circle-one"></div>
    <div class="form-container">
      <img src="assets/airplane.png" alt="illustration" class="illustration" />
      <h1 class="opacity">SIGNUP</h1>
      <form method="post" action="">
        <input
          placeholder="EMAIL"
          type="email"
          id="email"
          class="form-control"
          name="email"
          value=""
          required
          />
          <input
          placeholder="NAME"
          type="text"
          id="name"
          value=""
          class="form-control"
          name="name"
          required
          />
          <input
          placeholder="PASSWORD"
          type="password"
          id="password"
          value=""
          class="form-control"
          name="password"
          required
          />
          <input
          placeholder="TELEPHONE"
          type="telephone" 
          value=""
          name="tel"
          id="tel"
          value=""
          class="form-control"
          required
        />
        <select name="type">
                    <option value="company" <?= $type=== 'company' ? 'selected' : ''; ?>>  Company</option>
                    <option value="passenger" <?= $type=== 'passenger' ? 'selected' : ''; ?>> Passenger</option>
                </select>
        <button
          class="opacity"
          id="SIGNUP"
          type="submit" 
          name="register" 
          value="SignUp"
        >
          SIGNUP
        </button>
      </form>
      <div class="register-forget opacity">
        <a
          type="button"
          class="btn btn-primary"
          id="signup"
          href="login.php"
          >LOGIN</a
        >
      </div>
    </div>
    <div class="circle circle-two"></div>
  </div>
  <div class="theme-btn-container"></div>
</section>
        <?php
        
        
            if( isset($_POST['name'])== true && $_POST['name']!=""&&
            isset($_POST['email'])== true && $_POST['email']!=""&&
            isset($_POST['password'])== true && $_POST['password']!=""&&
            isset($_POST['tel'])== true && $_POST['tel']!=""&&
            isset($_POST['type'])== true && $_POST['type']!="")
            {
                $name=$_POST['name'];    
                $email=$_POST['email'];    
                $password=$_POST['password'];    
                $tel=$_POST['tel'];    
                $type=$_POST['type'];    
                


                if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $errors['email']='Invalid email address';
                }
                if(empty($name)||empty($password) || empty($tel) || empty($type)){
                    $errors['others']='All fields are required';
                }
                
                if($type === 'company'){
                    // $r = $con->query("INSERT INTO company VALUES (null,'$name','$hashedPassword','$email','$tel','','','','','','','')");
                    // if ($con->affected_rows == 0){
                    //     echo "faild";
                    // }
                    header("Location: companyReg.php?name=$name&email=$email&password=$password&tel=$tel");
                }
                elseif($type === 'passenger'){
                    // $r = $con->query("INSERT INTO passenger VALUES (null , '$name' , '$email', '$hashedPassword', '$tel','','','','','')");
                    // if ($con->affected_rows == 0){
                    //     echo "faild";
                    //     log("failed");
                    // }
                    header("Location: passengerReg.php?name=$name&email=$email&password=$password&tel=$tel");

                }
                exit();
            }
        ?>
</body>
</html>
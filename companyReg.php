<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <?php
        require_once('./connection.php');
    ?>
</head>
<body><?php
    $name= $email=$password =$tel='';
    $errors=[];
  
    $name=$_GET['name'];
    $email=$_GET['email'];
    $password=$_GET['password'];
    $tel=$_GET['tel'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
if(
isset($_POST['username'])==true && $_POST['username']!='' &&
isset($_POST['location'])==true && $_POST['location']!='' &&
isset($_POST['address'])==true && $_POST['address']!='' &&
isset($_POST['bio'])==true && $_POST['bio']!='' && 
isset($_POST['logoImg'])==true && $_POST['logoImg']!=''  
){

   
    $username = $_POST['username'];
    $location = $_POST['location'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];
    $logoImg = $_POST['logoImg'];

    if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email']='Invalid email address';
    }
    if(empty($name)||empty($password) || empty($tel) ||empty($address)||empty($bio) || empty($location) || empty($logoImg) || empty($username)){
        $errors['others']='All fields are required';
    }
  
   

     $r = $con->query("INSERT INTO company VALUES (null,'$name','$hashedPassword','$email','$tel','$bio','$address','$location','$username','$logoImg','','')");
                      if ($con->affected_rows == 0){
                          echo "faild" .$con->error;
                 }

           
                 header('Location: login.php');

}


                    

?>
    <!-- <form method="post" action="#">
        username:<input type="text" name="username">
        location:<input type="text" name="location">
        address:<input type="text" name="address">
        bio:<input type="text" name="bio">
        logoImg:<input type="file" name="logoImg">
        <input type="submit" value="submit">
        <a href="./login.php">LOGIN</a>
        


    </form> -->

    <section class="container">
  <div class="login-container">
    <div class="circle circle-one"></div>
    <div class="form-container">
      <img src="assets/airplane.png" alt="illustration" class="illustration" />
      <h1 class="opacity">COMPANY REGISTER</h1>
      <form method="post" action="#">
        <input
          placeholder="USERNAME"
          type="text"
          class="form-control"
          name="username"
          required
        />
        <input
          placeholder="LOCATION"
          type="text" 
          name="location"
          class="form-control"
          required
        />
        <input
          placeholder="ADDRESS"
          type="text" 
          name="address"
          class="form-control"
          required
        />
        <input
          placeholder="BIO"
          type="text" 
          name="bio"
          class="form-control"
          required
        />
        <input
          
          placeholder="LOGO IMG"
          type="file" 
          name="logoImg"
          class="form-control "
          required
        />
        <button
          class="opacity"
          type="submit"
          value="SUBMIT"
        >
          SUBMIT
        </button>
      </form>
      <div class="register-forget opacity">
        <a
          type="button"
          class="btn btn-primary"
          href="login.php"
          >LOGIN</a
        >
      </div>
    </div>
    <div class="circle circle-two"></div>
  </div>
  <div class="theme-btn-container"></div>
</section>


</body>
</html>
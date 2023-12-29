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
isset($_POST['photo'])==true && $_POST['photo']!='' &&
isset($_POST['passportImg'])==true && $_POST['passportImg']!='' 
){

   
    $photo = $_POST['photo'];
    $passportImg = $_POST['passportImg'];

    if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email']='Invalid email address';
    }
    if(empty($name)||empty($password) || empty($tel) ||empty($photo) || empty($passportImg)){
        $errors['others']='All fields are required';
    }

   

     $r = $con->query("INSERT INTO passenger VALUES (null,'$name','$email','$hashedPassword','$tel','$photo','$passportImg','','','')");
                      if ($con->affected_rows == 0){
                          echo "faild" .$con->error;
                 }

           
                 header('Location: login.php');

}


                    

?>
    <!-- <form method="post" action="#" ">
        Photo:<input type="file" name="photo">
        Passport Image:<input type="file" name="passportImg">
        <input type="submit" value="submit">
        <a href="./login.php">LOGIN</a>
        


    </form> -->

    <section class="container">
  <div class="login-container">
    <div class="circle circle-one"></div>
    <div class="form-container">
      <img src="assets/airplane.png" alt="illustration" class="illustration" />
      <h1 class="opacity">PASSENGER REGISTER</h1>
      <form method="post" action="#">
        <h3>PHOTO:</h3><input
          placeholder="PHOTO"
          type="file"
          class="form-control"
          name="photo"
          required
        />
        <h3>PASSPORT IMAGE:</h3>
        <input
          placeholder="PASSPORT IMAGE"
          type="file" 
          name="passportImg"
          class="form-control"
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
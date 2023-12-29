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

        $userId = $_SESSION['user_id'];

        // Handle form submission for updating company information
        if (isset($_POST['updateProfile'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $location = $_POST['location'];
            $address = $_POST['address'];
            $bio = $_POST['bio'];
            $password=$_POST['password'];
            $tel=$_POST['tel'];
            $logoImg = $_FILES['logoImg']['name'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Update company information
           
            if (!empty($logoImg)) {
                // Upload the new logo image
                $logoImgPath = basename($logoImg);
                move_uploaded_file($_FILES['logoImg']['tmp_name'], $logoImgPath);
        
                // Update company information with the new logo image path
                $updateQuery = "UPDATE company SET name = ?, email = ?, username = ?, location = ?, address = ?, bio = ?, password = ?, logoImg = ? WHERE id = ?";
                $stmt = $con->prepare($updateQuery);
                $stmt->bind_param("ssssssssi", $name, $email, $username, $location, $address, $bio, $hashedPassword, $logoImgPath, $userId);
            } else {
                // Update company information without changing the logo image
                $updateQuery = "UPDATE company SET name = ?, email = ?, username = ?, location = ?, address = ?, bio = ?, password = ? WHERE id = ?";
                $stmt = $con->prepare($updateQuery);
                $stmt->bind_param("sssssssi", $name, $email, $username, $location, $address, $bio, $hashedPassword, $userId);
            }
        
            // Execute the statement
            if ($stmt->execute()) {
                echo "Company information updated successfully!";
            } else {
                echo "Error updating company information: " . $stmt->error;
            }
            // Close the statement
            $stmt->close();
             header("Location: index.php");
        }

        // Fetch current company information
        $companyInfo = $con->query("SELECT * FROM company WHERE id = $userId")->fetch_assoc();
        
    ?>

</head>
<body>
    <?php
        include_once('./header.php');
        ?>
  <div class="disccc">
        <div class="add">UPDATE</div>
        <div class="addf">PROFILE</div>
    </div>

    <form method="post" enctype="multipart/form-data" class="custom-form">
        <div class="form-group">
            <label class="lab" for="name">Company Name:</label>
            <input class="inpp" type="text" name="name" value="<?php echo $companyInfo['name']; ?>" required>
        </div>
        <div class="form-group">
            <label class="lab" for="username">Company Username:</label>
            <input class="inpp" type="text" name="username" value="<?php echo $companyInfo['username']; ?>" required>
        </div>
        <div class="form-group">
            <label class="lab" for="password">Company Password:</label>
            <input class="inpp" type="password" name="password" value="" >
        </div>
        <div class="form-group">
            <label class="lab" for="name">Company Email:</label>
            <input class="inpp" type="email" name="email" value="<?php echo $companyInfo['email']; ?>" required>
        </div>
        
        <div class="form-group">
            <label class="lab" for="telephone">Telephone:</label>
            <input class="inpp" type="text" name="tel" value="<?php echo $companyInfo['tel']; ?>" required >
        </div>
        <div class="form-group">
            <label class="lab" for="bio">Bio:</label>
            <input class="inpp" type="text" name="bio" value="<?php echo $companyInfo['bio']; ?>" required>
        </div>
        <div class="form-group">
            <label class="lab" for="address">Address:</label>
            <input class="inpp" type="text" name="address" value="<?php echo $companyInfo['address']; ?>" required>
        </div>
        <div class="form-group">
            <label class="lab" for="location">Location:</label>
            <input class="inpp" type="text" name="location" value="<?php echo $companyInfo['location']; ?>" required>
        </div>

        <div class="form-group">
            <label class="lab" for="logoImg">Logo Image:</label>
            <input class="inpp" type="file" name="logoImg">
        </div>

        <input class="subbb" type="submit" name="updateProfile" value="Update Profile">
    </form>

    <?php

include_once('./footer.php');
    ?>
        <script defer type="text/javascript" src="app.js"></script>

</body>
</html>
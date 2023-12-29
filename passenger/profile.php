<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="passtyle.css">
    <title>Passenger Profile</title>
    <?php
require_once('../connection.php');
session_start();

if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== 'passenger') {
    // Redirect to the login page if not logged in as a passenger
    header('Location: ../login.php');
    exit();
}

$userEmail = $_SESSION['user_email'];
$userId = $_SESSION['user_id'];

// Handle form submission for updating passenger information
if (isset($_POST['updateProfile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    $passportImg = $_FILES['passportImg']['name'];
    $photo = $_FILES['photo']['name'];

    // Add validation and sanitation of input here

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update passenger information
    $updateQuery = "UPDATE passenger SET name = ?, email = ?, password = ?, tel = ? WHERE id = ?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("ssssi", $name, $email, $hashedPassword, $tel, $userId);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if new photo is selected
        if (!empty($photo)) {
            $imgPath = "img/" . basename($photo);
            move_uploaded_file($_FILES['photo']['tmp_name'], $imgPath);
            $updateFilesQuery = "UPDATE passenger SET photo = ? WHERE id = ?";
            $stmtFiles = $con->prepare($updateFilesQuery);
            $stmtFiles->bind_param("si", $imgPath, $userId);
            $stmtFiles->execute();
            $stmtFiles->close();
        }

        // Check if new passportImg is selected
        if (!empty($passportImg)) {
            $passportImgPath = "img/" . basename($passportImg);
            move_uploaded_file($_FILES['passportImg']['tmp_name'], $passportImgPath);
            $updateFilesQuery = "UPDATE passenger SET passportImg = ? WHERE id = ?";
            $stmtFiles = $con->prepare($updateFilesQuery);
            $stmtFiles->bind_param("si", $passportImgPath, $userId);
            $stmtFiles->execute();
            $stmtFiles->close();
        }

        echo "Passenger information updated successfully!";
    } else {
        echo "Error updating passenger information: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
    header("Location: index.php");
}

$passengerinfo = $con->query("SELECT * FROM passenger WHERE id = $userId")->fetch_assoc();
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
            <label class="lab" for="name">Passenger Name:</label>
            <input class="inpp" type="text" name="name" value="<?php echo $passengerinfo['name']; ?>" >
        </div>
        <div class="form-group">
            <label class="lab" for="email">Passenger Email:</label>
            <input class="inpp" type="email" name="email" value="<?php echo $passengerinfo['email']; ?>" >
        </div>
        <div class="form-group">
            <label class="lab" for="photo">Passenger Image:</label>
            <div  style="margin-left: 20px; width: 60px;height: 60px;"><img style="width: 100%;height: 100%;object-fit: cover;" src="<?php echo $passengerinfo['photo']; ?>"></div>
            <input class="inpp" type="file" name="photo" value="<?php echo $passengerinfo['photo']; ?>" >
        </div>
        <div class="form-group">
            <label class="lab" for="password">Password:</label>
            <input class="inpp" type="password" name="password" value="" >
        </div>
        <div class="form-group">
            <label class="lab" for="tel">Telephone:</label>
            <input class="inpp" type="text" name="tel" value="<?php echo $passengerinfo['tel']; ?>" >
        </div>
        <div class="form-group">
            <label class="lab" for="accountBalance">Account Balance:</label>
            <input class="inpp"  name="accountBalance" value="<?php echo $passengerinfo['accountBalance']; ?>" readonly>
        </div>
        <div class="form-group">
            <label class="lab" for="passportImg">Passport Image:</label>
            <div  style="margin-left: 20px; width: 60px;height: 60px;"><img style="width: 100%;height: 100%;object-fit: cover;" src="<?php echo $passengerinfo['passportImg']; ?>"></div>
            <input class="inpp" type="file" name="passportImg" value="<?php echo $passengerinfo['passportImg']; ?>" readonly>
        </div>
        <input class="subbb" type="submit" name="updateProfile" value="Update Profile">

    </form>

    <?php include_once('./footer.php'); ?>
    <script defer type="text/javascript" src="app.js"></script>
</body>

</html>

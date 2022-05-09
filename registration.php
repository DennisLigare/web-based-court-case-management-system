<?php

session_start();

require "db.php";

$user_type = "";
$message = "";
if ($_POST) {
  $statement = $pdo->prepare(
    "SELECT * FROM login WHERE login_username=:username"
  );
  $statement->bindValue(":username", $_POST['username']);
  $statement->execute();
  $login = $statement->fetch(PDO::FETCH_ASSOC);

  $user_type = $_POST['user_type'];
  if (!$login) {

    if ($user_type == 'admin') {
      $statement = $pdo->prepare(
        "INSERT INTO admin 
        (admin_name, admin_mobile, admin_email, admin_gender) 
        VALUES (:full_name, :mobile, :email, :gender)"
      );
    } elseif ($user_type == 'patient') {
      $statement = $pdo->prepare(
        "INSERT INTO patient 
        (patient_name, patient_mobile, patient_email, patient_gender, patient_location, patient_dob) 
        VALUES (:full_name, :mobile, :email, :gender, :location, :dob)"
      );
      $statement->bindValue(":location", $_POST['location']);
      $statement->bindValue(":dob", $_POST['dob']);
    } elseif ($user_type == 'specialist') {
      $statement = $pdo->prepare(
        "INSERT INTO specialist 
        (specialist_name, specialist_mobile, specialist_email, specialist_gender, specialist_location) 
        VALUES (:full_name, :mobile, :email, :gender, :location)"
      );
      $statement->bindValue(":location", $_POST['location']);
    }
    $statement->bindValue(":full_name", $_POST['full_name']);
    $statement->bindValue(":mobile", $_POST['mobile']);
    $statement->bindValue(":email", $_POST['email']);
    $statement->bindValue(":gender", $_POST['gender']);
    $statement->execute();

    $user_id = $pdo->lastInsertId();

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    if ($user_type == 'admin') {
      $statement = $pdo->prepare(
        "INSERT INTO login 
        (login_username, login_password, login_rank, login_admin_id) 
        VALUES (:username, :password, :rank, :user_id)"
      );
    } elseif ($user_type == 'patient') {
      $statement = $pdo->prepare(
        "INSERT INTO login 
        (login_username, login_password, login_rank, login_patient_id) 
        VALUES (:username, :password, :rank, :user_id)"
      );
    } elseif ($user_type == 'specialist') {
      $statement = $pdo->prepare(
        "INSERT INTO login 
        (login_username, login_password, login_rank, login_specialist_id) 
        VALUES (:username, :password, :rank, :user_id)"
      );
    }
    $statement->bindValue(":username", $_POST['username']);
    $statement->bindValue(":password", $password);
    $statement->bindValue(":rank", $user_type);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();

    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['user_type'] = $user_type;

    header("Location: index.php");
  } else {
    $message = "A user with the same username exists.";
  }
}

$full_name = $_POST['full_name'] ?? '';
$username = $_POST['username'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$email = $_POST['email'] ?? '';
$gender = $_POST['gender'] ?? '';
$location = $_POST['location'] ?? '';
$dob = $_POST['dob'] ?? '';

// $statement = $pdo->query(
//   "SELECT * FROM admin LIMIT 1"
// );
// $admin = $statement->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="./style/index.css">
  <title>Register</title>
</head>
<body>

<header id="header">
    <div class="display">
      <div class="logo-1">
        <img src="./img/CourtOfArms.png" alt="">
        <p>The Judiciary</p>
      </div>
      <div class="logo-2">
        <img src="./img/logo1.png" alt="">
        <span>Utumishi kwa wote.</span>
      </div>
    </div>

    <nav class="menu">
      <ul>
        <li><a href="./index.php" class="current">Home</a></li>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./registration.php">registration</a></li>
        <li><a href="#About">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>

      <div class="burger-container">
        <button><i class="fa fa-bars mobile-menu" aria-hidden="true"></i></button>
        <button><i class="fa fa-times-circle close-menu" aria-hidden="true"></i></button>
      </div>
    </nav>


  </header>

  <main class="main-form">

  <div class="container">

    <form method="POST" class="border w-75 mx-auto p-3 shadow-sm">
      <h1 class="form-header">Register</h1>
      
      <?php if ($message) : ?>
        <div class="alert alert-danger">
          <?php echo $message ?>
        </div>
      <?php endif; ?>
      <div class="mb-3">
        <label for="user_type" class="form-label fw-bold">User Type:</label>
        <select name="user_type" id="user_type" class="form-select" required>
          <option value="">Select user type...</option>
          <?php if (!$admin) : ?>
            <option value="admin" <?php echo $user_type == 'admin' ? 'selected' : '' ?>>Admin</option>
          <?php endif; ?>
          <option value="patient" <?php echo $user_type == 'patient' ? 'selected' : '' ?>>Patient</option>
          <option value="specialist" <?php echo $user_type == 'specialist' ? 'selected' : '' ?>>Specialist</option>
        </select>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="full_name" class="form-label fw-bold">Full Name:</label>
          <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $full_name ?>" placeholder="Enter full name" required>
        </div>
        <div class="col">
          <label for="username" class="form-label fw-bold">Username:</label>
          <input type="text" name="username" id="username" class="form-control" value="<?php echo $username ?>" placeholder="Enter username" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="mobile" class="form-label fw-bold">Phone Number:</label>
          <input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $mobile ?>" maxlength="10" placeholder="Enter phone number" required>
        </div>
        <div class="col">
          <label for="email" class="form-label fw-bold">Email:</label>
          <input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>" placeholder="Enter email" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-6">
          <label for="gender" class="form-label fw-bold">Gender:</label>
          <select name="gender" id="gender" class="form-select" required>
            <option value="">Select gender...</option>
            <option value="male" <?php echo $gender == 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?php echo $gender == 'female' ? 'selected' : '' ?>>Female</option>
          </select>
        </div>
        <div class="col-6 d-none" id="common_fields">
          <label for="location" class="form-label fw-bold">Location:</label>
          <input type="text" name="location" id="location" class="form-control" value="<?php echo $location ?>" placeholder="Enter location">
        </div>
      </div>
      <div class="row mb-3 d-none" id="patient_fields">
        <div class="col-6">
          <label for="dob" class="form-label fw-bold">Date of Birth:</label>
          <input type="date" name="dob" id="dob" class="form-control" value="<?php echo $dob ?>">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="password" class="form-label fw-bold">Password:</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
        <div class="col">
          <label for="confirm_password" class="form-label fw-bold">Confirm Password:</label>
          <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
        </div>
      </div>
      <div class="mb-3">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
      <p>Already have an account? <a href="login.php" class="link-primary">Login</a></p>
    </form>

  </div>

</main>

<footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  
</body>
</html>


<?php

session_start();

require "db.php";

$email = "";
$message = "";

if ($_POST) {
  $statement = $pdo->prepare(
    "SELECT * FROM login WHERE email=:email"
  );
  $statement->bindValue(":email", $_POST['email']);
  $statement->execute();
  $login = $statement->fetch(PDO::FETCH_ASSOC);

  if ($login) {
    if (password_verify($_POST['password'], $login['password'])) {

      $id = $login['admin_id'] ?? $login['individual_id'] ?? $login['organisation_id'] ?? $login['lawfirm_id'];

      if ($login['rank'] == 'admin') {
        $statement = $pdo->prepare(
          "SELECT * FROM admin WHERE id=:id"
        );
      } elseif ($login['rank'] == 'individual') {
        $statement = $pdo->prepare(
          "SELECT * FROM individual WHERE id=:id"
        );
      } elseif ($login['rank'] == 'organisation') {
        $statement = $pdo->prepare(
          "SELECT * FROM organisation WHERE organisation_id=:id"
        );
      } elseif ($login['rank'] == 'lawfirm') {
        $statement = $pdo->prepare(
          "SELECT * FROM lawfirm WHERE lawfirm_id=:id"
        );
      }
      $statement->bindValue(":id", $id);
      $statement->execute();
      $user = $statement->fetch(PDO::FETCH_ASSOC);

      $_SESSION['user_id'] = $user['admin_id'] ?? $user['individual_id'] ?? $user['organisation_id'] ?? $user['lawfirm_id'];
      $_SESSION['username'] = $user['name'] ?? $user['first_name'] ?? $user['organisation_name'] ?? $user['lawfirm_name'];
      $_SESSION['user_type'] = $login['rank'];

      header("Location: index.php");
    } else {
      $message = "You have entered an incorrect password.";
      $email = $_POST['email'];
    }
  } else {
    $message = "User does not exist.";
    $email = $_POST['email'];
  }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style/index.css"/>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
    integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
  <title>Login</title>
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
        <li><a href="./index.php" >Home</a></li>
        <li><a href="./login.php" class="current">Login</a></li>
        <li><a href="./registration.php">registration</a></li>
        <!-- <li><a href="#About">About</a></li>
        <li><a href="#contact">Contact</a></li> -->
      </ul>

      <div class="burger-container">
        <button><i class="fa fa-bars mobile-menu" aria-hidden="true"></i></button>
        <button><i class="fa fa-times-circle close-menu" aria-hidden="true"></i></button>
      </div>
    </nav>


  </header>

  <main class="my-3 flex-grow-1">

  <div class="container">

    <form method="POST" class="border w-50 mx-auto p-3 shadow-sm">
      <h1 class="text-center text-primary border-3 border-bottom border-primary pb-3">Login</h1>
      
      <?php if ($message) : ?>
        <div class="alert alert-danger">
          <?php echo $message ?>
        </div>
      <?php endif; ?>

      <div class="mb-3">
        <label for="email" class="form-label fw-bold">Email</label>
        <div class="input-group">
          <span class="input-group-text text-primary"><i class="fas fa-envelope"></i></span>
          <input type="text" name="email" id="email" class="form-control" value="<?php echo $email ?>" placeholder="Enter email" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label fw-bold">Password:</label>
        <div class="input-group">
          <span class="input-group-text text-primary"><i class="fas fa-key"></i></span>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
      </div>

      <div class="mb-3">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
      
      <p>Don't have an account? <a href="registration.php" class="link-primary">Register Now</a></p>
    </form>

  </div>

</main>


  
</body>
</html>
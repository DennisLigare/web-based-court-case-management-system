<?php

session_start();

require '../db.php';

$error_message = '';
$success_message = '';

if ($_POST) {

  $statement = $pdo->prepare(
    "SELECT * FROM login WHERE email=:email"
  );
  $statement->bindValue(":email", $_POST['email']);
  $statement->execute();
  $login = $statement->fetch(PDO::FETCH_ASSOC);

  if (!$login) {

    $statement = $pdo->prepare(
      "INSERT INTO lawfirm 
      (lawfirm_name, phone_number, email) 
      VALUES (:lawfirm_name, :phone_number, :email)"
    );
    $statement->bindValue(":lawfirm_name", $_POST['lawfirm_name']);
    $statement->bindValue(":phone_number", $_POST['phone_number']);
    $statement->bindValue(":email", $_POST['email']);
    $statement->execute();

    $user_id = $pdo->lastInsertId();

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $statement = $pdo->prepare(
      "INSERT INTO login 
      (email, password, rank, organisation_id) 
      VALUES (:email, :password, :rank, :user_id)"
    );
    $statement->bindValue(":email", $_POST['email']);
    $statement->bindValue(":password", $password);
    $statement->bindValue(":rank", 'admin');
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();

    $success_message = "User added successfully!";
  } else {
    $error_message = "A user with the same email already exists.";
  }
}

if ($_POST && $error_message) {
  $lawfirm_name = $_POST['lawfirm_name'];
  $phone_number = $_POST['phone_number'];
  $email = $_POST['email'];
} else {
  $lawfirm_name = '';
  $phone_number = '';
  $email = '';
  unset($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Court management system</title>
</head>

<body>

  <header id="header">
    <div class="display">
      <div class="logo-1">
        <img src="../img/CourtOfArms.png" alt="">
        <p>The Judiciary</p>
      </div>
      <div class="logo-2">
        <img src="../img/logo1.png" alt="">
        <span>Utumishi kwa wote.</span>
      </div>
    </div>

    <nav class="menu">
      <ul>
        <li><a href="dashboard.php" class="current">Dashboard</a></li>
        <li><a href="../logout.php">Logout</a></li>
      </ul>

      <div class="burger-container">
        <button><i class="fa fa-bars mobile-menu" aria-hidden="true"></i></button>
        <button><i class="fa fa-times-circle close-menu" aria-hidden="true"></i></button>
      </div>
    </nav>


  </header>

  <div id="main-dashboard">
    <div class="container">
      <div class="header">
        <h1>Add Lawfirm</h1>
        <div>
          <a href="lawfirms.php" class="secondary">Back</a>
        </div>
      </div>

      <form method="POST" class="border w-75 mx-auto p-3 shadow-sm">

        <?php if ($error_message) : ?>
          <div class="alert alert-danger">
            <?php echo $error_message ?>
          </div>
        <?php endif; ?>

        <?php if ($success_message) : ?>
          <div class="alert alert-success">
            <?php echo $success_message ?>
          </div>
        <?php endif; ?>

        <div class="mb-3">
          <div class="col">
            <label for="lawfirm_name" class="form-label fw-bold">LawFirm Name:</label>
            <input type="text" name="lawfirm_name" id="lawfirm_name" class="form-control" value="<?php echo $lawfirm_name ?>" placeholder="Enter lawfirm name" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label for="phone_number" class="form-label fw-bold">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $phone_number ?>" maxlength="10" placeholder="Enter phone number" required>
          </div>

          <div class="col">
            <label for="email" class="form-label fw-bold">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>" placeholder="Enter email" required>
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
        <div>
          <button type="reset" class="btn btn-secondary">Reset</button>
          <button type="submit" class="btn btn-warning">Add</button>
        </div>
      </form>

    </div>

  </div>


  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script src="../js/registration.js"></script>
  <script type="text/javascript" src="../js/mobilemenu.js"></script>
</body>

</html>
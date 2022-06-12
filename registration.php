<?php

session_start();


if ($_SESSION) {
  header('Location: index.php');
}


require "db.php";

$user_type = "";
$message = "";
$registration = false;

if ($_POST) {

  $statement = $pdo->prepare(
    "SELECT * FROM login WHERE email=:email"
  );
  $statement->bindValue(":email", $_POST['email']);
  $statement->execute();
  $login = $statement->fetch(PDO::FETCH_ASSOC);

  $user_type = $_POST['user_type'];
  
  if (!$login) {

    // Admin
    if ($user_type == 'admin') {
      $statement = $pdo->prepare(
        "INSERT INTO admin 
        (name, phone_number, email) 
        VALUES (:name, :phone_number, :email)"
      );
      $statement->bindValue(":name", $_POST['full_name']);
    } 
    // Individual fields
    elseif ($user_type == 'individual') {
      $statement = $pdo->prepare(
        "INSERT INTO individual 
        (first_name, last_name, phone_number, email, nationality, id_number) 
        VALUES (:first_name, :last_name, :phone_number, :email, :nationality, :id_number)"
      );
      $statement->bindValue(':first_name', $_POST['first_name']);
      $statement->bindValue(':last_name', $_POST['last_name']);
      $statement->bindValue(':nationality', $_POST['nationality']);
      $statement->bindValue(':id_number', $_POST['id_number']);
    }
    // organisation
    elseif ($user_type == 'organisation') {
      $statement = $pdo->prepare(
        "INSERT INTO organisation 
        (organisation_name,  phone_number, email) 
        VALUES (:organisation_name, :phone_number, :email)"
      );

      $statement->bindValue(':organisation_name', $_POST['organisation_name']);
    }
    // lawfirm
    elseif ($user_type == 'lawfirm') {
      $statement = $pdo->prepare(
        "INSERT INTO lawfirm 
        (lawfirm_name,  phone_number, email) 
        VALUES (:lawfirm_name, :phone_number, :email)"
      );

      $statement->bindValue(':lawfirm_name', $_POST['lawfirm_name']);
    }

    // Common fields
    $statement->bindValue(":phone_number", $_POST['phone_number']);
    $statement->bindValue(":email", $_POST['email']);
    $statement->execute();

    $user_id = $pdo->lastInsertId();

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if ($user_type == 'admin') {
      $statement = $pdo->prepare(
        "INSERT INTO login 
        (email, password, rank, admin_id) 
        VALUES (:email, :password, :rank, :user_id)"
      );
    } elseif ($user_type == 'individual') {
      $statement = $pdo->prepare(
        "INSERT INTO login 
        (email, password, rank, individual_id) 
        VALUES (:email, :password, :rank, :user_id)"
      );
      
    } elseif ($user_type == 'organisation') {
      $statement = $pdo->prepare(
        "INSERT INTO login 
        (email, password, rank, organisation_id) 
        VALUES (:email, :password, :rank, :user_id)"
      );
      
    }
     elseif ($user_type == 'lawfirm') {
      $statement = $pdo->prepare(
        "INSERT INTO login 
        (email, password, rank, lawfirm_id) 
        VALUES (:email, :password, :rank, :user_id)"
      );
      
    }

    $statement->bindValue(":email", $_POST['email']);
    $statement->bindValue(":password", $password);
    $statement->bindValue(":rank", $user_type);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();

    $registration = true;

  } else {
    $message = "A user with the same email already exists.";
  }
}

$full_name = $_POST['full_name'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$email = $_POST['email'] ?? '';
$location = $_POST['location'] ?? '';
$nationality = $_POST['nationality'] ?? '';
$id_number = $_POST['id_number'] ?? '';
$organisation_name = $_POST['organisation_name'] ?? '';
$lawfirm_name = $_POST['lawfirm'] ?? '';

$statement = $pdo->query(
  "SELECT * FROM admin LIMIT 1"
);
$admin = $statement->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
    integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;1,300;1,500&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        <li><a href="./index.php" >Home</a></li>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./registration.php" class="current">registration</a></li>
      </ul>

      <div class="burger-container">
        <button><i class="fa fa-bars mobile-menu" aria-hidden="true"></i></button>
        <button><i class="fa fa-times-circle close-menu" aria-hidden="true"></i></button>
      </div>
    </nav>


  </header>

  <?php if($registration) : ?>
    <main id="success" class="main-form">
      <div class="container">
        <div>
          <h1>Registration successfull.</h1>
          <p>Please <a href="login.php">login</a> to continue.</p>
        </div>
      </div>
    </main>  
  <?php else : ?>      
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
                <?php if (!$admin) : ?>
                <option value="admin" <?php echo $user_type == 'admin' ? 'selected' : '' ?>>Admin</option>
                <?php endif; ?>
                <option value="individual" <?php echo $user_type == 'individual' ? 'selected' : '' ?>selected >Individual</option>
                <option value="organisation" <?php echo $user_type == 'organisation' ? 'selected' : '' ?> >Organisation
                </option>
                <option value="lawfirm" <?php echo $user_type == 'lawfirm' ? 'selected' : '' ?> >Lawfirm</option>
              </select>
            </div>

            <!-- Admin -->
            <div id="admin_fields" class="mb-3">
              <div class="col">
                <label for="full_name" class="form-label fw-bold">Full Name:</label>
                <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $full_name ?>"
                  placeholder="Enter full name" required>
              </div>
            </div>
                  <!-- Individuals -->
            <div id="individual_fields">
              <div class="row mb-3">
                <div class="col">
                  <label for="first_name" class="form-label fw-bold">First Name:</label>
                  <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $first_name ?>"
                    placeholder="Enter first name" required>
                </div>
                <div class="col">
                  <label for="last_name" class="form-label fw-bold">Last Name:</label>
                  <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $last_name ?>"
                    placeholder="Enter last name" required>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col">
                  <label for="nationality" class="form-label fw-bold">Nationality</label>
                  <input type="text" name="nationality" id="nationality" class="form-control" value="<?php echo $nationality ?>"
                    placeholder="Enter nationality" required>
                </div>
                <div class="col">
                  <label for="id_number" class="form-label fw-bold">ID Number:</label>
                  <input type="text" name="id_number" id="id_number" class="form-control" value="<?php echo $id_number ?>"
                    placeholder="Enter ID number" required>
                </div>
              </div>
            </div>

            <!-- Organisation -->
            <div id="organisation_fields" class="mb-3">
              <div class="col">
                <label for="organisation" class="form-label fw-bold">Organisation Name:</label>
                <input type="text" name="organisation_name" id="organisation_name" class="form-control" value="<?php echo $organisation_name ?>"
                  placeholder="Enter organisation name" required>
              </div>
            </div>
              
            <!-- Lawfirm -->
            <div id="lawfirm_fields" class="mb-3">
              <div class="col">
                <label for="lawfirm" class="form-label fw-bold">lawfirm Name:</label>
                <input type="text" name="lawfirm_name" id="lawfirm_name" class="form-control" value="<?php echo $lawfirm_name ?>"
                  placeholder="Enter lawfirm name" required>
              </div>
            </div>
              
            <!-- Common fields -->
            <div class="row mb-3">
              <div class="col">
                <label for="phone_number" class="form-label fw-bold">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $phone_number ?>"
                  maxlength="10" placeholder="Enter phone number" required>
              </div>
              <div class="col">
                <label for="email" class="form-label fw-bold">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>"
                  placeholder="Enter email" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="password" class="form-label fw-bold">Password:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password"
                  required>
              </div>
              <div class="col">
                <label for="confirm_password" class="form-label fw-bold">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                  placeholder="Confirm password" required>
              </div>
            </div>
            <div >
              <button type="reset" class="btn btn-secondary">Reset</button>
              <button type="submit" class="btn">Register</button>
            </div>
            <p>Already have an account? <a href="login.php" class="login">Login</a></p>
          </form>
    
        </div>
    
      </main>

      <script src="js/registration.js"></script>
  <?php endif; ?>


  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>


</body>

</html>
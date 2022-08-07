<?php

session_start();

require '../db.php';

$success_message = '';

if ($_POST) {
  $statement = $pdo->prepare(
    "INSERT INTO judge
    (first_name, last_name, phone_number, email, case_type, room_id) 
    VALUES (:first_name, :last_name, :phone_number, :email, :case_type, :room_id)"
  );
  $statement->bindValue(":first_name", $_POST['first_name']);
  $statement->bindValue(":last_name", $_POST['last_name']);
  $statement->bindValue(":phone_number", $_POST['phone_number']);
  $statement->bindValue(":email", $_POST['email']);
  $statement->bindValue(":case_type", $_POST['case_type']);
  $statement->bindValue(":room_id", $_POST['room']);
  $statement->execute();

  $success_message = "Judge added successfully!";
}

$statement = $pdo->query("SELECT * FROM court_house");
$court_houses = $statement->fetchAll(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="../style/bootstrap.min.css">
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
        <h1>Add Judge</h1>
        <div>
          <a href="judges.php" class="secondary">Back</a>
        </div>
      </div>

      <form method="POST" class="border w-75 mx-auto p-3 shadow-sm">

        <?php if ($success_message) : ?>
          <div class="alert alert-success">
            <?php echo $success_message ?>
          </div>
        <?php endif; ?>

        <div id="individual_fields">
          <div class="row mb-3">
            <div class="col">
              <label for="first_name" class="form-label fw-bold">First Name:</label>
              <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter first name" required>
            </div>
            <div class="col">
              <label for="last_name" class="form-label fw-bold">Last Name:</label>
              <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter last name" required>
            </div>
          </div>
          <div class="row mb-3">


          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label for="phone_number" class="form-label fw-bold">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" maxlength="10" placeholder="Enter phone number" required>
          </div>
          <div class="col">
            <label for="email" class="form-label fw-bold">Email:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="case_type" class="form-label fw-bold">Case Type:</label>
            <select name="case_type" id="case_type" class="form-control" required>
              <option value="">Select case type...</option>
              <option value="theft">Theft</option>
              <option value="criminal_damage">Criminal Damage</option>
              <option value="public_disorder">Public Disorder</option>
              <option value="monitoring_offences">Monitoring Offences</option>
            </select>
          </div>
          <div class="col"></div>
        </div>
        <div class="row mb-3">
          <div class="col form-group">
            <label for="court_house">Court House</label>
            <select name="court_house" id="court_house" class="form-control">
              <option value="">Select court house...</option>
              <?php foreach ($court_houses as $court_house) : ?>
                <option value="<?php echo $court_house['id'] ?>"><?php echo $court_house['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col form-group">
            <label for="room">Room</label>
            <select name="room" id="room" class="form-control">
              <option value="">Select room...</option>
            </select>
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

  <script>
    const courtHouse = document.getElementById('court_house');
    const selectRoom = document.getElementById('room');

    courtHouse.addEventListener('change', () => {
      selectRoom.innerHTML = '<option value="">Select room...</option>'
      fetch(`get_rooms.php?id=${courtHouse.value}`).then(response => response.json()).then(rooms => {
        rooms.forEach(room => {
          const option = document.createElement('option')
          option.value = room.id
          option.innerText = room.room_number
          selectRoom.appendChild(option)
        })
      })

    })
  </script>
</body>

</html>
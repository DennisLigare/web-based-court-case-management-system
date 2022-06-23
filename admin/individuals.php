<?php

session_start();

require '../db.php';

$statement = $pdo->query("SELECT * FROM individual");
$individuals = $statement->fetchAll(PDO::FETCH_ASSOC);



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
        <h1>Manage Individuals</h1>
        <div>
          <a href="add_individual.php" class="primary">Add Individual</a>
          <a href="dashboard.php" class="secondary">Back</a>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Nationality</th>
            <th>Id Number</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($individuals as $i => $individual) : ?>
            <tr>
              <td><?php echo $i + 1 ?></td>
              <td><?php echo $individual['first_name'] ?></td>
              <td><?php echo $individual['last_name'] ?></td>
              <td><?php echo $individual['phone_number'] ?></td>
              <td><?php echo $individual['email'] ?></td>
              <td><?php echo $individual['nationality'] ?></td>
              <td><?php echo $individual['id_number'] ?></td>
              <td class="actions">
                <a href="edit_individual.php?id=<?php echo $individual['id'] ?>" class="edit"><i class="fa-solid fa-user-pen"></i></a>
                <!-- <a href="delete_individual.php?id=<?php echo $individual['id'] ?>" class="delete"><i class="fa-solid fa-trash-can"></i></a> -->
                <form action="delete_individual.php" method="POST">
                  <input type="hidden" name="individual_id" value="<?php echo $individual['id'] ?>">
                  <button type="submit" class="delete"><i class="fa-solid fa-trash-can"></i></button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>

  <footer>
    <p>WBCCMS &copy; 2022, All Rights Reserved</p>
  </footer>

  <script type="text/javascript" src="./js/mobilemenu.js"></script>
</body>

</html>
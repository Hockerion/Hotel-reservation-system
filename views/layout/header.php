<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" type="text/css" href="styles/main_style.css">
</head>

<body>
  <nav>
    <ul class="navbar">
      <li><a href="/">Home</a></li>
      <li><a href="/reviews">Reviews</a></li>
      <li><a href="/rooms">Rooms</a></li>
    
      <!-- If the user is logged in, Booking, Profile View, and Logout
            are available to them. -->
      <?php if (isset($_SESSION['id']) && isset($_SESSION['username'])): ?>
        <li><a href="/booking">Booking</a></li>

        <!-- Rating is only accessible if a user has booked a room before. -->
        <?php if ($_SESSION['booked'] == true): ?>
          <li><a href="/rating">Rating</a></li>
        <?php endif; ?>

        <li class="login">
          <div class="dropdown">
            <button class="dropbtn">Profile</button>
            <div class="dropdown-content">
              <a href="/user">View Profile</a>
              <a href="/logout">Logout</a>
            </div>
          </div>
        </li>

      <!-- If the user is not logged in, Login and Signup
          are available to them. -->
      <?php else: ?>
        <li class="login">
          <div class="dropdown">
            <button class="dropbtn">Login</button>
            <div class="dropdown-content">
              <a href="/login-member">Member Login</a>
              <a href="/login-employee">Employee Login</a>
            </div>
          </div>
        </li>
      <?php endif; ?>

    </ul>
  </nav>
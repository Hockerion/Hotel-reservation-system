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
      <li><a href="/emp-panel">Home</a></li>
      <li><a href="/discounts">Discounts</a></li>
      <li><a href="/add-discount">Add Discount</a></li>
  
      <li class="login">
        <div class="dropdown">
          <button class="dropbtn">Profile</button>
          <div class="dropdown-content">
            <a href="/emp">View Profile</a>
            <a href="/logout">Logout</a>
          </div>
        </div>
      </li>

    </ul>
  </nav>
<?php
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login & Registration Form</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="cont">
    <div class="form sign-in">
      <h2>Welcome to Digital Recipie</h2>
      <h3 align="center">Please enter your Login credentials</h3>
      <br>
      <form action="login.php" method="post">
        <label>
          <span>Username</span>
          <input type="text" id="loginName" name="name" required>
        </label>
        <label>
          <span>Password</span>
          <input type="password" id="loginPassword" name="password" required>
        </label>
        <button class="submit" type="submit">Login</button>
      </form>
      <div class="social-media">
        <ul>
          <li><img src="images/facebook.png"></li>
          <li><img src="images/twitter.png"></li>
          <li><img src="images/linkedin.svg"></li>
          <li><img src="images/instagram.svg"></li>
        </ul>
      </div>
    </div>
    <div class="sub-cont">
      <div class="img" style="background-color:#987752;">
        <div class="img-text m-up">
          <h1>New here?</h1>
            <br>
          <p>Sign up</p>
          <br>
          <img  src="images/logo.jpeg" style="width: 150px; height: 150px; padding-right: 15px;">
        </div>
        <div class="img-text m-in">
          <h1>One of us?</h1>
          <p>just Login</p>
          <br>
          <img src="images/logo.jpeg" style="width: 150px; height: 150px; padding-right: 15px;">
        </div>
        <div class="img-btn">
          <span class="m-up" onclick="toggleForm('sign-up')">Sign Up</span>
          <span class="m-in" onclick="toggleForm('sign-in')">Login</span>
        </div>
      </div>
      <div class="form sign-up">
        <h2>Sign Up</h2>
        <form action="SignUp.php" method="post">
          <label>
            <span>Name</span>
            <input type="text" id="signupFullName" name="name" required>
          </label>
          <label>
            <span>Email</span>
            <input type="email" id="signupEmail" name="email" required>
            <p></p>
          </label>
        
          <label>
            <span>Password</span>
            <input type="password" id="signupPassword" name="password" required>
            <p class="error password-error"></p>
          </label>
          
       
         
          <button type="submit" class="submit">Sign Up Now</button>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="script.js"></script>

</body>
</html>
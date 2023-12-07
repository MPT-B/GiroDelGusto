<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../public/css/global.css" />
  <link rel="stylesheet" href="../../public/css/login.css" />
  <title>GiroDelGusto</title>

  <link rel="apple-touch-icon" sizes="180x180" href="../../public/icons/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../public/icons/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../public/icons/favicons/favicon-16x16.png">
  <link rel="manifest" href="../../public/icons/favicons/site.webmanifest">
  <link rel="mask-icon" href="../../public/icons/favicons/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
</head>

<body>
  <div class="login-container">
    <div class="logo">
      <img src="../../public/data/logo_giro_del_gusto_ORIGINAL.png" alt="Giro Del Gusto Logo" />
    </div>
    <h1>Welcome Back!</h1>
    <p>Please login to your account</p>
    <div class="messages">

      <?php
      if (isset($messages)) {
        foreach ($messages as $message) {
          echo $message;
        }
      } ?>
    </div>
    <form action="login" method="POST">
      <input id='email' type="email" name="email" placeholder="Email" />
      <input id='password' type="password" name="password" placeholder="Password" />
      <a href="forgotpasssword">Forgot Password?</a>
      <button type="submit">LOGIN</button>
    </form>
    <p>Don't have an account? <a href="signup">SIGN UP</a></p>
  </div>
</body>

</html>
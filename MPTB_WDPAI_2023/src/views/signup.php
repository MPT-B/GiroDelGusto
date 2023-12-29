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
    <h1>Welcome!</h1>
    <p>Create a new account</p>
    <?php
    if (isset($messages)) {
      foreach ($messages as $message) {
        echo $message;
      }
    } ?>
    <form action="signup" method="post">
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="password" name="passwordConfirmation" placeholder="Password Confrimation" required />
      <button type="submit">SIGN UP</button>
    </form>
    <p>Already registered? <a href="login">LOGIN</a></p>
  </div>
</body>

</html>
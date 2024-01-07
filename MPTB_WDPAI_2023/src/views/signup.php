<? include 'head.php'; ?>

<link rel="stylesheet" href="../../public/css/forms.css" />

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
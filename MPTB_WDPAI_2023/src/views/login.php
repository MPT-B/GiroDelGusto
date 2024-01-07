<?php include 'head.php'; ?>
<link rel="stylesheet" href="../../public/css/forms.css" />
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
      <button type="submit">LOGIN</button>
    </form>
    <p>Don't have an account? <a href="signup">SIGN UP</a></p>
  </div>
</body>

</html>
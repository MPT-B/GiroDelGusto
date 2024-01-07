<? include 'head.php'; ?>
<? include 'phpRepository.php'; ?>

<link rel="stylesheet" href="../../public/css/forms.css" />

<body>

    <div class="login-container">
        <div class="logo">
            <img src="../../public/data/Logo.png" alt="Giro Del Gusto Logo" />
        </div>
        <h1>Update profile</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // clear the error message after displaying it
        }
        ?>
        <form action="updateProfile" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user->getUsername()); ?>" required />

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <label for="passwordConfirmation">Confirm Password:</label>
            <input type="password" id="passwordConfirmation" name="passwordConfirmation" required />

            <label for="bio">Bio:</label>
            <textarea name="bio" id="bio" cols="40" rows="5"><?php echo htmlspecialchars($userProfile->getBio()); ?></textarea>

            <button type="submit">UPDATE PROFILE</button>
            <button type="button" onclick="window.location.href='mainmenu';">GO BACK</button>
        </form>
    </div>
</body>

</html>
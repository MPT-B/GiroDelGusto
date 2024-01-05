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
    <?php
    $userRepository = new UserRepository();
    $user = $userRepository->getUserByEmail($_SESSION['email']);
    $userProfile = $userRepository->getUserProfile($user->getId());
    ?>
    <div class="login-container">
        <div class="logo">
            <img src="../../public/data/Logo.png" alt="Giro Del Gusto Logo" />
        </div>
        <h1>Update profile</h1>

        <form action="updateProfile" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user->getUsername()); ?>" required />

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <label for="passwordConfirmation">Confirm Password:</label>
            <input type="password" id="passwordConfirmation" name="passwordConfirmation" required />
            <!-- 
            <label for="likes">What You Like to Eat:</label>
            <input type="text" id="likes" name="likes" value="<?php echo htmlspecialchars($userProfile->getFavoriteCuisines()); ?>" required /> -->

            <label for="bio">Bio:</label>
            <textarea name="bio" id="bio" cols="40" rows="5"><?php echo htmlspecialchars($userProfile->getBio()); ?></textarea>

            <button type="submit">UPDATE PROFILE</button>
        </form>
    </div>
</body>

</html>
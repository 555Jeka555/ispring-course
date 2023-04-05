<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>laba4</title>
</head>
<body>
    <div>
        <h1><?= htmlentities($user->getSecondName()) ?></h1>
        <h2><?= htmlentities($user->getFirstName()) ?></h2>
        <?php if ($user->getMiddleName()) : ?>
            <h3><?= htmlentities($user->getMiddleName()) ?></h3>
        <?php endif; ?>
        <p><?= htmlentities($user->getGender()) ?></p>
        <p><?= htmlentities($user->getBirthDate()) ?></p>
        <p><?= htmlentities($user->getEmail()) ?></p>
        <?php if ($user->getPhone()) : ?>
            <h3><?= htmlentities($user->getPhone()) ?></h3>
        <?php endif; ?>
        <?php if ($user->getAvatarPath()) : ?>
            <h3><?= htmlentities($user->getAvatarPath()) ?></h3>
        <?php endif; ?>
    </div>
</body>
</html>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>laba2/3</title>
</head>
<body>
    <div>
        <h1><?= htmlentities($user["second_name"]) ?></h1>
        <h2><?= htmlentities($user["first_name"]) ?></h2>
        <?php if ($user["middle_name"]) : ?>
            <h3><?= htmlentities($user["middle_name"]) ?></h3>
        <?php endif; ?>
        <p><?= htmlentities($user["gender"]) ?></p>
        <p><?= htmlentities($user["birth_date"]) ?></p>
        <p><?= htmlentities($user["email"]) ?></p>
        <?php if ($user["phone"]) : ?>
            <h3><?= htmlentities($user["phone"]) ?></h3>
        <?php endif; ?>
        <?php if ($user["avatar_path"]) : ?>
            <h3><?= htmlentities($user["avatar_path"]) ?></h3>
        <?php endif; ?>
    </div>
</body>
</html>

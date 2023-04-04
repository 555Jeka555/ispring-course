<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>laba2/3</title>
</head>
<body>
    <form action="3register.php" method="POST">
        <p>Фамилия : <input type="text" name="surname" required/></p>
        <p>Имя : <input type="text" name="name" required/></p>
        <p>Отчество : <input type="text" name="fatherName"/></p>
        <p>Пол : 
            <input type="radio" name="sex" value="man" required/> Мужской <br>
            <input type="radio" name="sex" value="woman" required/> Женский <br>
        </p>
        <p>Дата рождения : <input type="date" name="age" min="1980-01-01" max="2023-12-31" required/></p>
        <p>Email : <input type="text" name="email" required/></p>
        <p>Телефон : <input type="text" name="phone"/></p>
        <p>Аватар : <input type="file" name="avatar"/></p>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>
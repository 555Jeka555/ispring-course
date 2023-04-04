<?php

require_once(__DIR__ . "/User.php");

// function findUserInDatabase(PDO $connection, int $userId): ?array
// {
//     $query = <<< SQL
//         SELECT
//             user_id, first_name, second_name, 
//             middle_name, gender, birth_date, email, phone, avatar_path
//         FROM user
//         WHERE user_id = $userId
//     SQL;

//     $statement = $connection->query($query);
//     $row = $statement->fetch(PDO::FETCH_ASSOC);
//     if (!$row)
//     {
//         throw new RuntimeException("User with id $userId not found");
//     }
//     return $row;
// }

function collectData(array $userParams): array|null
{
    $error = false;
    if (isset($_GET["second_name"]))
    {
        $second_name = $_GET["second_name"];
        $userParams["second_name"] = $second_name;
        if (count(array_filter(str_split($second_name), "is_numeric")) > 0 ) $error = true;
    }
    if (isset($_GET["first_name"]))
    {
        $first_name = $_GET["first_name"];
        $userParams["first_name"] = $first_name;
        if (count(array_filter(str_split($first_name), "is_numeric")) > 0) $error = true;
    }
    if (isset($_GET["middle_name"]))
    {
        $middle_name = $_GET["middle_name"];
        $userParams["middle_name"] = $middle_name;
        if (count(array_filter(str_split($middle_name), "is_numeric")) > 0) $error = true;
    }
    if (isset($_GET["gender"]))
    {
        $gender = $_GET["gender"];
        $userParams["gender"] = $gender;
    }
    if (isset($_GET["birth_date"]))
    {
        $birth_date = $_GET["birth_date"];
        $userParams["birth_date"] = $birth_date;
    }
    if (isset($_GET["email"]))
    {
        $email = $_GET["email"];
        $userParams["email"] = $email;
        $email_validation_regex = '/^\\S+@\\S+\\.\\S+$/'; 
        if (!(preg_match($email_validation_regex, $email))) $error = true;
    }
    if (isset($_GET["phone"]))
    {
        $phone = $_GET["phone"];
        if (!is_numeric($phone)) $error = true;
        if (!$error)
        {
            $userParams["phone"] = (int)$phone;
        }
    }
    if (isset($_GET["avatar_path"]))
    {
        $avatar_path = $_GET["avatar_path"];
        $userParams["avatar_path"] = $avatar_path;
    }

    if ($error)
    {
        return null;
    }
    else
    {
        return $userParams;
    }
}

function collectDataInClass(): User|null
{
    $error = false;
    $userParams = [];
    if (isset($_GET["second_name"]))
    {
        $second_name = $_GET["second_name"];
        $userParams["second_name"] = $second_name;
        if (count(array_filter(str_split($second_name), "is_numeric")) > 0 ) $error = true;
    }
    if (isset($_GET["first_name"]))
    {
        $first_name = $_GET["first_name"];
        $userParams["first_name"] = $first_name;
        if (count(array_filter(str_split($first_name), "is_numeric")) > 0) $error = true;
    }
    if (isset($_GET["middle_name"]))
    {
        $middle_name = $_GET["middle_name"];
        $userParams["middle_name"] = $middle_name;
        if (count(array_filter(str_split($middle_name), "is_numeric")) > 0) $error = true;
    }
    if (isset($_GET["gender"]))
    {
        $gender = $_GET["gender"];
        $userParams["gender"] = $gender;
    }
    if (isset($_GET["birth_date"]))
    {
        $birth_date = $_GET["birth_date"];
        $userParams["birth_date"] = $birth_date;
    }
    if (isset($_GET["email"]))
    {
        $email = $_GET["email"];
        $userParams["email"] = $email;
        $email_validation_regex = '/^\\S+@\\S+\\.\\S+$/'; 
        if (!(preg_match($email_validation_regex, $email))) $error = true;
    }
    if (isset($_GET["phone"]))
    {
        $phone = $_GET["phone"];
        if (!is_numeric($phone)) $error = true;
        if (!$error)
        {
            $userParams["phone"] = (int)$phone;
        }
    }
    if (isset($_GET["avatar_path"]))
    {
        $avatar_path = $_GET["avatar_path"];
        $userParams["avatar_path"] = $avatar_path;
    }

    if ($error)
    {
        return null;
    }
    else
    {
        return new User(null, $userParams["first_name"], $userParams["second_name"], $userParams["middle_name"], $userParams["gender"], $userParams["birth_date"], $userParams["email"], $userParams["phone"], $userParams["avatar_path"]);
    }
}

function getConnectionParams(): array
{   
    $result = [];
    $file = file_get_contents("config.json");
    $data = json_decode($file, true);
    $result["host"] = $data["database"]["host"];
    $result["dbname"] = $data["database"]["dbname"];
    $result["user"] = $data["database"]["user"];
    $result["password"] = $data["database"]["password"];
    return $result;
}

function connectDatabase(): PDO
{
    $connectionParams = getConnectionParams();
    $host = $connectionParams["host"];
    $dbname = $connectionParams["dbname"];
    $dsn = "mysql:host=$host;dbname=$dbname;port=3306";
    $user = $connectionParams["user"];
    $password = $connectionParams["password"];
    return new PDO($dsn, $user, $password);
}

function saveUserToDatabase(PDO $connection, array $userParams): int
{
    $query = <<< SQL
        INSERT INTO user (first_name, second_name, 
            middle_name, gender, birth_date, email, phone, avatar_path)
        VALUES (:first_name, :second_name, :middle_name, :gender,
             :birth_date, :email, :phone, :avatar_path
            )
    SQL;

    try
    {
        $statement = $connection->prepare($query);
        $statement->execute([
            ":first_name" => $userParams["first_name"], 
            ":second_name" => $userParams["second_name"],
            ":middle_name" => $userParams["middle_name"],
            ":gender" => $userParams["gender"],
            ":birth_date" => $userParams["birth_date"], 
            ":email" => $userParams["email"],
            ":phone" => $userParams["phone"], 
            ":avatar_path" => $userParams["avatar_path"]
        ]);
    }
    catch (Exception $e)
    {
        echo "Такой пользователь уже создан ";
        echo $e->getMessage();
        exit();
    }
    

    return $connection->lastInsertId();
}

function saveUserToDatabaseWithClass(PDO $connection, User $user): int
{
    $query = <<< SQL
        INSERT INTO user  (first_name, second_name, 
            middle_name, gender, birth_date, email, phone, avatar_path)
        VALUES (:first_name, :second_name, :middle_name, :gender,
             :birth_date, :email, :phone, :avatar_path
            )
    SQL;

    $statement = $connection->prepare($query);
    $statement->execute([
        ":first_name" => $user->getFirstName(), 
        ":second_name" => $user->getSecondName(),
        ":middle_name" => $user->getMiddleName(), 
        ":gender" => $user->getGender(),
        ":birth_date" => $user->getBirthDate(), 
        ":email" => $user->getEmail(),
        ":phone" => $user->getPhone(), 
        ":avatar_path" => $user->getAvatarPath()
    ]);

    return $connection->lastInsertId();
}

$userParams = [];
$userParams = collectData($userParams);

//$user = collectDataInClass();
if ($userParams === null)
{
    echo "Данные введены не правильно, попробуйте ещё раз";
}
else
{
    echo count($userParams) . count($_GET);
    // foreach ($userParams as $u)
    // {
    //     echo $u . " ";
    // }
    $connection = connectDatabase();
    $userId = saveUserToDatabase($connection, $userParams);
    
    // $array = findUserInDatabase($connection, $userId);
    // foreach ($array as $u)
    // {
    //     echo $u . " ";
    // }

    $userId = saveUserToDatabaseWithClass($connection, $user);
    $redirectUrl = "show_user_script.php/?user_id=$userId";
    header('Location: ' . $redirectUrl, true, 303);
    die();
}


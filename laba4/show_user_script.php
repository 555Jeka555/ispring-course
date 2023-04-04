<?php
require_once(__DIR__ . "/User.php");

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

function findUserInDatabase(PDO $connection, int $userId): ?array
{
    $query = <<< SQL
        SELECT
            user_id, first_name, second_name, 
            middle_name, gender, birth_date, email, phone, avatar_path
        FROM user
        WHERE user_id = $userId
    SQL;

    $statement = $connection->query($query);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row)
    {
        throw new RuntimeException("User with id $userId not found");
    }
    return $row;
}

function findUserInDatabaseWithClass(PDO $connection, int $userId): ?User
{
    $query = <<< SQL
        SELECT
            user_id, first_name, second_name, 
            middle_name, gender, birth_date, email, phone, avatar_path
        FROM php_course
        WHERE user_id = $userId
    SQL;

    $statement = $connection->query($query);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$row)
    {
        throw new RuntimeException("User with id $userId not found");
    }
    return new User($row["user_id"], $row["first_name"], $row["second_name"], $row["middle_name"], $row["gender"], $row["birth_date"], $row["email"], $row["phone"], $row["avatar_path"]);
}

$userId = (int)$_GET["user_id"];
$connection = connectDatabase();
$user = findUserInDatabase($connection, $userId);

require_once __DIR__ . "/show_user.php";

//$user = findUserInDatabaseWithClass($connection, $userId);
//require __DIR__ . "/show_user_class.php";
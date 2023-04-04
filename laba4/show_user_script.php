<?php
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/register.php");

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
echo $userId;
$connection = connectDatabase();
$user = findUserInDatabase($connection, $userId);
echo "Show_user_script";

require_once __DIR__ . "/show_user.php";

//$user = findUserInDatabaseWithClass($connection, $userId);
//require __DIR__ . "/show_user_class.php";
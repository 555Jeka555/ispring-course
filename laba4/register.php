<?php

require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/database.php");


//TODO use array_fillter 
function collectData(array $userParams): array
{
   
    $USER_FIELDS = ["second_name", "first_name", "middle_name", "gender", "birth_date", "avatar_path"];
    foreach ($USER_FIELDS as $key)
    {
        if (isset($_POST[$key]))
        {
            $userParams[$key] = $_POST[$key];
        }
    }

    if (isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $userParams["email"] = $email;
        $email_validation_regex = "/^\\S+@\\S+\\.\\S+$/"; 
        if (!(preg_match($email_validation_regex, $email))) 
        {
            throw new RuntimeException("Неккоректный ввод");
        }
        
    }
    if (isset($_POST["phone"]))
    {
        $phone = $_POST["phone"];
        if (!is_numeric($phone)) 
        {
            throw new RuntimeException("Неккоректный ввод");
        }
        $userParams["phone"] = (int)$phone;
        
    }
    return $userParams;
}


function collectDataInClass(array $userParams): User
{
   
    $USER_FIELDS = ["second_name", "first_name", "middle_name", "gender", "birth_date", "avatar_path"];
    foreach ($USER_FIELDS as $key)
    {
        if (isset($_POST[$key]))
        {
            $userParams[$key] = $_POST[$key];
        }
    }

    if (isset($_POST["email"]))
    {
        $email = $_POST["email"];
        $userParams["email"] = $email;
        $email_validation_regex = "/^\\S+@\\S+\\.\\S+$/"; 
        if (!(preg_match($email_validation_regex, $email))) 
        {
            throw new RuntimeException("Неккоректный ввод");   
        }
    }
    if (isset($_POST["phone"]))
    {
        $phone = $_POST["phone"];
        if (!is_numeric($phone)) 
        {
            throw new RuntimeException("Неккоректный ввод");
        }
        $userParams["phone"] = (int)$phone;
        
    }
    return new User(null, $userParams["first_name"], $userParams["second_name"], $userParams["middle_name"], $userParams["gender"], $userParams["birth_date"], $userParams["email"], $userParams["phone"], $userParams["avatar_path"]);
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
        //TODO Отдавать 400 код статуса
        echo "Такой пользователь уже создан ";
        //echo $e->getMessage();
        header("Status: 400 Bad Request", true, 400);
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
    try
    {
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
    }
    catch (Exception $e)
    {
        //TODO Отдавать 400 код статуса
        echo "Такой пользователь уже создан ";
        //echo $e->getMessage();
        header("Status: 400 Bad Request", true, 400);
        exit();
    }

    return $connection->lastInsertId();
}

$userParams = [];
//$userParams = collectData($userParams);
$user = collectDataInClass($userParams);

$connection = connectDatabase();
// $userId = saveUserToDatabase($connection, $userParams);
$userId = saveUserToDatabaseWithClass($connection, $user);

$redirectUrl = "show_user_script.php/?user_id=$userId";
header("Location: " . $redirectUrl, true, 303);
die();

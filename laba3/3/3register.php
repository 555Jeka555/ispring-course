<?php

$res = file_get_contents("users.json");
$data = json_decode($res, true);
$user = [];
$error = false;

if (isset($_POST["surname"]))
{
    $surname = $_POST["surname"];
    $user["surname"] = $surname;
    if (count(array_filter(str_split($surname), "is_numeric")) > 0 ) $error = true;
}
if (isset($_POST["name"]))
{
    $name = $_POST["name"];
    $user["name"] = $name;
    if (count(array_filter(str_split($name), "is_numeric")) > 0) $error = true;
}
if (isset($_POST["fatherName"]))
{
    $fatherName = $_POST["fatherName"];
    $user["fatherName"] = $fatherName;
    if (count(array_filter(str_split($fatherName), "is_numeric")) > 0) $error = true;
}
if (isset($_POST["sex"]))
{
    $sex = $_POST["sex"];
    $user["sex"] = $sex;
}
if (isset($_POST["email"]))
{
    $email = $_POST["email"];
    $user["email"] = $email;
    $email_validation_regex = '/^\\S+@\\S+\\.\\S+$/'; 
    if (!(preg_match($email_validation_regex, $email))) $error = true;
}
if (isset($_POST["phone"]))
{
    $phone = $_POST["phone"];
    $user["phone"] = $phone;
    if (!is_numeric($phone)) $error = true;
    
}
if (isset($_POST["avatar"]))
{
    $avatar = $_POST["avatar"];
    $user["avatar"] = $avatar;
}

if (!$error)
{
    foreach ($data as $userCheck)
    {
        if (count($userCheck) == 0) continue;

        // Проверит если есть пользователь с такой же почтой И с таким же номером
        if ($userCheck["email"] == $user["email"] || $userCheck["phone"] == $user["phone"])
        {
            echo "Такой пользователь уже зарегистрирован";
            $error = true;
            break;
        }
    }
}
else
{
    echo "Данные введены не правильно, попробуйте ещё раз";
}

if (!$error and count($user) > 0)
{
    array_push($data, $user);
    $jsonData = json_encode($data);
    file_put_contents("users.json", $jsonData);
    echo "Вы успешно зарегистрированы";
}

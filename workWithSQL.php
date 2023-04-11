<?php
$connection = connectDatabase("name", "user", "password");
$postId = savePostToDatabase($connection, [
    "title" => "Новый пост",
    "subtitle" => "Новый подзаголовок",
    "content" => "Текст-рыба для нового поста"
]);

$post = findPostInDatabase($connection, $postId);
var_dump($post);

function connectDatabase($name, $user, $password): PDO
{
    $dsn = "mysql:host=127.0.0.1;dbname='$name'";
    return new PDO($dsn, $user, $password);
}

function savePostToDatabase(PDO $connection, array $postParams): int {

}
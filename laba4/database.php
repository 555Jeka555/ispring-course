<?php

//TODO Проверять file_get_contents на === false, выбросить исключение
function getConnectionParams(): array
{   
    $result = [];
    $file = file_get_contents("config.json");
    if ($file === false)
    {
        throw new RuntimeException("Not found database config");
    }
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

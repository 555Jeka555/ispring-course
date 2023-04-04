<?php

namespace App\Database;

class ConnectionProvider 
{

    public static function connectDatabase(): \PDO
    {
        $file = file_get_contents("/../Data/config.json");
        $data = json_decode($file, true)["database"];
        $host = $data["host"];
        $dbname = $data["dbname"];
        $dsn = "mysql:host=$host;dbname=$dbname;port=3306";
        $user = $data["user"];
        $password = $data["password"];
        return new \PDO($dsn, $user, $password);
    }

}

<?php

namespace App\Database;

use App\Model\User;

class UserTable 
{
    private const MYSQL_DATETIME_FORMAT = "Y-m-d H:i:s";
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findUser( int $userId): ?User
    {
        $query = <<< SQL
            SELECT
                user_id, first_name, second_name, 
                middle_name, gender, birth_date, email, phone, avatar_path
            FROM user
            WHERE user_id = $userId
        SQL;
    
        $statement = $this->connection->query($query);
        if ($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            return $this->createUserFromRow($row);
        }

        return null;
    }

    function saveUser(User $user): int
    {
        $query = <<< SQL
            INSERT INTO user  (first_name, second_name, 
                middle_name, gender, birth_date, email, phone, avatar_path)
            VALUES (:first_name, :second_name, :middle_name, :gender,
                :birth_date, :email, :phone, :avatar_path
                )
        SQL;

        $statement = $this->connection->prepare($query);
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

        return (int)$this->connection->lastInsertId();
    }

    private function createUserFromRow(array $row): User
    {
        return new User(
            (int)$row["user_id"], $row["first_name"], $row["second_name"],
            $row["middle_name"], $row["gender"], $row["birth_date"],
            $row["email"], $row["phone"], $row["avatar_path"]
        );
    }
}
<?php

namespace App\Controller;

use App\Database\ConnectionProvider;
use App\Database\UserTable;
use App\Model\User;

class UserController
{
    private const HTTP_STATUS_303_SEE_OTHER = 303;
    private UserTable $userTable;    

    public function __construct()
    {
        $connection = ConnectionProvider::connectDatabase();
        $this->userTable = new UserTable($connection);
    }

    public function index(): void
    {
        require __DIR__  . "/../View/form.php";
    }

    public function registerUser(array $requestData): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST")
        {
            $this->writeRedirectSeeOther("/");
            return;
        }

        $user = new User(
            null, $requestData["first_name"], $requestData["second_name"],
            $requestData["middle_name"], $requestData["gender"], $requestData["birth_date"],
            $requestData["email"], $requestData["phone"], $requestData["avatar_path"]
        );
        $userId = $this->userTable->saveUser($user);
        $this->writeRedirectSeeOther("/show_user.php?user_id=$userId"); // __DIR__ . "/../../public/show_user.php?user_id=$userId"
    }

    public function showUser(array $queryParams): void
    {
        $userId = (int)$queryParams["user_id"];
        if (!$userId)
        {
            $this->writeRedirectSeeOther("/");
            exit();
        }
        $user = $this->userTable->findUser($userId);
        if (!$user)
        {
            $this->writeRedirectSeeOther("/");
            exit();
        }
        // echo "User " . $user->getEmail();
        require __DIR__ . "/../View/user.php";
    }

    private function writeRedirectSeeOther(string $url): void
    {
        header("Location: " . $url, true, self::HTTP_STATUS_303_SEE_OTHER);
    }

}
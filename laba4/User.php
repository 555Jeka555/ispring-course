<?php

class User {
    private ?int $userId;
    private string $first_name;
    private string $second_name;
    private string $middle_name;
    private string $gender; 
	private string $birth_date;
	private string $email;
	private int $phone;
	private string $avatar_path;

    public function __construct(?int $userId, string $first_name, string $second_name, string $middle_name, string $gender, string $birth_date, string $email, int $phone, string $avatar_path)
    {
        $this->userId = $userId;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->$middle_name = $middle_name;
        $this->$gender = $gender; 
        $this->$birth_date = $birth_date;
        $this->$email = $email;
        $this->$phone = $phone;
        $this->$avatar_path = $avatar_path;
    }

    public function getUserId(): ?int
    {
       return $this->userId;
    }

   public function getFirstName(): string
   {
        return $this->first_name;
   }

   public function getSecondName(): string
   {
       return $this->second_name;
   }

   public function getMiddleName(): string
    {
       return $this->middle_name;
    }

   public function getGender(): string
   {
        return $this->gender;
   }

   public function getBirthDate(): string
   {
       return $this->birth_date;
   }

   public function getEmail(): string
    {
       return $this->email;
    }

   public function getPhone(): int
   {
        return $this->phone;
   }

   public function getAvatarPath(): string
   {
       return $this->avatar_path;
   }

}
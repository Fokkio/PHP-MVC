<?php
    class RegisterUserDTO
    {
        public string $name;
        public string $email;
        public string $password;
        public string $birthday;
        public string $phone;
        public Gender $gender;

        public function __construct($name, $email, $password, $birthday, $phone, $gender)
        {
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->birthday = $birthday;
            $this->phone = $phone;
            $this->gender = $gender;
        }

        public function toArray()
        {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'birthday' => $this->birthday,
                'phone' => $this->phone,
                'gender' => $this->gender->value
            ];
        }
    }

    class UserprofileDTO
    {
        public string $name;
        public string $email;
        public string $birthday;
        public string $phone;
        public Gender $gender;
        public function __construct(
            string $name,
            string $email,
            int $birthday,
            string $phone,
            Gender $gender
        )    {
            $this->name = $name;
            $this->email = $email;
            $this->birthday = $birthday;
            $this->phone = $phone;
            $this->gender = $gender;            
        }

        public function toArray()
        {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'birthday' => $this->birthday,
                'phone' => $this->phone,            
                'gender' => $this->gender->value
            ];  
        }
    }

    enum Gender: string {
        case MALE = "male";
        case FEMALE = "female";
        case OTHER = "other";
    }
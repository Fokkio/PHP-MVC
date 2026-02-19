<?php
    class RegisterUserDTO
    {
        public string $name;
        public string $email;
        public string $password;
        public int $age;
        public string $phone;
        public Gender $gender;

        public function __construct($name, $email, $password, $age, $phone, $gender)
        {
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->age = $age;
            $this->phone = $phone;
            $this->gender = $gender;
        }

        public function toArray()
        {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'age' => $this->age,
                'phone' => $this->phone,
                'gender' => $this->gender->value
            ];
        }
    }

    class UserprofileDTO
    {
        public string $name;
        public string $email;
        public int $age;
        public string $phone;
        public Gender $gender;
        public function __construct(
            string $name,
            string $email,
            int $age,
            string $phone,
            Gender $gender
        )    {
            $this->name = $name;
            $this->email = $email;
            $this->age = $age;
            $this->phone = $phone;
            $this->gender = $gender;            
        }

        public function toArray()
        {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'age' => $this->age,
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
<?php

declare(strict_types=1);
if ($context['method'] === 'GET') {
    renderView('register', ['title' => 'Register']);
} else if ($context['method'] === 'POST') {
    $fname = $_POST['first_name'] ?? '';
    $lname = $_POST['last_name'] ?? '';
    $name = $fname . ' ' . $lname;
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    if (!$birthday) {
        $_SESSION['error'] = 'กรุณากรอกวันเกิด';
        header('Location: /users/register');
        exit;
    }
    $phone = $_POST['phone'] ?? '';
    $genderInput = $_POST['gender'] ?? '';
    if (!$genderInput) {
        $_SESSION['error'] = 'กรุณาเลือกเพศ';
        header('Location: /users/register');
        exit;
    }
    $gender = Gender::from($genderInput);
    createUser($name, $email, $password, $birthday, $phone, $gender);
    header('Location: /users/login');
} else {
    notFound();
}

<?php
    $method = $context['method'];
    if ($method === 'GET') {
        renderView('login', ['title' => 'Login']);
    } else if ($method === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = checkLogin($email, $password);

        if ($user) {
            // 🔐 Security First
            session_regenerate_id(true);

            // เก็บข้อมูลที่จำเป็นลง Session (แยกชื่อให้ชัดเจน)
            $_SESSION['user_id'] = $user['user_id'];           // ID หลักสำหรับ Query DB
            $_SESSION['username'] = $user['name'];
            $_SESSION['timestamp'] = time();

            // 🚀 เปลี่ยนจาก renderView เป็น Redirect เพื่อป้องกันการกด Refresh แล้วส่งฟอร์มซ้ำ
            header('Location: /events/index');
            exit();
        } else {
            // ถ้าพลาด ค่อย renderView หน้าเดิมพร้อมส่ง Error
            renderView('login', [
                'title' => 'Login',
                'old_email' => $email // ส่งอีเมลกลับไปให้ User ไม่ต้องพิมพ์ใหม่
            ]);
            $_SESSION['error'] = 'Invalid email or password'; // เก็บข้อความผิดพลาดใน Session
        }
    }else{
        notFound();
    }

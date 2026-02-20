<?php
    class UserController
    {
        private $userRepo;

        public function __construct($userRepo)
        {
            $this->userRepo = $userRepo;
        }

        public function index(): void
        {
            if (!isset($_SESSION['timestamp'])) {
                header("Location: /login");
                exit();
            }
            if (!isset($_SESSION['user_id'])) {
                $this->logout();
            }
            $users = $this->userRepo->getUsersById($_SESSION['user_id']); // ตัวอย่างการดึงข้อมูลผู้ใช้ด้วย ID 1
            renderView('users', ['title' => 'Users', 'users' => $users]);
        }

        public function profile(): void
        {
            requireAuth();
            $userId = $_SESSION['user_id'];
            $userProfile = $this->userRepo->getUserProfileDetails($userId);
            renderView('profile', ['title' => 'My Profile', 'user' => $userProfile]);
        }

        public function showLogin(): void
        {
            renderView('login', ['title' => 'Login']);
        }

        public function doLogin(): void
        {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userRepo->checkLogin($email, $password);

            if ($user) {
                // 🔐 Security First
                session_regenerate_id(true); 

                // เก็บข้อมูลที่จำเป็นลง Session (แยกชื่อให้ชัดเจน)
                $_SESSION['user_id'] = $user['user_id'];           // ID หลักสำหรับ Query DB
                $_SESSION['student_id'] = $user['student_id']; // ID นักศึกษาสำหรับแสดงผล
                $_SESSION['username'] = $user['name'];
                $_SESSION['timestamp'] = time();

                // 🚀 เปลี่ยนจาก renderView เป็น Redirect เพื่อป้องกันการกด Refresh แล้วส่งฟอร์มซ้ำ
                header('Location: /events');
                exit();
            } else {
                // ถ้าพลาด ค่อย renderView หน้าเดิมพร้อมส่ง Error
                renderView('login', [
                    'title' => 'Login', 
                    'old_email' => $email // ส่งอีเมลกลับไปให้ User ไม่ต้องพิมพ์ใหม่
                ]);
                $_SESSION['error'] = 'Invalid email or password'; // เก็บข้อความผิดพลาดใน Session
            }
        }

        public function showRegister(): void
        {
            renderView('register', ['title' => 'Register']);
        }

        public function doRegister(): void
        {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $birthday = $_POST['birthday'] ?? '';
            $phone = $_POST['phone'] ?? '';
        }

        public function logout(): void
        {
            session_unset();
            session_destroy();
            header('Location: /events');
            exit;
        }
    }
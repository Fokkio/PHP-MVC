<html>

<head></head>

<body>
    <!-- ส่วนแสดงผลหลักของหน้า -->
    <main>
        <h1>เข้าสู่ระบบ</h1>
        <form action="/login" method="post">
            <label for="username">อีเมลผู้ใช้</label><br>
            <input type="text" name="email" id="email" /><br>
            <label for="password">รหัสผ่าน</label><br>
            <input type="password" name="password" id="password" /><br>
            <button type="submit">เข้าสู่ระบบ</button>
            <div>
                <span>หากยังไม่มีบัญชีผู้ใช้ <a href="/register">สมัครสมาชิก</a></span>
            </div>
            <div>
                <span><?= $_SESSION['error'] ?? '' ?></span>
            </div>
        </form>
    </main>
    <!-- ส่วนแสดงผลหลักของหน้า -->

    <?php include 'footer.php' ?>
</body>

</html>
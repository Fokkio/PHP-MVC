<h1><?= htmlspecialchars($data['title']) ?></h1>
<form action="/register" method="POST">
    <div>
        <label for="text">ชื่อผู้ใช้</label><br>
        <input type="text" name="first_name" id="first_name" required /><br>
    </div>
    <div>
        <label for="text">นามสกุลผู้ใช้</label><br>
        <input type="text" name="last_name" id="last_name" required /><br>
    </div>
    <div>
        <label for="text">วันเกิด</label><br>
        <input type="date" name="birth_date" id="birth_date" required /><br>
    </div>
    <div>
        <label for="text">เบอร์โทรศัพท์</label><br>
        <input type="text" name="phone" id="phone" required /><br>
    </div>
    <div>
        <label for="text">เพศ</label><br>   
        <select name="gender" id="gender" required>
            <option value="">เลือกเพศ</option>
            <option value=<?= Gender::MALE->value ?>>ชาย</option>
            <option value=<?= Gender::FEMALE->value ?>>หญิง</option>
            <option value=<?= Gender::OTHER->value ?>>อื่นๆ</option>  
        </select><br>
    </div>
    <div>
        <label for="email">อีเมลผู้ใช้</label><br>
        <input type="text" name="email" id="email" required /><br>
    </div>
    <div>
        <label for="password">รหัสผ่าน</label><br>
        <input type="password" name="password" id="password" required /><br>
    </div>
    
    <button type="submit">สมัครสมาชิก</button>
    <div>
        <span>หากมีบัญชีผู้ใช้แล้ว <a href="/login">เข้าสู่ระบบ</a></span>
    </div>
    <div>
        <span><?= $_SESSION['error'] ?? '' ?></span>
    </div>
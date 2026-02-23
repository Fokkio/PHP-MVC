<script src="https://cdn.tailwindcss.com"></script>
<h1 class="text-3xl font-bold text-gray-900 mb-6 text-center mt-8"><?= htmlspecialchars($data['title']) ?></h1>
<form action="/users/register" method="POST" class="bg-white p-6 sm:p-10 rounded-xl shadow-lg w-full max-w-xl mx-auto border border-gray-100 mb-8">
    <div class="mb-1">
        <label for="text" class="text-sm font-semibold text-gray-700">ชื่อผู้ใช้</label><br>
        <input type="text" name="first_name" id="first_name" required class="w-full mt-1 mb-3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white" /><br>
    </div>
    <div class="mb-1">
        <label for="text" class="text-sm font-semibold text-gray-700">นามสกุลผู้ใช้</label><br>
        <input type="text" name="last_name" id="last_name" required class="w-full mt-1 mb-3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white" /><br>
    </div>
    <div class="mb-1">
        <label for="text" class="text-sm font-semibold text-gray-700">วันเกิด</label><br>
        <input type="date" name="birthday" id="birthday" required class="w-full mt-1 mb-3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white" /><br>
    </div>
    <div class="mb-1">
        <label for="text" class="text-sm font-semibold text-gray-700">เบอร์โทรศัพท์</label><br>
        <input type="text" name="phone" id="phone" required class="w-full mt-1 mb-3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white" /><br>
    </div>
    <div class="mb-1">
        <label for="text" class="text-sm font-semibold text-gray-700">เพศ</label><br>   
        <select name="gender" id="gender" required class="w-full mt-1 mb-3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white cursor-pointer">
            <option value="">เลือกเพศ</option>
            <option value="<?= Gender::MALE->value ?>">ชาย</option>
            <option value="<?= Gender::FEMALE->value ?>">หญิง</option>
            <option value="<?= Gender::OTHER->value ?>">อื่นๆ</option>  
        </select><br>
    </div>
    <div class="mb-1">
        <label for="email" class="text-sm font-semibold text-gray-700">อีเมลผู้ใช้</label><br>
        <input type="text" name="email" id="email" required class="w-full mt-1 mb-3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white" /><br>
    </div>
    <div class="mb-1">
        <label for="password" class="text-sm font-semibold text-gray-700">รหัสผ่าน</label><br>
        <input type="password" name="password" id="password" required class="w-full mt-1 mb-6 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white" /><br>
    </div>
    
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-colors shadow-sm text-lg">สมัครสมาชิก</button>
    <div class="mt-6 text-center">
        <span class="text-sm text-gray-600">หากมีบัญชีผู้ใช้แล้ว <a href="/users/login" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition-colors">เข้าสู่ระบบ</a></span>
    </div>
    <div class="mt-4 text-center">
        <?php if (isset($_SESSION['error'])) : ?>
            <span style="color: red;" class="text-sm font-medium bg-red-50 text-red-600 px-4 py-2 rounded-lg inline-block border border-red-100"><?= $_SESSION['error'] ?></span>
            <?php unset($_SESSION['error']);?>
        <?php endif; ?>
    </div>
</form>
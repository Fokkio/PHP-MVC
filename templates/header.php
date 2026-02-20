<!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->
<header>
    <h1>Event Registration System</h1>
</header>
<nav>
    <h2><?= htmlspecialchars($data['title'] ?? '') ?></h2>
    <?php
    $uri = strtolower(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (isset($_SESSION['timestamp'])): ?>
        <div><a href="/events">Explore</a></div>
        <div><a href="/my-register">My Register</a></div>
        <div><a href="/my-events">My Events</a></div>
        <div><a href="/profile">ข้อมูลวิชา</a></div>
        <div><a href="/logout">ออกจากระบบ</a></div>
    <?php endif; ?>
</nav>
<!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->
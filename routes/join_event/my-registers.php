<?php
declare(strict_types=1);

$method = $context['method'];

if (empty($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$userId = (int)$_SESSION['user_id'];

if ($method === 'GET') {
    try {
        $events = getJoinedEventsByUserId($userId); 
        renderView('my-register', [
            'title' => 'My Registered Events',
            'events' => $events
        ]);

    } catch (Exception $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
} else {
    notFound();
}
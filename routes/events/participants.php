<?php
declare(strict_types=1);

$method = $context['method'];
$eventId = (int)$context['id'];

if (empty($_SESSION['user_id'])) {
    header('Location: /users/login');
    exit;
}

if ($method === 'GET') {
    try {
        $event = getEventById($eventId); 
        if (!$event) { notFound(); }

        if ($event['creator_id'] != $_SESSION['user_id']) {
            die("คุณไม่มีสิทธิ์เข้าถึงข้อมูลส่วนนี้");
        }

        $participants = getAlluserByEventID($eventId);

        renderView('participants-list', [
            'title' => 'Participants List',
            'event_name' => $event['name'],
            'participants' => $participants,
            'eventId' => $eventId
        ]);

    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    notFound();
}
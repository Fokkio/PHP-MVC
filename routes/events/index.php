<?php
declare(strict_types=1);

$keyword = $_GET['keyword'] ?? '';
$result = [];

if (!empty($keyword)) {
    $result = getEventByKeyword($keyword);
} else {
    $result = getAllEvents();
}
renderView('events', [
    'events'  => $result, 
    'keyword' => $keyword,
    'title'   => !empty($keyword) ? "ผลการค้นหา: $keyword" : "กิจกรรมทั้งหมด"
]);
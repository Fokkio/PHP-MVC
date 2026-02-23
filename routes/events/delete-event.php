<?php
declare(strict_types=1);

$method = $context['method'];
$id     = $context['id']; 
$imgBB_API_KEY = 'af9e4b188017d139fe28d35af8152794'; // API Key ของคุณ

if (empty($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

if ($method === 'GET') {
    $event = getEventById((int)$id);

    if (!$event) {
        notFound();
    }
    
    // ตรวจสอบว่าเป็นเจ้าของกิจกรรมจริงไหม
    if ($event['creator_id'] !== $_SESSION['user_id']) {
        header('Location: /events');
        exit;
    }

    try {
        // --- 1. จัดการลบรูปภาพที่เกี่ยวข้องทั้งหมด ---
        // ใช้ฟังก์ชันที่เราสร้างไว้เพื่อดึงทั้ง path และ delete_hash
        $images = getFullImagesByEventId((int)$id);

        /* if (!empty($images)) {
            foreach ($images as $img) {
                // ลบรูปออกจาก ImgBB Server โดยใช้ delete_hash
                if (!empty($img['delete_hash'])) {
                    deleteFromImgBB($img['delete_hash'], $imgBB_API_KEY);
                }
            }
        } */

        // --- 2. ลบข้อมูลรูปภาพออกจากตาราง image_storage ใน Database ---
        deleteImagesByEventId((int)$id);

        // --- 3. ลบตัวกิจกรรมออกจากตาราง events ---
        $success = deleteEvent((int)$id);
        
        if ($success) {
            header('Location: /events/my-event');
        } else {
            die("ไม่สามารถลบกิจกรรมได้ กรุณาลองใหม่");
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
    exit;

} else {
    notFound();
}


<?php
require_once INCLUDES_DIR . '/Enum.php';
function joinEvent(int $user_id, int $event_id): bool
{
    global $connection;
    $checkSql = "SELECT user_id FROM join_event WHERE user_id = ? AND event_id = ?";
    $checkStmt = $connection->prepare($checkSql);
    $checkStmt->bind_param("ii", $user_id, $event_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        return true; 
    }
    $sql = "INSERT INTO join_event (user_id, event_id) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        throw new Exception($connection->error);
    }

    $stmt->bind_param("ii", $user_id, $event_id);
    return $stmt->execute();
}

function leaveEvent(int $joinEventId)
{
    global $connection;
    $sql = "DELETE FROM join_event WHERE join_event_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }
    $stmt->bind_param("i", $joinEventId);

    return $stmt->execute();
}



function updateCheckInEvent(int $joinEventId, bool $checkInStatus)
{
    global $connection;
    $sql = "UPDATE join_event SET checkin_status = ?, checkin_token = NULL, checkin_token_expire = NULL WHERE join_event_id = ? AND join_status = 'approved'";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }
    $stmt->bind_param("ii", (int)$checkInStatus, $joinEventId);
    return $stmt->execute();
}

function updateJoinStatus(int $joinEventId, string $status)
{
    global $connection;
    $sql = "UPDATE join_event SET join_status = ? WHERE join_event_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }
    $stmt->bind_param("si", $status, $joinEventId);
    return $stmt->execute();
}

function getJoinedEventsByUserId($userId)
{
    global $connection;
    $sql = "SELECT  je.join_event_id, 
                            je.user_id, 
                            je.event_id, 
                            je.join_status, 
                            je.checkin_status,
                            e.event_name,
                            e.event_description, 
                            e.event_start,
                            e.event_end
                    FROM join_event je JOIN events e 
                    ON je.event_id = e.event_id
                    WHERE je.user_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        throw new Exception($connection->error);
    }
    $joinedEvents = [];

    while ($row = $result->fetch_assoc()) {
        $joinedEvents[] = $row;
    }

    return $joinedEvents;
}

function getJoinEventById($joinEventId)
{
    global $connection;
    $sql = "SELECT join_event_id, user_id, event_id, join_status, checkin_status, join_at
                    FROM join_event
                    WHERE join_event_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }
    $stmt->bind_param("i", $joinEventId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) return null;
    return $row;
}

function getAllJoinedStatusByUserId($userId)
{
    global $connection;
    $sql = "SELECT event_id , join_status FROM join_event WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        throw new Exception($connection->error);
    }
    $eventIds = [];

    while ($row = $result->fetch_assoc()) {
        $eventIds[(int)$row['event_id']] = $row['join_status'];
    }

    return $eventIds;
}

function getByUserAndEvent($userId, $eventId)
{
    global $connection;
    $sql = "SELECT join_event_id, user_id, event_id, join_status, checkin_status, join_at
                    FROM join_event
                    WHERE user_id = ? AND event_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }
    $stmt->bind_param("ii", $userId, $eventId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) return null;
    return $row;
}

function createCheckInToken($joinEventId, $token, $expireTime)
{
    global $connection;
    $sql = "UPDATE join_event
                    SET checkin_token = ?, checkin_token_expire = ?
                    WHERE join_event_id = ?";

    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception($connection->error);
    }

    $stmt->bind_param("ssi", $token, $expireTime, $joinEventId);
    return $stmt->execute();
}


function verifyCheckInToken($token)
{
    global $connection;
    $sql = "SELECT join_event_id
                    FROM join_event
                    WHERE checkin_token = ?
                    AND checkin_token_expire > NOW()
                    AND checkin_status = 0";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

function getAlluserByEventID(int $eventId): array
{
    global $connection;
    $sql = "SELECT je.join_event_id, 
                   je.user_id, 
                   je.join_status, 
                   je.checkin_status,
                   u.name as participant_name
            FROM join_event je 
            JOIN users u ON je.user_id = u.user_id
            WHERE je.event_id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $joinedEvents = [];
    while ($row = $result->fetch_assoc()) {
        $joinedEvents[] = $row;
    }
    return $joinedEvents;
}

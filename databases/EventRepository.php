<?php
    class EventRepository
    {
        private $connection;

        public function __construct($connection)
        {
            $this->connection = $connection;
        }

        public function getAllEvents()
        {
            $sql = "SELECT e.event_id AS id,
                e.event_name AS name,
                e.event_description AS description,
                e.event_start,
                e.event_end,
                u.name AS creator_name
            FROM events e
            JOIN users u ON e.user_id = u.user_id
            ORDER BY e.event_start DESC";
            $result = $this->connection->query($sql);
            if (!$result) {
                throw new Exception($this->connection->error);
            }
            $events = [];

            while ($row = $result->fetch_assoc()) {
                $events[] = new EventDTO(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['event_start'],
                    $row['event_end'],
                    $row['creator_name']
                );
            }

            return $events;
        }

        public function getEventById($eventId)
        {
            $sql = "SELECT e.event_id AS id,
                   e.event_name AS name,
                   e.event_description AS description,
                   e.event_start,
                   e.event_end,
                   u.name AS creator_name,
                   u.user_id AS creator_id
            FROM events e
            JOIN users u ON e.user_id = u.user_id
            WHERE e.event_id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $eventId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if (!$row) return null;
             return new EventDetailDTO(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['event_start'],
                $row['event_end'],
                $row['creator_name'],
                $row['creator_id']
            );
        }

        public function createEvent(CreateEventDTO $event)
        {
            $sql = "INSERT INTO events 
            (
                    event_name, 
                    event_description, 
                    event_start, 
                    event_end, 
                    user_id
            ) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ssssi", 
                            $event->name,
                            $event->description, 
                            $event->event_start, 
                            $event->event_end, 
                            $event->creator_id);
            return $stmt->execute();
        }

        public function getEventByKeyword($keyword)
        {
                $sql = "SELECT e.event_id AS id,
                               e.event_name AS name,
                               e.event_description AS description,
                               e.event_start,
                               e.event_end,
                               u.name AS creator_name
                        FROM events e
                        JOIN users u ON e.user_id = u.id
                        WHERE e.event_name LIKE ?
                        OR e.event_description LIKE ?
                        OR u.name LIKE ?
                        ORDER BY e.event_start DESC";
                $likeKeyword = '%' . $keyword . '%';
                $stmt = $this->connection->prepare($sql);
                $stmt->bind_param("sss", $likeKeyword, $likeKeyword, $likeKeyword);
                $stmt->execute();
                $result = $stmt->get_result();

                $events = [];

                while ($row = $result->fetch_assoc()) {
                    $events[] = new EventDTO(
                        $row['id'],
                        $row['name'],
                        $row['description'],
                        $row['event_start'],
                        $row['event_end'],
                        $row['creator_name']
                    );
                }

                return $events;
        }

        public function updateEvent($eventId, UpdateEventDTO $event)
        {
            $fields = [];
            $params = [];
            $types = "";
            // ตรวจสอบทีละฟิลด์ ถ้าไม่ว่างให้เก็บลง array
            if ($event->name !== null) {
                $fields[] = "event_name = ?";
                $params[] = $event->name;
                $types .= "s";
            }
            if ($event->description !== null) {
                $fields[] = "event_description = ?";
                $params[] = $event->description;
                $types .= "s";
            }
            if ($event->event_start !== null) {
                $fields[] = "event_start = ?";
                $params[] = $event->event_start;
                $types .= "s";
            }
            if ($event->event_end !== null) {
                $fields[] = "event_end = ?";
                $params[] = $event->event_end;
                $types .= "s";
            }
            if (empty($fields)) return false; // ไม่มีอะไรให้อัปเดต
            $types .= "i"; // สำหรับ eventId
            $params[] = $eventId;
            $sql = "UPDATE events 
                    SET " . implode(', ', $fields) . "
                    WHERE event_id = ?";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param($types, ...$params);
            if (!$stmt->execute()) {
                return false; // SQL รันไม่ผ่านจริงๆ (เช่น Database หลุด)
            }

            return $stmt->affected_rows > 0;
        }

        public function deleteEvent(int $eventId): bool
        {
            $sql = "DELETE FROM events WHERE event_id = ?";
            $stmt = $this->connection->prepare($sql);

            if (!$stmt) {
                throw new Exception($this->connection->error);
            }

            $stmt->bind_param("i", $eventId);

            if (!$stmt->execute()) {
                return false;
            }

            return $stmt->affected_rows > 0;
        }

    }
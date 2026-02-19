<?php
    class JoinEventRepository
    {
        private $connection;

        public function __construct($connection)
        {
            $this->connection = $connection;
        }

        public function joinEvent(CreateJoinEventDTO $joinEvent)
        {
            $sql = "INSERT INTO join_event (user_id, event_id) VALUES (?, ?)";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("ii", $joinEvent->user_id, $joinEvent->event_id);
            
            return $stmt->execute();
        }

        public function leaveEvent($joinEventId)
        {
            $sql = "DELETE FROM join_event WHERE join_event_id = ?";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("i", $joinEventId);
            
            return $stmt->execute();
        }



        public function updateCheckInEvent($joinEventId, bool $checkInStatus)
        {
            $sql = "UPDATE join_event SET checkin_status = ?, checkin_token = NULL, checkin_token_expire = NULL WHERE join_event_id = ? AND join_status = 'approved'";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("ii", $checkInStatus, $joinEventId);
            return $stmt->execute();
        }

        public function updateJoinStatus($joinEventId, string $status)
        {
            $sql = "UPDATE join_event SET join_status = ? WHERE join_event_id = ?";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("si", $status, $joinEventId);
            return $stmt->execute();
        }

        public function getJoinedEventsByUserId($userId)
        {
            $sql = "SELECT je.join_event_id, je.user_id, je.event_id, je.join_status, je.checkin_status, je.join_at
                    FROM join_event je
                    WHERE je.user_id = ?";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
             if (!$result) {
                throw new Exception($this->connection->error);
            }
            $joinedEvents = [];

            while ($row = $result->fetch_assoc()) {
                $joinedEvents[] = new JoinEventDTO(
                    $row['join_event_id'],
                    $row['user_id'],
                    $row['event_id'],
                    new JoinStatus($row['join_status']),
                    (bool)$row['checkin_status'],
                    $row['join_at']
                );
            }

            return $joinedEvents;
        }

        public function getJoinEventById($joinEventId)
        {
            $sql = "SELECT join_event_id, user_id, event_id, join_status, checkin_status, join_at
                    FROM join_event
                    WHERE join_event_id = ?";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("i", $joinEventId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if (!$row) return null;
             return new JoinEventDTO(
                $row['join_event_id'],
                $row['user_id'],
                $row['event_id'],
                new JoinStatus($row['join_status']),
                (bool)$row['checkin_status'],
                $row['join_at']
            );
        }

        public function getAllJoinedStatusByUserId($userId)
        {
            $sql = "SELECT event_id , join_status FROM join_event WHERE user_id = ?";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
             if (!$result) {
                throw new Exception($this->connection->error);
            }
            $eventIds = [];

            while ($row = $result->fetch_assoc()) {
                $eventIds[(int)$row['event_id']] = $row['join_status'];
            }

            return $eventIds;
        }

        public function getByUserAndEvent($userId, $eventId)
        {
            $sql = "SELECT join_event_id, user_id, event_id, join_status, checkin_status, join_at
                    FROM join_event
                    WHERE user_id = ? AND event_id = ?";
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }
            $stmt->bind_param("ii", $userId, $eventId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if (!$row) return null;
             return new JoinEventDTO(
                $row['join_event_id'],
                $row['user_id'],
                $row['event_id'],
                new JoinStatus($row['join_status']),
                (bool)$row['checkin_status'],
                $row['join_at']
            );
        }

        public function createCheckInToken($joinEventId, $token, $expireTime)
        {
            $sql = "UPDATE join_event
                    SET checkin_token = ?, checkin_token_expire = ?
                    WHERE join_event_id = ?";

            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception($this->connection->error);
            }

            $stmt->bind_param("ssi", $token, $expireTime, $joinEventId);
            return $stmt->execute();
        }


        public function verifyCheckInToken($token)
        {
            $sql = "SELECT join_event_id
                    FROM join_event
                    WHERE checkin_token = ?
                    AND checkin_token_expire > NOW()
                    AND checkin_status = 0";

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }

    }
<?php
class ImageRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function saveImage($eventId, $imagePath)
    {
        $sql = "INSERT INTO images (event_id, image_path) VALUES (?, ?)";
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception($this->connection->error);
        }
        $stmt->bind_param("is", $eventId, $imagePath);

        return $stmt->execute();
    }

    public function getImagesByEventId($eventId)
    {
        $sql = "SELECT image_path FROM images WHERE event_id = ?";
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception($this->connection->error);
        }
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();

        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = htmlspecialchars($row['image_path'], ENT_QUOTES, 'UTF-8');
        }

        return $images;
    }

    public function deleteImagesByEventId($eventId)
    {
        $sql = "DELETE FROM images WHERE event_id = ?";
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception($this->connection->error);
        }
        $stmt->bind_param("i", $eventId);

        return $stmt->execute();
    }
}

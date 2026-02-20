<?php
    class CreateEventDTO{ //สำหรับรับข้อมูลที่ต้องการสร้าง event
        public string $name;
        public string $description;
        public string $event_start;
        public string $event_end;
        public int $creator_id;

        public function __construct(
            string $name,
            string $description, 
            string $event_start, 
            string $event_end, 
            int $creator_id
        ){
            $this->name = $name;
            $this->description = $description;
            $this->event_start = $event_start;
            $this->event_end = $event_end;
            $this->creator_id = $creator_id;
        }
    }

    class EventDTO{ //สำหรับดึงข้อมูล event มาแสดง
        public int $id;
        public string $name;
        public string $description;
        public string $event_start;
        public string $event_end;
        public string $creator_name;

        public function __construct(
            int $id,
            string $name,
            string $description,
            string $event_start,
            string $event_end,
            string $creator_name
        ) {
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->event_start = $event_start;
            $this->event_end = $event_end;
            $this->creator_name = $creator_name;
        }
        public function toArray() : array
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'event_start' => $this->event_start,
                'event_end' => $this->event_end,
                'creator_name' => $this->creator_name
            ];
        }
    }

    class EventDetailDTO extends EventDTO{ //สำหรับดึงข้อมูล event มาแสดงแบบละเอียด (เช่น มี creator_id ด้วย)
        public int $creator_id;

        public function __construct(
            int $id,
            string $name,
            string $description,
            string $event_start,
            string $event_end,
            string $creator_name,
            int $creator_id
        ) {
            parent::__construct($id, $name, $description, $event_start, $event_end, $creator_name);
            $this->creator_id = $creator_id;
        }
    }

    class UpdateEventDTO{ //สำหรับรับข้อมูลที่ต้องการอัปเดต (ไม่จำเป็นต้องใส่ทุกฟิลด์)
        public ?string $name;
        public ?string $description;
        public ?string $event_start;
        public ?string $event_end;

        public function __construct(
            ?string $name = null,
            ?string $description = null,
            ?string $event_start = null,
            ?string $event_end = null
        ){
            $this->name = $name;
            $this->description = $description;
            $this->event_start = $event_start;
            $this->event_end = $event_end;
        }
    }
<?php
    class CreateEventDTO{
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
        public function toArray() : array
        {
            return [
                'name' => $this->name,
                'description' => $this->description,
                'event_start' => $this->event_start,
                'event_end' => $this->event_end,
                'creator_id' => $this->creator_id
            ];
        }
    }

    class EventDTO{
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
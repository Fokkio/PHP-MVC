<?php
    class JoinEventDTO
    {
        public int $join_event_id;
        public int $user_id;
        public int $event_id;
        public JoinStatus $status;
        public bool $check_in_status;
        public string $join_at;

        public function __construct(int $join_event_id, int $user_id, int $event_id, JoinStatus $status, bool $check_in_status, string $join_at)
        {
            $this->join_event_id = $join_event_id;
            $this->user_id = $user_id;
            $this->event_id = $event_id;
            $this->status = $status;
            $this->check_in_status = $check_in_status;
            $this->join_at = $join_at;
        }

        public function toArray(): array
        {
            return [
                'join_event_id' => $this->join_event_id,
                'user_id' => $this->user_id,
                'event_id' => $this->event_id,
                'status' => $this->status->value,
                'check_in_status' => $this->check_in_status,
                'join_at' => $this->join_at
            ];
        }
    }

   class CreateJoinEventDTO
    {
        public int $user_id;
        public int $event_id;

        public function __construct(int $user_id, int $event_id)
        {
            $this->user_id = $user_id;
            $this->event_id = $event_id;
        }
    }

    enum JoinStatus: string {
        case PENDING = 'pending';
        case CONFIRMED = 'approved';
        case CANCELLED = 'rejected';
    }
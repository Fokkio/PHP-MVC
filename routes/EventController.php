<?php
    class EventController
    {
        private $eventRepo;
        public function __construct(EventRepository $eventRepo)
        {
            $this->eventRepo = $eventRepo;
        }
        public function index(): void
        {
            $events = $this->eventRepo->getAllEvents();
            renderView('events', ['title' => 'Events', 'events' => $events]);
        }

        public function show($id): void
        {
            $event = $this->eventRepo->getEventById($id);
            if (!$event) {
                notFound();
            }
            renderView('event-detail', ['title' => 'Event Detail', 'event' => $event]);
        }

        public function goToCreate(): void
        {
            renderView('create-event', ['title' => 'Create Event']);
        }

        public function create(): void
        {
            // รับข้อมูลจากฟอร์มและสร้าง DTO
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $event_start = $_POST['event_start'] ?? '';
            $event_end = $_POST['event_end'] ?? '';
            $creator_id = 1; // สมมติว่า user ID 1 เป็นผู้สร้าง

            $createEventDTO = new CreateEventDTO($name, $description, $event_start, $event_end, $creator_id);
            // เรียกใช้ repository เพื่อบันทึกข้อมูล
            $this->eventRepo->createEvent($createEventDTO);
            // เปลี่ยนเส้นทางกลับไปที่หน้าแสดงรายการ events
            header('Location: /events');
        }

        public function showEdit($id , $user_id): void
        {
            $event = $this->eventRepo->getEventById($id);
            if (!$event) {
                notFound();
            }
            renderView('edit-event', ['title' => 'Edit Event', 'event' => $event]);
        }

        public function goToEdit($id  , $user_id): void
        {
            $event = $this->eventRepo->getEventById($id);
            if (!$event) {
                notFound();
            }
            renderView('edit-event', ['title' => 'Edit Event', 'event' => $event]);
        }

        public function edit($id  , $user_id): void
        {
            // รับข้อมูลจากฟอร์มและสร้าง DTO
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $event_start = $_POST['event_start'] ?? '';
            $event_end = $_POST['event_end'] ?? '';

            $updateEventDTO = new UpdateEventDTO($name, $description, $event_start, $event_end);
            // เรียกใช้ repository เพื่ออัปเดตข้อมูล
            $this->eventRepo->updateEvent($id, $updateEventDTO);
            // เปลี่ยนเส้นทางกลับไปที่หน้าแสดงรายละเอียด event
            header('Location: /events/' . $id);
        }
    }
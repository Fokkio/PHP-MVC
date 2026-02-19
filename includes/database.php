<?php
    require_once DATABASES_DIR . '/ImageRepository.php';
    require_once DATABASES_DIR . '/EventRepository.php';
    require_once DATABASES_DIR . '/data-relation.php';// กรณีที่มีการเชื่อมโยงข้อมูลระหว่างตารางต่างๆ เช่น students กับ courses ผ่าน enrollment
    require_once DATABASES_DIR . '/UserRepository.php';
    require_once DATABASES_DIR . '/JoinEventRepository.php';
    require_once DATABASES_DIR . '/database.php';
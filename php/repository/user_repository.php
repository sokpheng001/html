<?php
    require_once __DIR__ .'/abstraction/repository.php';
    require_once '../utils/database_connect.php';
    
    class UserRepository implements Repository{
            
        public function save($user):int{
            return 0;
        }

        public function findById(int $id) {

            return null;
        }

        public function findAll(): array {
            return [];
        }
    }
?>
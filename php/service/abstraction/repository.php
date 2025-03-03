<?php

/**
 * @template T
 */
    interface Repository {
        /**
         * @param T $item
         * @return void
         */
        public function save($item): int;

        /**
         * @param int $id
         * @return T|null
        */
        public function findById(int $id);

        /**
        * @return T[]
        */
        public function findAll(): array;
    }
?>
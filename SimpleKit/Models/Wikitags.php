<?php

    namespace SimpleKit\Models;
    
    use SimpleKit\SimpleORM\EntityManager;
    
    class Wikitags {
        private $entity;
    
        public function __construct() {
            $this->entity = new EntityManager("wiki_tags");
        }
    
        public function create($data) {
            $this->entity->saveMany([$data]);
        }

         public function raw (string $query, array $params = []): array {
            return $this->entity->raw($query, $params);
        }
    
        public function getAll() {
            return $this->entity->fetchAll()->get();
        }
    
        public function getById($id) {
            return $this->entity->fetchAll()->where("id", $id)->get(1);
        }
    
        public function updateById($id, $data) {
            $this->entity->update($data)->where("id", $id)->confirm();
        }
    
        public function deleteById($id) {
            $this->entity->delete()->where("wikiID", $id)->confirm();
        }
    
        // Add other methods as needed to interact with the Users entity using SimpleORM
    }               
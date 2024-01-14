<?php

    namespace SimpleKit\Models;
    
    use SimpleKit\SimpleORM\EntityManager;
    
    class User {
        private $entity;
    
        public function __construct() {
            $this->entity = new EntityManager("user");
        }

        public function count() {
            return $this->entity->count()->get();
        }
    
        public function create($data) {
            $this->entity->saveMany([$data]);
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
            $this->entity->delete()->where("id", $id)->confirm();
        }

        public function getByEmail(String $email) {
            return $this->entity->fetchAll()->where("email", $email)->get();
        }

        public function emailExists(String $email)
    {
        return $this->entity->count()->where("email", $email)->get(); 
    }
        // Add other methods as needed to interact with the Users entity using SimpleORM
    }               
<?php

use SimpleKit\SimpleORM\EntityManager;

$entity = new EntityManager("Users");

// individual insert

// $entity->email = "typeasd";
// $entity->name = "name421";
// $entity->lastname = "last_name232";
// $entity->userID = 23123;

// $entity->save();

//batch insert

//example use
// $entity->saveMany([
//     ["columnName"=> "exampleValue1","columnName2"=> "exampleValue2"],
// ]);

// $entity->saveMany([
//     ["name" => "name1", "email" => "email1@gmail.com", "lastname" => "lastname1", "userID" => 233],
//     ["name" => "name2", "email" => "email2@gmail.com", "lastname" => "lastname2", "userID" => 213],
//     ["name" => "name3", "email" => "email3@gmail.com", "lastname" => "lastname3", "userID" => 21],
//     ["name" => "name4", "email" => "email4@gmail.com", "lastname" => "lastname4", "userID" => 124],
//     ["name" => "name5", "email" => "email5@gmail.com", "lastname" => "lastname5", "userID" => 532],
//     ["name" => "name6", "email" => "email6@gmail.com", "lastname" => "lastname6", "userID" => 876],
//     ["name" => "name7", "email" => "email7@gmail.com", "lastname" => "lastname7", "userID" => 345],
//     ["name" => "name8", "email" => "email8@gmail.com", "lastname" => "lastname8", "userID" => 789],
// ]);

// $entity->flush();

// $entity->list();

//fetch records

// $entity->fetchAll()->get();
// $entity->fetchAll()->get(number);
// $entity->fetchAll()->where("name", "exampleName")->get();
// $entity->fetchAll()->where("name", "exampleName")->where("email", "exampleEmail")->get(number);

//delete records

// $entity->delete()->confirm();
// $entity->delete()->where("id", 51)->confirm();

//update one record

// $entity->update("name", "rand")->where("id", 51)->confirm();

//update multiple records

// $entity->update([
//     "name" => "random name",
//     "email" => "random email",
//     "lastname" => "random lastname",
// ])->where("id", 43)->confirm();

//apply raw sql

//coming soon future feature

// aggregate functions

//count

// $entity->count(); //counts all records

//order by

// $entity->fetchAll()->where("name", "nameqwd3")->orderBy(["userID"], "DESC")->get(); ASC default

// <?php

// require 'models/UserModel.php';

// use MVC\Models\UserModel;

// $userModel = new UserModel();

// // Create a new user
// $userModel->create([
//     "name" => "John Doe",
//     "email" => "john@example.com",
//     "lastname" => "Doe",
//     "userID" => 123
// ]);

// // Fetch all users
// $users = $userModel->getAll();
// print_r($users);

// // Get user by ID
// $user = $userModel->getById(1);
// print_r($user);

// // Update user by ID
// $userModel->updateById(1, ["name" => "Updated Name"]);

// // Delete user by ID
// $userModel->deleteById(1);

// ?>

# 🚀 SimpleKit

## Introduction

```plaintext
🔥 Welcome to the SimpleKit! an open-source PHP framework that is meticulously crafted to harness the power of SimpleORM, offering developers a seamless experience in building robust web applications. 🌐 Dive deep into mastering intricate Object-Relational Mapping nuances🛠.
```

```plaintext
This readme serves as the official documentation to this project. All information about how to 
get started using SimpleKit with SimpleORM is included in this readme.
```

```plaintext
Why should you use SimpleKit too? because it's blazingly fast. Plus it's open source and easy 
to add new features to it as you wish in order to tailor it to your own needs as a developer.
```

# SimpleKit Installation Guide

Follow these steps to install SimpleKit on your system:

## Prerequisites

- Ensure you have [Git](https://git-scm.com/) installed on your machine.
- Make sure you have [Node.js](https://nodejs.org/) and [npm](https://www.npmjs.com/) installed.
- Ensure [Composer](https://getcomposer.org/) is installed on your system.

## Installation Steps

### 1. Clone the SimpleKit Repository

Firstly, clone the SimpleKit repository to your local machine using Git:

```bash
git clone https://github.com/yassirelkhaili/SimpleKit.git
```
### 2. Navigate to the Project Directory

Navigate to the cloned directory:

```bash
cd simplekit
```

### 3. Install npm Packages

Inside the project directory, install the necessary npm packages:

```bash
npm install
```

### 3. Require Composer Dependencies

Next, require the Composer dependencies by executing the following command:

```bash
composer install
```

### 3. Start up your apache server (Laragon, Xamp or Wamp) and set the host directory to the project's root

### 4. Navigate to http://localhost/books for a demo crud project

### 5. Dont forget to setup the database connection (check the establishing connection guide down below for more info)

### 6. (optional) start typescript compilation

```bash
npm start
```

## Simple command line interface

### Introduction

```plaintext
SimpleKit includes a simple command line interface called well... simple. It supports multiple 
commands that make using SimpleKit seamless.
```

### Simple commands

- help

```plaintext
This command prints a list of all current commands supported by simple.
```

Example use:

```bash
php simple help
```

- generate

```plaintext
This command allows developers to create Models, Controllers or Entities serving multiple purposes within the application's architecture.
```

```plaintext
1. **Models**: Models acts as an intermediary between the Database and the controller, harnessing the power of SimpleORM to enable efficient data manipulation and retrieval operations.
Default location: SimpleKit/Models/
```

![Models](https://i.imgur.com/jcrjZ6O.png)
   
```plaintext
2. **Controllers**: Controllers act as intermediaries between the model and view components of the application, facilitating the processing of user requests and directing the flow of data, they call Model methods and render the appropriate Views.
Default location: SimpleKit/Controllers/
```

![Controller](https://i.imgur.com/50Tllhw.png)

```plaintext
3. **Entities**: Essentially, entities function as migrations or schemas that dictate the structure and attributes of database tables.
Default location: SimpleKit/Database/Migrations
```

Example use:

```bash
php generate:model User
```
```bash
php generate:controller UserController
```

```bash
php generate:entity Users
```

- migrate

```plaintext
This command migrates an entity from your Migrations folder to your database.
```

Example use:

```bash
php migrate:entity Users
```

- destroy

```plaintext
This command deletes a Model, Controller or Entity from the applications structure.
```

Example use:

```bash
php destroy:model User
```

- rollback

```plaintext
This command reverses a migration simply dropping which ever table name you give it.
```

Example use:

```bash
php rollback:entity Users
```

## Entities

```plaintext
Entities are simply classes that represent tables.
```

### Attributes

```plaintext
Attributes are first set by default when you generate a class and are optional.
You can edit/delete them or make your own.
```
![Attributes](https://i.imgur.com/0jw7jDF.png)

### getPropertyConfig

```plaintext
Every Entity has its own getPropertyConfig method. 
This is SimpleKit gets all the information about how it should create the table in the database.
```

![getPropertyConfig](https://i.imgur.com/zMP4rBy.png)

- Important:
```plaintext
If SimpleKit doesn't find the getPropertyConfig method defined inside the entity class it will 
proceed to simply generate the table using the properties instead using default values for each 
column. (experimental)
```

- supported column types:

- type
- length
- notNull
- autoIncrement
- primary
- unique

Example Use:

```php
 public static function getPropertyConfig(): array {
        return [
            'id' => ['type' => 'int', 'primary' => true, 'autoIncrement' => true, 'notNull' => true],
            'name' => ['type' => 'varchar', 'length' => 255, 'notNull' => false],
            'email' => ['type' => 'varchar', 'length' => 255, 'notNull' => true, 'unique' => true],
            'lastname' => ['type' => 'varchar', 'length' => 23, 'notNull' => false, 'unique' => true],
            'userID' => ['type' => 'int', 'notNull' => false, 'unique' => true],
        ];
    }
```

## Establishing a connection

```plaintext
SimpleKit offers a simple way to establish a connection to your database.
Simply fill up the fields in the .env.db file in the project root with your database 
credentials and you are set.
```

Examle use:

```bash
DRIVER = "mysql"
DB_HOST = "localhost"
DB_PORT = "3301"
DB_NAME = "ormtest"
DB_USER = "root"
DB_PWORD = ""
```

## Routing

```plaintext
Routers are responsible for the SimpleKit applications's routes.
They take a route URI, the controller responsible for the route and the corresponding method.
Check the BaseRouter for the background code.
Default Location: SimpleKit/Routers/
```

![Routers](https://i.imgur.com/5Aq71rD.png)

## Helpers

```plaintext
SimpleKit features a number of helper classes and functions that serve many perposes vital to the flow of a SimpleKit application.
Default Location: SimpleKit/Helpers/
```

### Redirector

```plaintext
A function typically used in Controllers to redirect to the Views and is capable of creating session data for example to send a comfirmation message to the user.
```

Example use:

```php
   public function store() {
        // Redirect back to the index page with a success message (or handle differently based on your needs)
        // You can also render a view or return a JSON response
        return redirect('/books')->with(['success' => 'book created successfully!']); 
    }
```

### Request

```plaintext
A class Used to get POST data from a form in controllers before storing it in the database using the corresponding model.
```

Example use:

```php
   public function store(Request $request) {
        $data = $request->getPostData();
        // Create a new book using the books
        $this->books->create($data);
    }
```

# SimpleORM

```plaintext
SimpleORM, is an open source PHP ORM designed by me to be used in future projects as well as master the behind the scene fundamentals of Object-Relational Mapping, advanced PHP OOP concepts, and design patterns. 📚 This project serves as a practical playground for me to further understand how ORMs work behind the scenes.
```

## Entity Mapper:

### Definition

```plaintext
SimpleORM uses an Entity Mapper which is a class that handles entity mapping in 
order to get all of its properties and types that way SimpleORM knows how to create 
the appropriate database table.
Default location: SimpleKit/SimpleORM/MigrationMapper.php
```

## Entity Generator:

### Definition

```plaintext
SimpleORM uses an Entity Generator which is a class that handles entity generation 
and puts it in the Migrations folder.
Default location: SimpleKit/SimpleORM/EntityGenerator.php
```

## Query Generator:

### Definition

```plaintext
SimpleORM uses a Query Generator which is simply the chef that cooks up all 
of the queries and serves them to the Entity Manager.
Default location: SimpleKit/SimpleORM/QueryGenerator.php
```

## Entity Manager:

### Definition

```plaintext
SimpleORM uses an Entity Manager which is the class you will be interacting with 
almost all the time. It's simply the server that takes your order to the kitchen 
then serves you the food. and by order I mean SimpleORM methods/queries and by your 
food I mean data/records from the database.
Default location: SimpleORM/SimpleORM/EntityManager.php
```

## How to use SimpleORM

### require Enity Manager Class

```php
require_once "./vendor/autoload.php";

use SimpleKit\SimpleORM\EntityManager;
```

### instantiate a new Entity Manager Object

```plaintext
Required parameters:
- $conn object from SimpleORM/src/Database/connections/conn.php This is autimatically 
included when you require the Entity Manager
- entity/database table name as string
```

```php
$entity = new EntityManager("Users");
```

### Insert Methods

- Individual insert

Example use:

```php
$entity->email = "example@gmail.com";
$entity->name = "name";
$entity->lastname = "lastname";
$entity->userID = 21;
$entity->save();
```

- Batch insert

```plaintext
Required parameters:
- Array of records as associative arrays with column names keys pointing to values
```

Example use:

```php
$entity->saveMany([
    ["name"=> "nam eqwd","email"=> "email@gmail.com", "lastname" => "lastname"],
    ["name"=> "nameqwd2","email"=> "email2@gmail.com", "lastname" => "lastname"],
    ["name"=> "nameqwd3","email"=> "email3@gmail.com", "lastname" => "lastname"],
]);
```

### Fetch Methods

- Fetch records

Example use:

```php
$entity->fetchAll()->get(); // fetches all records from the database table
```

- paginate

```plaintext
Limits the number of records to be fetched
```

```plaintext
Required parameters:
- value: integer
```

Example use:

```php
$entity->fetchAll()->get(int number);
```

- where

```plaintext
Specifies which records should be fetched
Required parameters:
- column name: string
- value: any
```

Example use:

```php
$entity->fetchAll()->where("name", "exampleName")->get();
$entity->fetchAll()->where("name", "exampleName")-where("email", "exampleEmail")->get(number);
```

### Delete Methods

- Delete records

Example use:

```php
$entity->delete()->confirm(); // deletes all records from the database table
```

Note:

```plaintext
This method can be chained with where to delete specific table records
```

Example use:

```php
 $entity->delete()->where("id", 51)->confirm(); //deletes record which id = 51
```

### Update Methods

- Individual records

```plaintext
Required parameters:
- column name: string
- value: any
```

Example use:

```php
$entity->update("name", "rand")->where("id", 51)->confirm(); 
// updates name to rand for record with id = 51
```

- Multiple records

```plaintext
Required parameters:
- Associative array with table columns as keys
```

Example use:

```php
$entity->update([
    "name" => "random name",
    "email" => "random email",
    "lastname" => "random lastname",
])->where("id", 52)->confirm();  
// updates name, email and lastname for record with id = 51
```

### Aggregate Methods

- Count

```plaintext
Returns table record count
```

Example use:

```php
$entity->count(); //counts all records
```

- Order By

```plaintext
Displays table records in order
```

```plaintext
Required parameters:
- Array of columns to be ordered by
- Order by method: ASC or DESC (optional)
```

Note:

```plaintext
The second parameter is optional and is set to ASC by default
```

Example use:

```php
$entity->fetchAll()->where("id", 51)->orderBy(["userID"], "DESC")->get();
```
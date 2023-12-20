<?php

namespace generate;


require_once dirname(__DIR__) . "/SimpleORM/EntityManager.php";

use EntityManager\EntityManager;
use Migrations\MigrationMapper;

enum EntityType: string
{
    case controller = "Controller";
    case migration = "Migration";
}

abstract class generate {
    abstract public static function generate(string $name, EntityType $Type): void;

    abstract public static function destroy(string $name, EntityType $Type): void;
}

class generateEntity Extends generate {
    public static function generate(string $entity_name, EntityType $type): void {
        $file_name = $entity_name . ".php";
        $destination_directory = dirname(__DIR__);
        $full_path = "";
        $entity_content = "";
        switch ($type->value) {
            case "Controller":
                $destination_directory .= "\Controllers";
                $full_path = $destination_directory . '/' . $file_name;
                if (!is_dir($destination_directory)) mkdir($destination_directory, 0777, true);
                if (file_exists($full_path)) exit("$type->value $entity_name already exists");
                $entity_content = <<<PHP
                <?php

                namespace MVC\Controllers;
                
                use MVC\Controller;
                use MVC\Models\User;
                
                class UserController extends Controller {
                    public function index() {
                        \$users = [
                            new User('John Doe', 'john@example.com'),
                            new User('Jane Doe', 'jane@example.com')
                        ];
                
                        \$this->render('user/index', ['users' => \$users]);
                    }
                }
                    
                PHP;
            file_put_contents($full_path, $entity_content);
            exit("The $entity_name $type->value has been generated at: $full_path\n");
            case "Migration":
                $destination_directory .= "\Database\Migrations";
                $full_path = $destination_directory . '/' . $file_name;
                if (!is_dir($destination_directory)) mkdir($destination_directory, 0777, true);
                if (file_exists($full_path)) exit("$type->value $entity_name already exists");
                $entity_content = <<<PHP
            <?php
        
            require_once dirname(__DIR__) . "/SimpleORM/MigrationMapper.php";
        
            use Migrations\Migration;
        
            class $entity_name extends Migration {
                /**
                 * @var int
                 *
                 * @Config(type="int", primary=true, autoIncrement=true, notNull=true)
                 * The unique identifier for the user.
                 */
                private int \$id;
            
                /**
                 * @var string
                 *
                 * @Config(type="varchar", length=255, notNull=true)
                 * The name of the user.
                 */
                private string \$name;
            
                /**
                 * @var string
                 *
                 * @Config(type="varchar", length=255, notNull=true, unique=true)
                 * The email address of the user, which must be unique.
                 */
                private string \$email;
            
                /**
                 * Get the configuration for each property.
                 *
                 * @return array
                 * An associative array where keys are property names, and values are property configurations.
                 */
                public static function getPropertyConfig(): array {
                    return [
                        'id' => ['type' => 'int', 'primary' => true, 'autoIncrement' => true, 'notNull' => true],
                        'name' => ['type' => 'varchar', 'length' => 255, 'notNull' => true],
                        'email' => ['type' => 'varchar', 'length' => 255, 'notNull' => true, 'unique' => true],
                    ];
                }
            }
            PHP;
                file_put_contents($full_path, $entity_content);
                exit("The $entity_name $type->value has been generated at: $full_path\n");
            default:
            exit("Invalid Entity Type");
        }
    }

    public static function migrate(string $entity_name): void {
        $file_name = $entity_name . ".php";
        $target_directory = dirname(__DIR__) . "\Database\Migrations";
        $target_file_path = $target_directory . '/' . $file_name;

        if (file_exists($target_file_path)) {
            require_once $target_file_path;
            if (class_exists($entity_name)) {
                $mapper = new MigrationMapper(new $entity_name);
                $manager = new EntityManager($entity_name);
                $manager->up($mapper->map());
            } else {
            exit("Could't find target class");
            }
        } else {
            exit("Could't find target class");
        }
    }

    public static function destroy(string $entity_type, EntityType $type): void {
        $file_name = $entity_type . ".php";
        $destination_directory = dirname(__DIR__);
        $full_path = "";
       switch ($type->value) {
        case "Controller":
            $file_name = $entity_type . ".php";
            $destination_directory .= "\Database\Migrations";
            $full_path = $destination_directory . '/' . $file_name;
            if (file_exists($full_path)) {
                if (unlink($full_path)) {
                    exit ("$type->value deleted successfully.");
                } else {
                    exit("Unable to delete the $type->value: $entity_type.");
                }
            } else {
                exit("$type->value: $entity_type does not exist");
            }
        case "Migration":
            $file_name = $entity_type . ".php";
            $destination_directory .= "\Database\Migrations";
            $full_path = $destination_directory . '/' . $file_name;
            if (file_exists($full_path)) {
                if (unlink($full_path)) {
                    exit ("$type->value deleted successfully.");
                } else {
                    exit("Unable to delete the $type->value: $entity_type.");
                }
            } else {
                exit("$type->value: $entity_type does not exist");
            }
        default:
        exit("Invalid Entity Type");
       }
    }
}
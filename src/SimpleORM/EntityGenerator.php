<?php

namespace generate;


require_once dirname(__DIR__) . "/SimpleORM/EntityManager.php";

use EntityManager\EntityManager;
use Migrations\MigrationMapper;

abstract class generate {
    abstract public static function generate(string $name): void;

    abstract public static function destroy(string $name): void;
}
class generateEntity Extends generate {
    public static function generate(string $migration_name): void {
        $file_name = $migration_name . ".php";
        $destination_directory = dirname(__DIR__) . "\Database\Migrations";
        $full_path = $destination_directory . '/' . $file_name; 
        if (!is_dir($destination_directory)) {
            mkdir($destination_directory, 0777, true);
        }

        if (file_exists($full_path)) {
            echo "Migration $migration_name already exists";
            exit();
        }
        $migration_content = <<<PHP
    <?php

    require_once dirname(__DIR__) . "/SimpleORM/MigrationMapper.php";

    use Entities\Entity;

    class $migration_name extends Entity {
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
        file_put_contents($full_path, $migration_content);
        echo "The $migration_name Entity has been generated at: $full_path\n";
    }

    public static function migrate(string $migration_name): void {
        $file_name = $migration_name . ".php";
        $target_directory = dirname(__DIR__) . "\Database\Migrations";
        $target_file_path = $target_directory . '/' . $file_name;

        if (file_exists($target_file_path)) {
            require_once $target_file_path;
            if (class_exists($migration_name)) {
                $mapper = new MigrationMapper(new $migration_name);
                $manager = new EntityManager($migration_name);
                $manager->up($mapper->map());
            } else {
            exit("Could't find target class");
            }
        } else {
            exit("Could't find target class");
        }
    }

    public static function destroy(string $migration_name): void {
        $file_name = $migration_name . ".php";
        $destination_directory = dirname(__DIR__) . "\Database\Migrations";
        $full_path = $destination_directory . '/' . $file_name;
        if (file_exists($full_path)) {
            if (unlink($full_path)) {
                echo "Migration deleted successfully.";
            } else {
                echo "Unable to delete the Migration: $migration_name.";
            }
        } else {
            exit("Migration: $migration_name does not exist");
        }
    }
}

// class generateController Extends generate {
//     public static function generate(string $controller_name): void {
//         $file_name = $controller_name . ".php";
//         $destination_directory = dirname(__DIR__) . "\Controllers";
//         $full_path = $destination_directory . '/' . $file_name; 
//         if (!is_dir($destination_directory)) {
//             mkdir($destination_directory, 0777, true);
//         }

//         if (file_exists($full_path)) {
//             echo "Controller $controller_name already exists";
//             exit();
//         }
//         $controller_content = <<<PHP
       
//         PHP;
//         file_put_contents($full_path, $controller_content);
//         echo "The $controller_name Controller has been generated at: $full_path\n";
//     }

//     public static function destroy($controller_name): void {
//         $file_name = $controller_name . ".php";
//         $destination_directory = dirname(__DIR__) . "\Controllers";
//         $full_path = $destination_directory . '/' . $file_name;
//         if (file_exists($full_path)) {
//             if (unlink($full_path)) {
//                 echo "Controller deleted successfully.";
//             } else {
//                 echo "Unable to delete the Controller: $controller_name.";
//             }
//         } else {
//             exit("Controller: $controller_name does not exist");
//         }
//     }
// }
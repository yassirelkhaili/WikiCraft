<?php

namespace SimpleKit\SimpleORM;

use SimpleKit\SimpleORM\EntityManager;
use SimpleKit\SimpleORM\MigrationMapper;

enum EntityType: string
{
    case controller = "Controller";
    case migration = "Migration";
    case model = "Model";
}

abstract class Generator {
    abstract public static function generate(string $name, EntityType $Type): void;

    abstract public static function destroy(string $name, EntityType $Type): void;
}

class EntityGenerator Extends Generator {
    public static function generate(string $entity_name, EntityType $type): void {
        $file_name = $entity_name . ".php";
        $destination_directory = dirname(__DIR__);
        $full_path = "";
        $entity_content = "";
        $prefix = self::getPrefix($entity_name);
        $prefixUppercase = ucfirst($prefix);
        $prefixSingular = substr($prefix,0,-1);
        switch ($type->value) {
            case "Controller":
                $destination_directory .= "\Controllers";
                $full_path = $destination_directory . '/' . $file_name;
                if (!is_dir($destination_directory)) mkdir($destination_directory, 0777, true);
                if (file_exists($full_path)) exit("$type->value $entity_name already exists");
                $entity_content = <<<PHP
                <?php
                
                namespace SimpleKit\Controllers;

                use function SimpleKit\Helpers\\redirect;
                use SimpleKit\Models\\{$prefixUppercase};
                use SimpleKit\Helpers\Request;
                
                class {$prefixUppercase}Controller extends BaseController {
                    
                    protected \$$prefix;  // This translates to $prefix
                    
                    public function __construct() {
                        // Instantiate the $prefix and assign it to the protected property
                        \$this->$prefix = new {$prefixUppercase}();
                    }
                
                    public function index() {
                        // Fetch all users using the $prefix
                        \${$prefix} = \$this->{$prefix}->getAll();
                
                        // Render the view and pass the $prefix data to it
                        \$this->render('{$prefixUppercase}/index', ['{$prefix}' => \${$prefix}]);
                    }
                
                    public function create() {
                        // Render the view for creating a new {$prefixSingular}
                        \$this->render('{$prefixSingular}/create');
                    }
             
                    public function store(Request \$request) {
                        \$data = \$request->getPostData();
                        // Create a new {$prefixSingular} using the {$prefix}
                        \$this->{$prefix}->create(\$data);
                
                        // Redirect back to the index page with a success message (or handle differently based on your needs)
                        // You can also render a view or return a JSON response
                        return redirect('/books')->with(['success' => 'book created successfully!']);  // Note the change here
                    }

                    public function show(int \$id) {
                        // Fetch a specific {$prefixSingular} by ID using the {$prefix}
                        \$$prefixSingular = \$this->{$prefix}->getById(\$id);
                
                        // Render the view and pass the {$prefixSingular} data to it
                        \$this->render('{$prefixSingular}/show', ['{$prefixSingular}]' => \$$prefixSingular]);
                        /*
                        with javascript:
                        http_response_code(200);
                        echo json_encode(\$book);
                        */
                    }
                
                    public function edit(int \$id) {
                        // Fetch a specific {$prefixSingular} by ID using the {$prefix}
                        \$$prefixSingular = \$this->{$prefix}->getById(\$id);
                
                        // Render the view for editing the {$prefixSingular}
                        \$this->render('{$prefixSingular}/edit', ['{$prefixSingular}' => \$$prefixSingular]);
                    }

                    public function update(Request \$request, int \$id) {
                        // Validate the request data (assuming a simple validation here)
                        \$data = \$request->getPostData();
                        
                        // Update the {$prefixSingular} using the {$prefix}Modal
                        \$this->{$prefix}->updateById(\$id, \$data);
                
                        // Redirect back to the index page with a success message (or handle differently based on your needs)
                        return redirect('/{$prefix}')->with(['modified' => '{$prefixSingular} has been updated!']);
                    }

                    public function destroy(\$id) {
                        // Delete a specific {$prefixSingular} by ID using the {$prefix}
                        \$this->{$prefix}->deleteById(\$id);
                
                        // Redirect back to the index page with a success message (or handle differently based on your needs)
                        return redirect('/{$prefix}')->with(['destroy' => '{$prefixSingular} was deleted']);
                    }
                
                    // You can add more controller methods as needed to handle other {$prefixSingular}-related functionalities
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
        
            use SimpleKit\SimpleORM\Migration;
        
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
            case "Model":
                $modelPrefix = self::getPrefix($entity_name);
                $destination_directory .= "\Models";
                $full_path = $destination_directory . '/' . $file_name;
                if (!is_dir($destination_directory)) mkdir($destination_directory, 0777, true);
                if (file_exists($full_path)) exit("$type->value $entity_name already exists");
                $entity_content = <<<PHP
            <?php

                namespace SimpleKit\Models;
                
                use SimpleKit\SimpleORM\EntityManager;
                
                class $prefixUppercase {
                    private \$entity;
                
                    public function __construct() {
                        \$this->entity = new EntityManager("Users");
                    }
                
                    public function create(\$data) {
                        \$this->entity->saveMany([\$data]);
                    }
                
                    public function getAll() {
                        return \$this->entity->fetchAll()->get();
                    }
                
                    public function getById(\$id) {
                        return \$this->entity->fetchAll()->where("id", \$id)->get(1);
                    }
                
                    public function updateById(\$id, \$data) {
                        \$this->entity->update(\$data)->where("id", \$id)->confirm();
                    }
                
                    public function deleteById(\$id) {
                        \$this->entity->delete()->where("id", \$id)->confirm();
                    }
                
                    // Add other methods as needed to interact with the Users entity using SimpleORM
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
            $destination_directory .= "\Controllers";
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
            case "Model":
                $file_name = $entity_type . ".php";
                $destination_directory .= "\Models";
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
    //helper with controller generating naming
    private static function getPrefix (string $entity_name): string {
        $prefix = str_replace('Controller', '', $entity_name);
        $prefix = strtolower($prefix);
        return $prefix;
    }
}
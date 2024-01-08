<?php

use SimpleKit\SimpleORM\Migration;
class Admin extends Migration {
    /**
     * @var int
     *
     * @Config(type="int", primary=true, autoIncrement=true, notNull=true)
     * The unique identifier for the user.
     */
    private int $id;

    /**
     * @var string
     *
     * @Config(type="varchar", length=255, notNull=true)
     * The name of the user.
     */
    private string $name;

    /**
     * @var string
     *
     * @Config(type="varchar", length=255, notNull=true, unique=true)
     * The email address of the user, which must be unique.
     */
    private string $email;

    /**
     * Get the configuration for each property.
     *
     * @return array
     * An associative array where keys are property names, and values are property configurations.
     */
    public static function getPropertyConfig(): array {
        return [
            'id' => ['type' => 'int', 'primary' => true, 'autoIncrement' => true, 'notNull' => true],
        ];
    }
}
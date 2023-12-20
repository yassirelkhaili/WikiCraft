<?php

namespace Migrations;

use ReflectionClass, ReflectionProperty;

abstract class Migration {
    public static function getPropertyConfig(): array {
        return [];
    }
 }

class MigrationMapper {
    private Migration $entity;
    public function __construct(Migration $entity) {
        $this->entity = $entity;
    }
    public function map(): array {
        $entity_name = get_class($this->entity);
        $reflection_class = new ReflectionClass($entity_name);
        $property_mapping = $this->typeMapper($reflection_class);
        $entity_mapping = [
            "entityName" => $entity_name,
            "entityProperties" => $property_mapping,
        ];
       return $entity_mapping;
    }

    public function typeMapper (ReflectionClass $reflection_class): array {
        $property_mapping = array();
        $entity_name = get_class($this->entity);
        $method_name = "getPropertyConfig";
        if ($reflection_class->getMethod($method_name)->class == $entity_name) {
            $type_array = $this->entity->getPropertyConfig();
            foreach($type_array as $property_name => $property_type) {
                $property_mapping[$property_name] = $property_type;
            }
            return $property_mapping;
        } else {
            echo("Warning: getPropertyConfig method doesn't exist in " . $entity_name . "\n" ."default field values will be generated instead");
            $entity_properties = $reflection_class->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
        foreach ($entity_properties as $index => $property) {
            $property_name = $property->getName();
            $property_type = $this->getPropertyType($property);
            $property_mapping[$property_name] = $property_type;
        }
        }
        return $property_mapping;
    }
    private function getPropertyType(ReflectionProperty $property): ?string {
        $type = null;
        if ($property->hasType()) {
            $property_type = $property->getType();
            $type = $property_type->isBuiltin() ? $property_type->getName() : null;
        }
        return $type;
    }
}
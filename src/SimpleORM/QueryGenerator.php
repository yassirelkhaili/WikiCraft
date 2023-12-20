<?php

namespace queries;

class QueryGenerator
{
    private array $whereConditions = array();
    private array $conditions = array();

    private array $updateConditions = array();

    private array $orderByFields = array();

    private string $orderByDirection = "ASC";
    private string $chainedQuery = "";
    private string $entity_name;

    public function __construct(string $entity_name)
    {
        $this->entity_name = $entity_name;
    }

    public static function generateTableQuery(array $columns): string
    {
        $query = "CREATE TABLE IF NOT EXISTS {$columns['entityName']} (";
        $columnNames = array_keys($columns["entityProperties"]);
        $index = 0;
        foreach ($columns["entityProperties"] as $columnProperty) {
            $columnName = $columnNames[$index];
            $type = $columnProperty['type'];
            $query .= "$columnName $type";

            if (isset($columnProperty['length'])) {
                $length = $columnProperty['length'];
                $query .= "($length)";
            }

            if (isset($columnProperty['notNull']) && $columnProperty['notNull']) {
                $query .= " NOT NULL";
            }

            if (isset($columnProperty['autoIncrement']) && $columnProperty['autoIncrement']) {
                $query .= " AUTO_INCREMENT";
            }

            if (isset($columnProperty['primary']) && $columnProperty['primary']) {
                $query .= " PRIMARY KEY";
            }

            if (isset($columnProperty['unique']) && $columnProperty['unique']) {
                $query .= " UNIQUE";
            }

            $query .= ",";
            $index++;
        }

        $query = rtrim($query, ',');
        $query .= ");";
        return $query;
    }

    public static function insertRecord(array $data, string $entity_name): string
    {
        $query = "INSERT INTO $entity_name (";
        $columnNames = array_keys($data);
        $query .= implode(", ", $columnNames);
        $query .= ") VALUES (";
        foreach ($columnNames as $columnName) {
            $query .= ":" . $columnName . ", ";
        }
        $query = rtrim($query, ', ');
        $query .= ");";
        return $query;
    }

    public function generateFetchAllQuery(): string
    {
        $this->chainedQuery .= "SELECT * FROM {$this->entity_name}";
        return $this->chainedQuery;
    }

    public function generateDeleteQuery(): string
    {
        $this->chainedQuery .= "DELETE FROM {$this->entity_name}";
        return $this->chainedQuery;
    }

    public function generateUpdateQuery(string $column, $value): string
    {
        $this->chainedQuery .= "UPDATE {$this->entity_name} SET $column = '$value'";
        return $this->chainedQuery;
    }

    public function generateUpdateQueryMultiple(array $data): string
    {
        $this->chainedQuery .= "UPDATE {$this->entity_name} SET ";
        foreach ($data as $key => $value) {
            $this->chainedQuery .= "$key = :$key, ";
            $this->updateConditions[$key] = $value;
        }
        $this->chainedQuery = rtrim($this->chainedQuery, ', ');
        return $this->chainedQuery;
    }

    public function stashWhereCondition(string $column, $value): void
    {
        $this->whereConditions[] = compact('column', 'value');
    }

    public function generateFinalQuery(int $limit_count = 0): string
    {
        if (!empty($this->whereConditions)) {
            $conditions = [];
            foreach ($this->whereConditions as $condition) {
                $conditions[] = "{$condition['column']} = :{$condition['column']}";
                $this->conditions[$condition['column']] = $condition['value'];
            }
            $this->chainedQuery .= " WHERE " . implode(' AND ', $conditions);
        }

        // (ORDER BY, LIMIT) are to be handled here
        if (!empty($this->orderByFields)) {
            $this->chainedQuery .= " ORDER BY ";
            foreach ($this->orderByFields as $field) {
                $this->chainedQuery .= "$field, ";
            }
            $this->chainedQuery = rtrim($this->chainedQuery, ", ");
            $this->chainedQuery .= " {$this->orderByDirection}";
        }
        if ($limit_count > 0) $this->chainedQuery .= " LIMIT $limit_count";
        return $this->chainedQuery . ";";
    }

    // utility method to fetch Conditions to be used in the prepare statement
    public function exportWhereConditions()
    {
        return $this->conditions;
    }

    public function exportUpdateConditions()
    {
        return $this->updateConditions;
    }

    public function flushChainedQuery(): void
    {
        $this->chainedQuery = "";
    }

    public function generateCountQuery(): string
    {
        $query = "SELECT COUNT(*) as count FROM {$this->entity_name};";
        return $query;
    }

    public function setOrderByConditions(array $fields, $direction = "ASC"): void
    {
       $this->orderByFields = $fields;
       $this->orderByDirection = $direction;
    }
}

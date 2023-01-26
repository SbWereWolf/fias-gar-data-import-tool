<?php

namespace SbWereWolf\FiasGarDataImport\Import\Composition;

use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class Composer implements JsonSerializable
{
    use JsonSerializeTrait;

    /** @var IColumn[] Колонки участвующие в запросе к БД */
    private array $columns;
    private string $tableName;
    private array $bindings;

    public function __construct(string $tableName, array $bindings)
    {
        $this->bindings = $bindings;

        $columns = array_keys($bindings);
        $suitable = array_filter($columns, [$this, 'isSuitable']);
        $this->columns = array_map([$this, 'setupColumn'], $suitable);

        $this->tableName = $tableName;
    }

    public function makeSelectQuery(): string
    {
        $wherePhraseParts = [];
        foreach ($this->columns as $column) {
            $letUse = $column::shouldUseForSelect();
            if ($letUse) {
                $wherePhraseParts[] =
                    $column->getForWherePhrase();
            }
        }

        $wherePhrase = implode(' AND ', $wherePhraseParts);
        $select = "
SELECT NULL FROM {$this->tableName} WHERE $wherePhrase";

        return $select;
    }

    public function makeSelectBindings(): array
    {
        $bindingsForSelect = [];
        foreach ($this->bindings as $class => $var) {
            /** @var IColumn $class */
            $letUse = $class::shouldUseForSelect();
            if ($letUse) {
                /** @var IColumn $exemplar */
                $exemplar = new $class();
                $key = $exemplar->getParam();
                $bindingsForSelect[$key] = &$this->bindings[$class];
            }
        }

        return $bindingsForSelect;
    }

    public function makeInsertQuery(): string
    {
        $columnParts = [];
        $valueParts = [];
        foreach ($this->columns as $column) {
            $columnParts[] = $column->getColumnForInsert();
            $valueParts[] = $column->getParam();
        }

        $columnPhrase = implode(',', $columnParts);
        $valuePhrase = implode(',', $valueParts);
        $insert = "
INSERT INTO {$this->tableName}($columnPhrase)VALUES($valuePhrase)";

        return $insert;
    }

    public function makeUpdateQuery(): string
    {
        $wherePhraseParts = [];
        $setPhraseParts = [];
        foreach ($this->columns as $column) {
            $wherePhraseParts[] = $column->getForWherePhrase();

            $letUse = $column::shouldUseForUpdate();
            if ($letUse) {
                $setPhraseParts[] = $column->getColumnForUpdate();
            }
        }
        $setPhrase = implode(',', $setPhraseParts);
        $wherePhrase = implode(' AND ', $wherePhraseParts);
        $update = "
UPDATE {$this->tableName} SET $setPhrase WHERE $wherePhrase";

        return $update;
    }

    /**
     * @return array
     */
    public function makeBindings(): array
    {
        $bindings = [];
        foreach ($this->bindings as $class => $var) {
            /** @var IColumn $exemplar */
            $exemplar = new $class();
            $key = $exemplar->getParam();
            $bindings[$key] = &$this->bindings[$class];
        }

        return $bindings;
    }

    public function bindData(array $data): array
    {
        $bindingsForUpdate = [];
        foreach ($this->bindings as $class => $var) {
            /** @var IColumn $exemplar */
            $exemplar = new $class();
            $column = $exemplar->getColumnForInsert();
            if ($column === 'REGION') {
                continue;
            }
            if ($column === 'DESCR') {
                $column = 'DESC';
            }

            $hasDefault = $exemplar::hasDefaultValue();
            if (!$hasDefault) {
                $val = $data[$column];
            }
            if ($hasDefault) {
                $default = $exemplar->getDefaultValue();
                $val = $data[$column] ?? $default;
            }

            $value = $exemplar::convertToDbValue($val);
            $this->bindings[$class] = $value;
        }

        return $bindingsForUpdate;
    }

    private function isSuitable(string $class): bool
    {
        $isSuitable = is_a($class, IColumn::class, true);

        return $isSuitable;
    }

    private function setupColumn(string $class)
    {
        $exemplar = new $class();

        return $exemplar;
    }
}
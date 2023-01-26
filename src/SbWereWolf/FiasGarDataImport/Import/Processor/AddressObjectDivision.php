<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChildIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ParentIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class AddressObjectDivision extends Importer
{
    private const TABLE_NAME = 'ADDR_OBJ_DIVISION';
    private int $id = -1;
    private int $parentId = -1;
    private int $childId = -1;
    private int $changeId = -1;

    public function __construct(PDO $connection)
    {
        $columns = [
            RegionColumn::class => &$this->region,
            IdColumn::class => &$this->id,
            ParentIdColumn::class => &$this->parentId,
            ChildIdColumn::class => &$this->childId,
            ChangeIdDataColumn::class => &$this->changeId,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
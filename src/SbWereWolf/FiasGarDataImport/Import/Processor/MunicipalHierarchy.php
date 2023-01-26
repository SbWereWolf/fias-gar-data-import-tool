<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\EndDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IsActiveColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NextIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ObjectIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\OktmoColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ParentObjectIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\PathColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\PreviousIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\StartDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\UpdateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class MunicipalHierarchy extends Importer
{
    private const TABLE_NAME = 'MUN_HIERARCHY';
    private int $id = -1;
    private int $objectId = -1;
    private int $parentObjId = -1;
    private int $changeId = -1;
    private string $oktmo = '';
    private int $prevId = -1;
    private int $nextId = -1;
    private string $updateDate = '1900-01-01';
    private string $startDate = '1900-01-01';
    private string $endDate = '2079-06-06';
    private int $isActive = -1;
    private string $path = '';

    public function __construct(PDO $connection)
    {
        $columns = [
            RegionColumn::class => &$this->region,
            IdColumn::class => &$this->id,
            ObjectIdDataColumn::class => &$this->objectId,
            ParentObjectIdColumn::class => &$this->parentObjId,
            ChangeIdDataColumn::class => &$this->changeId,
            OktmoColumn::class => &$this->oktmo,
            PreviousIdColumn::class => &$this->prevId,
            NextIdColumn::class => &$this->nextId,
            UpdateDateColumn::class => &$this->updateDate,
            StartDateColumn::class => &$this->startDate,
            EndDateColumn::class => &$this->endDate,
            IsActiveColumn::class => &$this->isActive,
            PathColumn::class => &$this->path,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
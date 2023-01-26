<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\CreateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IsActiveColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\LevelIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ObjectGuidColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ObjectIdKeyColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\UpdateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class ReestrObjects extends Importer
{
    private const TABLE_NAME = 'REESTR_OBJECTS';
    private int $objectId = -1;
    private string $objectGuid = '';
    private string $createDate = '1900-01-01';
    private int $changeId = -1;
    private int $levelId = -1;
    private string $updateDate = '1900-01-01';
    private int $isActive = -1;

    public function __construct(PDO $connection)
    {
        $columns = [
            RegionColumn::class => &$this->region,
            ObjectIdKeyColumn::class => &$this->objectId,
            ObjectGuidColumn::class => &$this->objectGuid,
            CreateDateColumn::class => &$this->createDate,
            ChangeIdDataColumn::class => &$this->changeId,
            LevelIdColumn::class => &$this->levelId,
            UpdateDateColumn::class => &$this->updateDate,
            IsActiveColumn::class => &$this->isActive,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\AdditionalNumber1Column;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\AdditionalNumber2Column;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\AdditionalType1Column;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\AdditionalType2Column;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\EndDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\HouseNumberColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IsActiveColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IsActualColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NextIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ObjectGuidColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ObjectIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\OperationTypeIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\PreviousIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\StartDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\UpdateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class Houses extends Importer
{
    private const TABLE_NAME = 'HOUSES';
    private int $id = -1;
    private int $objectId = -1;
    private string $objectGuid = '';
    private int $changeId = -1;
    private string $houseNum = '';
    private string $addNum1 = '';
    private string $addNum2 = '';
    private int $addType1 = -1;
    private int $addType2 = -1;
    private int $operTypeId = -1;
    private int $prevId = -1;
    private int $nextId = -1;
    private string $updateDate = '1900-01-01';
    private string $startDate = '1900-01-01';
    private string $endDate = '2079-06-06';
    private int $isActual = -1;
    private int $isActive = -1;

    public function __construct(PDO $connection)
    {
        $columns = [
            RegionColumn::class => &$this->region,
            IdColumn::class => &$this->id,
            ObjectIdDataColumn::class => &$this->objectId,
            ObjectGuidColumn::class => &$this->objectGuid,
            ChangeIdDataColumn::class => &$this->changeId,
            HouseNumberColumn::class => &$this->houseNum,
            AdditionalNumber1Column::class => &$this->addNum1,
            AdditionalNumber2Column::class => &$this->addNum2,
            AdditionalType1Column::class => &$this->addType1,
            AdditionalType2Column::class => &$this->addType2,
            OperationTypeIdColumn::class => &$this->operTypeId,
            PreviousIdColumn::class => &$this->prevId,
            NextIdColumn::class => &$this->nextId,
            UpdateDateColumn::class => &$this->updateDate,
            StartDateColumn::class => &$this->startDate,
            EndDateColumn::class => &$this->endDate,
            IsActualColumn::class => &$this->isActual,
            IsActiveColumn::class => &$this->isActive,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
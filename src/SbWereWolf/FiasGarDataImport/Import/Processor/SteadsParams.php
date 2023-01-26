<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeIdEndColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\EndDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ObjectIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\StartDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\TypeIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\UpdateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ValueColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class SteadsParams extends Importer
{
    private const TABLE_NAME = 'STEADS_PARAMS';
    private int $id = -1;
    private int $objectId = -1;
    private int $changeId = -1;
    private int $changeIdEnd = -1;
    private int $typeId = -1;
    private string $value = '';
    private string $updateDate = '1900-01-01';
    private string $startDate = '1900-01-01';
    private string $endDate = '2079-06-06';

    public function __construct(PDO $connection)
    {
        $columns = [
            RegionColumn::class => &$this->region,
            IdColumn::class => &$this->id,
            ObjectIdDataColumn::class => &$this->objectId,
            ChangeIdDataColumn::class => &$this->changeId,
            ChangeIdEndColumn::class => &$this->changeIdEnd,
            TypeIdColumn::class => &$this->typeId,
            ValueColumn::class => &$this->value,
            UpdateDateColumn::class => &$this->updateDate,
            StartDateColumn::class => &$this->startDate,
            EndDateColumn::class => &$this->endDate,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
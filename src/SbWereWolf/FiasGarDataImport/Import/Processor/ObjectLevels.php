<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\EndDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IsActiveColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\LevelKeyColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NameColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ShortNameColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\StartDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\UpdateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class ObjectLevels extends Importer
{
    private const TABLE_NAME = 'OBJECTLEVELS';
    private int $level = -1;
    private string $name = '';
    private string $shortName = '';
    private string $updateDate = '1900-01-01';
    private string $startDate = '1900-01-01';
    private string $endDate = '2079-06-06';
    private int $isActive = -1;


    public function __construct(PDO $connection)
    {
        $columns = [
            LevelKeyColumn::class => &$this->level,
            ShortNameColumn::class => &$this->shortName,
            NameColumn::class => &$this->name,
            UpdateDateColumn::class => &$this->updateDate,
            StartDateColumn::class => &$this->startDate,
            EndDateColumn::class => &$this->endDate,
            IsActiveColumn::class => &$this->isActive,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
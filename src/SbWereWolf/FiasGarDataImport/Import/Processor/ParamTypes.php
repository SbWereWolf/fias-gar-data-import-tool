<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\CodeColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\DescriptionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\EndDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IsActiveColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NameColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\StartDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\UpdateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class ParamTypes extends Importer
{
    private const TABLE_NAME = 'PARAMTYPES';
    private int $id = -1;
    private string $name = '';
    private string $code = '';
    private string $descr = '';
    private string $updateDate = '1900-01-01';
    private string $startDate = '1900-01-01';
    private string $endDate = '2079-06-06';
    private int $isActive = -1;

    public function __construct(PDO $connection)
    {
        $columns = [
            IdColumn::class => &$this->id,
            NameColumn::class => &$this->name,
            CodeColumn::class => &$this->code,
            DescriptionColumn::class => &$this->descr,
            UpdateDateColumn::class => &$this->updateDate,
            StartDateColumn::class => &$this->startDate,
            EndDateColumn::class => &$this->endDate,
            IsActiveColumn::class => &$this->isActive,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
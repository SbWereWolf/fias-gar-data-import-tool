<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\EndDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NameColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\StartDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class NormativeDocumentsTypes extends Importer
{
    private const TABLE_NAME = 'NDOCTYPES';
    private int $id = -1;
    private string $name = '';
    private string $startDate = '1900-01-01';
    private string $endDate = '2079-06-06';


    public function __construct(PDO $connection)
    {
        $columns = [
            IdColumn::class => &$this->id,
            NameColumn::class => &$this->name,
            StartDateColumn::class => &$this->startDate,
            EndDateColumn::class => &$this->endDate,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
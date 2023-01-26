<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NameColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class NormativeDocumentsKinds extends Importer
{
    private const TABLE_NAME = 'NDOCKINDS';
    private int $id = -1;
    private string $name = '';

    public function __construct(PDO $connection)
    {
        $columns = [
            IdColumn::class => &$this->id,
            NameColumn::class => &$this->name,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
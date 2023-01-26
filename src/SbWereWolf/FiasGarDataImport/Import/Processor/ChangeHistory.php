<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\AddressObjectIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ChangeIdKeyColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NormativeDocumentIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\ObjectIdDataColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\OperationTypeIdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class ChangeHistory extends Importer
{
    private const TABLE_NAME = 'CHANGE_HISTORY';
    private int $changeId = -1;
    private int $objectId = -1;
    private string $adrObjectId = '';
    private int $operTypeId = -1;
    private int $nDocId = -1;
    private string $changeDate = '1900-01-01';

    public function __construct(PDO $connection)
    {
        $columns = [
            RegionColumn::class => &$this->region,
            ChangeIdKeyColumn::class => &$this->changeId,
            ObjectIdDataColumn::class => &$this->objectId,
            AddressObjectIdColumn::class => &$this->adrObjectId,
            OperationTypeIdColumn::class => &$this->operTypeId,
            NormativeDocumentIdColumn::class => &$this->nDocId,
            ChangeDateColumn::class => &$this->changeDate,
        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
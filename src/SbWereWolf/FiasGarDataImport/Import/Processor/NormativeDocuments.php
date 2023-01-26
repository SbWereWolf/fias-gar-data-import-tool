<?php

namespace SbWereWolf\FiasGarDataImport\Import\Processor;


use PDO;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\AcceptanceDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\CommentColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\DateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\IdColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\KindColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NameColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\NumberColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\OrganizationNameColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegionColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegistrationDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\RegistrationNumberColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\TypeColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Column\UpdateDateColumn;
use SbWereWolf\FiasGarDataImport\Import\Composition\Composer;
use SbWereWolf\FiasGarDataImport\Import\Importer;

class NormativeDocuments extends Importer
{
    private const TABLE_NAME = 'NORMDOCS';
    private int $id = -1;
    private string $name = '';
    private string $date = '1900-01-01';
    private string $number = '';
    private int $type = -1;
    private int $kind = -1;

    private string $updateDate = '1900-01-01';

    private string $orgName = '';
    private string $regNum = '';
    private string $regDate = '1900-01-01';
    private string $accDate = '1900-01-01';
    private string $comment = '';

    public function __construct(PDO $connection)
    {
        $columns = [
            RegionColumn::class => &$this->region,
            IdColumn::class => &$this->id,
            NameColumn::class => &$this->name,
            DateColumn::class => &$this->date,
            NumberColumn::class => &$this->number,
            TypeColumn::class => &$this->type,
            KindColumn::class => &$this->kind,
            UpdateDateColumn::class => &$this->updateDate,
            OrganizationNameColumn::class => &$this->orgName,
            RegistrationNumberColumn::class => &$this->regNum,
            RegistrationDateColumn::class => &$this->regDate,
            AcceptanceDateColumn::class => &$this->accDate,
            CommentColumn::class => &$this->comment,

        ];

        $this->compositor = new Composer(static::TABLE_NAME, $columns);

        parent::__construct($connection);
    }
}
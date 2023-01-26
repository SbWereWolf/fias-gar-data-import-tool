<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Cli;

use JsonSerializable;
use PDO;
use Psr\Log\LoggerInterface;
use SbWereWolf\FiasGarDataImport\FileInput\FileFinder;
use SbWereWolf\FiasGarDataImport\FileInput\FileReader;
use SbWereWolf\FiasGarDataImport\Import\Importer;
use SbWereWolf\FiasGarDataImport\Import\ImportStatus;
use SbWereWolf\FiasGarDataImport\Import\ImportSummary;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class ImportCommand implements JsonSerializable
{
    use JsonSerializeTrait;

    /*const BYTES_TO_MEGABYTES = 1024 * 1024;*/
    private LoggerInterface $logger;
    private PDO $connection;
    private string $directory;

    /**
     * @param PDO $connection
     * @param LoggerInterface $logger
     * @param string $directory
     */
    public function __construct(
        PDO $connection,
        LoggerInterface $logger,
        string $directory,
    ) {
        $this->connection = $connection;
        $this->logger = $logger;
        $this->directory = $directory;
    }

    public function run(ImportOptions $options, int $reportEach)
    {
        $this->getLogger()->notice('Import starting');

        $currentStatus = new ImportStatus(
            0,
            0,
            0,
            0,
            0,
            0,
        );

        $rowsRead = 0;
        $successOperations = 0;
        $reader = new FileReader();

        $finder = new FileFinder($this->directory);

        $doAddNewWithCheck = $options->isDoAddNewWithCheck();

        $this->getLogger()->warning('Starting common reference import');
        foreach (
            $options->nextCommonReferenceFilePattern()
            as $class => $pattern
        ) {
            $message = 'Start import files of pattern ' . $pattern;
            $this->getLogger()->notice($message);
            /** @var Importer $importer */
            $importer = new $class($this->connection);

            foreach (
                $finder->find(
                    $pattern,
                ) as $searchResult
            ) {
                $dataFile = $searchResult->getFilename();
                $message = 'Starting import file ' . $dataFile;
                $this->getLogger()->info($message);

                foreach ($reader->read($dataFile) as $values) {
                    $rowsRead++;

                    if ($doAddNewWithCheck) {
                        $isSuccess = $importer->updateData($values);
                    }
                    if (!$doAddNewWithCheck) {
                        $isSuccess = $importer->importData($values);
                    }

                    if ($isSuccess) {
                        $successOperations++;
                    }
                    $letReport = $successOperations % $reportEach == 0;
                    if ($letReport) {
                        $processingStatus = $importer->getReport();
                        $processingSummary = new ImportSummary(
                            $currentStatus, $processingStatus
                        );
                        $interim = $processingSummary->getStatus();
                        $this->outputReport(
                            $rowsRead,
                            $successOperations,
                            $interim,
                        );
                    }

                    yield $isSuccess;
                }
            }

            $processingStatus = $importer->getReport();
            $processingSummary = new ImportSummary(
                $currentStatus, $processingStatus
            );

            $currentStatus = $processingSummary->getStatus();
            $this->outputReport(
                $rowsRead,
                $successOperations,
                $currentStatus
            );

            $message = 'Finish import files of pattern ' . $pattern;
            $this->getLogger()->notice($message);
        }

        $parts = [
            rtrim($this->directory, DIRECTORY_SEPARATOR),
            $options->getRegionDataDirectoryPattern(),
            '',
        ];
        $directoryPattern = implode(DIRECTORY_SEPARATOR, $parts);

        $finder = new FileFinder($directoryPattern);

        $this->getLogger()->warning('Starting region data import');
        foreach (
            $options->nextRegionDataFilePattern()
            as $class => $pattern
        ) {
            $message = 'Start import files of pattern ' . $pattern;
            $this->getLogger()->notice($message);
            /** @var Importer $importer */
            $importer = new $class($this->connection);
            foreach (
                $finder->find(
                    $pattern,
                ) as $searchResult
            ) {
                $dataFile = $searchResult->getFilename();
                $message = 'Starting import file ' . $dataFile;
                $this->getLogger()->info($message);

                $region = (int)$searchResult->getDirectory();

                foreach ($reader->read($dataFile) as $values) {
                    $rowsRead++;

                    if ($doAddNewWithCheck) {
                        $isSuccess =
                            $importer->updateData($values, $region);
                    }
                    if (!$doAddNewWithCheck) {
                        $isSuccess =
                            $importer->importData($values, $region);
                    }

                    if ($isSuccess) {
                        $successOperations++;
                    }
                    $letReport = $successOperations % $reportEach == 0;
                    if ($letReport) {
                        $processingStatus = $importer->getReport();
                        $processingSummary = new ImportSummary(
                            $currentStatus,
                            $processingStatus,
                        );
                        $interim = $processingSummary->getStatus();
                        $this->outputReport(
                            $rowsRead,
                            $successOperations,
                            $interim,
                        );
                    }

                    yield $isSuccess;
                }
            }

            $processingStatus = $importer->getReport();
            $processingSummary = new ImportSummary(
                $currentStatus,
                $processingStatus,
            );

            $currentStatus = $processingSummary->getStatus();
            $this->outputReport(
                $rowsRead,
                $successOperations,
                $currentStatus
            );

            $message = 'Finish import files of pattern ' . $pattern;
            $this->getLogger()->notice($message);
        }

        $this->getLogger()->warning('Finish region data import');
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param int $rowsRead
     * @param int $successOperations
     * @param ImportStatus $report
     * @return void
     */
    private function outputReport(
        int $rowsRead,
        int $successOperations,
        ImportStatus $report
    ): void {
        $successInserts = $report->getSuccessInserts();
        $failureInserts = $report->getFailureInserts();
        $insertAffected = $report->getInsertAffected();
        $successUpdates = $report->getSuccessUpdates();
        $failureUpdates = $report->getFailureUpdates();
        $updateAffected = $report->getUpdateAffected();
        /*        $scriptMem = round(
                    $report->getScriptMem() / static::BYTES_TO_MEGABYTES,
                    1
                );
                $scriptAllocated = round(
                    $report->getAllocatedMem() / static::BYTES_TO_MEGABYTES,
                    1
                );
                $scriptMaxMem = round(
                    $report->getScriptMaxMem() / static::BYTES_TO_MEGABYTES,
                    1
                );*/

        $formatted = number_format($rowsRead, 0, ',', ' ');
        $report =
            "rows Read `{$formatted}`," .
            " success Operations `{$successOperations}`," .
            " success Inserts `{$successInserts}`," .
            " insert Affected `{$insertAffected}`," .
            " failure Inserts `{$failureInserts}`," .
            " success Updates `{$successUpdates}`," .
            " update Affected `{$updateAffected}`," .
            " failure Updates `{$failureUpdates}`";

        $this->getLogger()->debug($report);
    }
}
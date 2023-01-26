<?php

declare(strict_types=1);

namespace SbWereWolf\FiasGarDataImport\Import;

use JsonSerializable;
use SbWereWolf\JsonSerializable\JsonSerializeTrait;

class Telemetry implements JsonSerializable
{
    use JsonSerializeTrait;

    private int $successInserts;
    private int $insertAffected;
    private int $failureInserts;
    private int $successUpdates;
    private int $updateAffected;
    private int $failureUpdates;

    public function __construct()
    {
        $this->successInserts = 0;
        $this->insertAffected = 0;
        $this->failureInserts = 0;
        $this->successUpdates = 0;
        $this->updateAffected = 0;
        $this->failureUpdates = 0;
    }

    public function reportStatus(): ImportStatus
    {
        /*$scriptMem = memory_get_usage(false);
        $scriptAllocated = memory_get_usage(true);
        $scriptMaxMem = memory_get_peak_usage(true);*/

        $status = new ImportStatus(
            $this->successInserts,
            $this->insertAffected,
            $this->failureInserts,
            $this->successUpdates,
            $this->updateAffected,
            $this->failureUpdates,
        );

        return $status;
    }

    public function registrate(
        bool $wasDataExist,
        bool $isOperationSuccess,
        int $insertedRecords,
        int $updatedRecords
    ) {
        if (!$wasDataExist && $isOperationSuccess) {
            $this->registrateOneSuccessInsert();
            $this->registrateInsertAffectedRows($insertedRecords);
        }
        if (!$wasDataExist && !$isOperationSuccess) {
            $this->registrateOneFailureInsert();
        }
        if ($wasDataExist && $isOperationSuccess) {
            $this->registrateOneSuccessUpdate();
            $this->registrateUpdateAffectedRows($updatedRecords);
        }
        if ($wasDataExist && !$isOperationSuccess) {
            $this->registrateOneFailureUpdate();
        }
    }

    private function registrateOneSuccessInsert(): int
    {
        $this->successInserts++;
        return $this->successInserts;
    }

    private function registrateInsertAffectedRows(
        int $numberOfRows
    ): int {
        $this->insertAffected += $numberOfRows;
        return $this->insertAffected;
    }

    private function registrateOneFailureInsert(): int
    {
        $this->failureInserts++;
        return $this->failureInserts;
    }

    private function registrateOneSuccessUpdate(): int
    {
        $this->successUpdates++;
        return $this->successUpdates;
    }

    private function registrateUpdateAffectedRows(
        int $numberOfRows
    ): int {
        $this->updateAffected += $numberOfRows;
        return $this->updateAffected;
    }

    private function registrateOneFailureUpdate(): int
    {
        $this->failureUpdates++;
        return $this->failureUpdates;
    }
}